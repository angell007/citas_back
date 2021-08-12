<?php

namespace App\Http\Controllers\DataInit;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Paciente;
use App\Models\Patient;
use App\Services\EcoopsosService;
use App\Services\MedimasService;
use App\Services\PersonService;
use App\Services\SpecialitysDoctorsService;
use App\Traits\ApiResponser;
use App\Traits\HandlerContructTablePerson;
use Illuminate\Support\Facades\Log;


class PersonController extends Controller
{
    use ApiResponser, HandlerContructTablePerson;

    public  $medimasService;
    public  $ecoopsosService;
    public  $patient;
    public  $message;
    public $specialitysDoctorsService;

    public function __construct(PersonService $personService, SpecialitysDoctorsService $specialitysDoctorsService)
    {
        $this->personService = $personService;
        $this->specialitysDoctorsService = $specialitysDoctorsService;
        $this->documentypes  = collect([]);
    }

    public function get()
    {
        try {
            $this->persons = json_decode($this->personService->get(), true);
            handlerTableCreate($this->persons);
            return $this->success('Tabla creada Correctamente');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function store()
    {
        try {

            $this->persons = json_decode($this->personService->get(), true);
            $this->handlerInsertTable($this->persons);
            return $this->success('Datos insertados Correctamente');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function customUpdate()
    {

        $documentType =  request()->get('tipo_documento');
        $documentNumber =  request()->get('identificacion');

        if ($this->createOrUpdatePatient($documentType, $documentNumber)) {
            return response(['message' => $this->message, 'data' => $this->patient]);
        }
        return $this->success(['EnBase' => 'No', 'paciente' => 'PACIENTE NO REGISTRADO EN BASE DE DATOS']);
    }

    public function customUpdateOld($identificacion, $tipo_documento)
    {
        $documentType =  $tipo_documento;
        $documentNumber =  $identificacion;

        Log::info([$documentType, $documentNumber]);

        if ($this->createOrUpdatePatient($documentType, $documentNumber)) {
            return $this->success(['EnBase' => $this->message, 'paciente' => $this->patient]);
        }
        return $this->success(['EnBase' => 'No', 'paciente' => 'PACIENTE NO REGISTRADO EN BASE DE DATOS']);
    }


    public function createOrUpdatePatient($documentType, $documentNumber)
    {
        $dataPatient = $this->searchPatientInServices($documentType, $documentNumber);

        if (count($dataPatient) == 0) {
            return false;
        }

        $this->patient = Patient::with(
            'eps',
            'company',
            'municipality',
            'department',
            'regional',
            'level',
            'regimentype',
            'typedocument',
            'contract',
            'location'
        )->firstWhere('identifier', $dataPatient['identifier']);


        if ($this->patient) {
            $this->patient->update($dataPatient);
            $this->message = 'Si';
        } else {
            $this->patient = Patient::Create($dataPatient);
            $this->message = 'No';
        }

        $this->verifyPatient();
        return $this->patient;
    }

    public function verifyPatient()
    {
        // $patient = Paciente::where('Identificacion', $this->patient->identifier)->first();
        // if ($patient) {
        // dd([
        //     $this->patient,
        //     new PatientResource($this->patient)
        // ]);
        $this->patient = new PatientResource($this->patient);
        // }
    }

    public function searchPatientInServices($documentType, $documentNumber)
    {
        $this->medimasService =  new MedimasService($documentType, $documentNumber);
        $dataPatient = $this->medimasService->getDataMedimas()->loopDataMedimas();

        if (count($dataPatient) == 3 || count($dataPatient) < 3) {

            $this->medimasService =  new EcoopsosService($documentType, $documentNumber);
            $dataPatient =  $this->medimasService->getDataWebEcoopsos()->loopDataEcoopsos();
        }
        return $dataPatient;
    }
}
