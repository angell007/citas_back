<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AgendamientoController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
// use App\Http\Controllers\ContractController as ContractEpsController;
use App\Http\Controllers\CupController;
use App\Http\Controllers\DataInit\PersonController as DataInitPersonController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\DurationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\FormularioController;

use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PeopleTypeController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ServiceGlobhoController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\SubTypeAppointmentController;
use App\Http\Controllers\TypeAppointmentController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\BonificationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix("auth")->group(
	function () {
		Route::post("login", "AuthController@login");
		Route::post("register", [AuthController::class, "register"]);
		Route::middleware("auth.jwt")->group(function () {
			Route::post("logout", [AuthController::class, "logout"]);
			Route::post("refresh", [AuthController::class, "refresh"]);
			Route::post("me", [AuthController::class, "me"]);
			Route::get("renew", [AuthController::class, "renew"]);
			Route::get("change-password", [
				AuthController::class,
				"changePassword",
			]);
		});
	}
);

Route::post('/tester', function(){
     $infoArchivo = [];
     $resultados = [];
     array_push($resultados, $infoArchivo);
     print_r( stripslashes( json_encode ($resultados)  ));
});

Route::get('get-pass', [TestController::class, 'getPass']);

Route::group(
	[
		"middleware" => ["api", "cors", 'auth.verify'],
	],

	function ($router) {
	    
	    
	    /********************************************/
	    Route::resource('countable_incomes', 'Countable_incomeController');
		Route::get('countable_income', [BonificationsController::class, 'countable_income']);
		Route::resource('bonifications', 'BonificationsController');

	    /********************************************/
		Route::post('create-menu',  [MenuController::class, 'store']);

		Route::post('/save-menu',  [MenuController::class, 'store']);

		Route::post("formulario/save-responses", [FormularioController::class, "saveResponse"]);
		Route::post("agendamientos-cancel", [AgendamientoController::class, "cancel"]);
		Route::post("space-cancel", [SpaceController::class, "cancel"]);
		Route::post("cancel-appointment/{id}", "AppointmentController@cancel");
		Route::post("another-formality", "AnotherFormality@store");
		Route::post("presentianCall", "CallInController@presentialCall");
		Route::post("patientforwaitinglist", "CallInController@patientforwaitinglist");
		Route::post("imports", [CupController::class, "import"]);

		Route::post("cancell-agenda", [AgendamientoController::class, "cancellAgenda"]);
		Route::post("cancell-waiting-appointment", [WaitingListController::class, "cancellWaitingAppointment"]);

		Route::post("confirm-appointment", [AppointmentController::class, "confirmAppointment"]);
		Route::post("appointment-recursive", [AppointmentController::class, "appointmentRecursive"]);
		Route::post("migrate-appointment", [AppointmentController::class, "appointmentMigrate"]);
		Route::get("appointments/tomigrate", [AppointmentController::class, "toMigrate"]);


		Route::get('reporte',  [ReporteController::class, 'general']);
		Route::get('get-menu',  [MenuController::class, 'getByPerson']);
		Route::get("spaces-statistics", [SpaceController::class, "statistics"]);
		Route::get("waiting-list-statistics", [WaitingListController::class, "statistics"]);
		Route::get("spaces-statistics-detail", [SpaceController::class, "statisticsDetail"]);
		Route::get("get-type_appointments/{query?}", [TypeAppointmentController::class, "index"]);

		Route::get("get-durations", [DurationController::class, "index"]);
		Route::get("appointments-pending", [AppointmentController::class, "getPending"]);
		Route::get("get-statistics-by-collection", [AppointmentController::class, "getstatisticsByCollection"]);

		Route::get("get-type_subappointments/{query?}", [SubTypeAppointmentController::class, "index"]);
		Route::get("get-companys/{query?}", [CompanyController::class, "index"]);
		Route::get("get-companys-based-on-city/{company?}", [CompanyController::class, "getCompanyBaseOnCity"]);
		Route::get("get-sedes/{ips?}/{procedure?}", [LocationController::class, "index"]);

		Route::get("get-formulario/{formulario?}", [FormularioController::class, "getFormulario"]);
		Route::get("agendamientos/paginate", [AgendamientoController::class, "indexPaginate"]);
		Route::get("agendamientos/detail/{id}", [AgendamientoController::class, "showDetail"]);

		Route::get("people-type-custom", [PeopleTypeController::class, "indexCustom"]);
		Route::get("people-paginate", 'PersonController@indexPaginate');
		Route::resource('people', \PersonController::class);

		Route::get("get-patient-fill/{id}", "PatientController@getPatientResend");
		Route::get("type-service/formality/{id}", "TypeServiceController@allByFormality");
		Route::get("opened-spaces", "SpaceController@index");
		Route::get("opened-spaces/{especialidad?}/{profesional?}", "SpaceController@indexCustom");
		Route::get("get-patient", "PatientController@getPatientInCall");
		Route::get("clean-info/{id?}", [AppointmentController::class, "cleanInfo"]);
		Route::get("clean-info", [AppointmentController::class, "getDataCita"]);
		Route::get("validate-info-patient", [DataInitPersonController::class, "validatePatientByLineFront"]);

		Route::resource('dependencies', DependencyController::class);
		Route::resource('work-contract-type', WorkContractController::class);
		Route::resource('rotating-turns', RotatingTurnController::class);
		Route::resource('group', GroupController::class);
		Route::resource('positions', PositionController::class);


		Route::resource("agendamientos", "AgendamientoController");
		Route::resource("appointments", "AppointmentController");
		Route::resource("patients", "PatientController");
		Route::resource("calls", "CallController");
		Route::resource("cie10s", "Cie10Controller");
		Route::resource("person", "PersonController");

		Route::resource("professionals", "ProfessionalController");

		Route::resource("company", "CompanyController");
		Route::resource("people-type", "PeopleTypeController");
		Route::resource("departments", "DepartmentController");
		Route::resource("contract", "ContractController");

		Route::post("contracts", [ContractController::class, 'store']);
		Route::get("contracts", [ContractController::class, 'paginate']);
		Route::get("contracts/{id?}", [ContractController::class, 'edit']);

		Route::resource("cities", "MunicipalityController");
		Route::resource("agreements", "AgreementController");
		Route::resource("type-documents", "TypeDocumentController");
		// Eps
		Route::resource("eps", "AdministratorController");
		Route::get("paginate-eps", [AdministratorController::class, "paginate"]);
		Route::resource("epss", "EpsController");
		// Cups
		Route::resource("cups", "CupController");
		Route::get("paginate-cup", [CupController::class, "paginate"]);
		

		// Specialities
		Route::get("get-specialties/{sede?}/{procedure?}", [SpecialityController::class, "index",]);
		Route::get("get-professionals/{ips?}/{speciality?}", 'PersonController@index');
		Route::resource("specialities", "SpecialityController");
		Route::get("get-specialties-by-procedure/{cup?}", "SpecialityController@byProcedure");
		Route::get("paginate-especialities", [SpecialityController::class, "paginate"]);


		Route::resource('compensation-funds', CompensationFundController::class);
		Route::resource('pension-funds', PensionFundController::class);
		Route::resource('severance-funds', SeveranceFundController::class);


		Route::resource("type-regimens", "RegimenTypeController");
		Route::resource("levels", "LevelController");
		Route::resource("waiting-appointment", "WaitingListController");
		Route::resource("formality", "FormalityController");
		Route::resource("ambit", "AmbitController");
		Route::resource("type-locations", "TypeLocationController");
		Route::resource("menus", "MenuController");
		Route::resource("fees", "FeeController");
		Route::resource("reasons", "ReasonController");
		Route::resource("method-pays", "MethodPayController");
		Route::resource("banks", "BankController");


		//Payment Method
		Route::resource('payment_methods', PaymentMethodController::class);
		Route::get('paginatePaymentMethod', [PaymentMethodController::class, 'paginate']);


		//Price List
		Route::resource('price_lists', PriceListController::class);
		Route::get('paginatePriceList', [PriceListController::class, 'paginate']);

		//Benefits_plan
		Route::resource('benefits_plans', BenefitsPlanController::class);
		Route::get('paginateBenefitsPlan', [BenefitsPlanController::class, 'paginate']);

		Route::resource('arl', ArlController::class);
		Route::get('afiliation/{id}', [PersonController::class, 'afiliation']);
		Route::post('updateAfiliation/{id}', [PersonController::class, 'updateAfiliation']);

		Route::get('person/{id}', [PersonController::class, 'basicData']);
		Route::get('basicData/{id}', [PersonController::class, 'basicDataForm']);
		Route::post('updatebasicData/{id}', [PersonController::class, 'updateBasicData']);

		Route::get('salary/{id}', [PersonController::class, 'salary']);
		Route::post('salary', [PersonController::class, 'updateSalaryInfo']);
		Route::resource('salaryTypes', SalaryTypesController::class);
		Route::get('paginateSalaryType', [SalaryTypesController::class, 'paginate']);

		Route::resource('work_contracts', 'WorkContractController');
		
		Route::post('mycita', function(){
		    return response()->json(request()->all());
		});
		


		Route::resource('fixed-turns', FixedTurnController::class);
		Route::get('fixed_turn', [PersonController::class, 'fixed_turn']);
		Route::post('/fixed-turns/change-state/{id}', [FixedTurnController::class, 'changeState']);
		Route::get('/fixed-turn-hours', [FixedTurnHourController::class, 'index']);
		Route::get('/reporte/horarios/{fechaInicio}/{fechaFin}/turno_fijo', [ReporteHorariosController::class, 'fixed_turn_diaries'])->where([
			'fechaInicio' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
			'fechaFin'    => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
		]);
	}
);

Route::group(["middleware" => ["jwt.verify"]], function () {
	Route::get(
		"/caracterizacion/pacientesedadsexo",
		"CaracterizacionController@PacienteEdadSexo"
	);
	Route::get(
		"/caracterizacion/pacientespatologiasexo",
		"CaracterizacionController@PacientePatologiaSexo"
	);
	Route::get(
		"/pacientes/listapacientes",
		"PacienteController@ListaPacientes"
	);
});

Route::group(["middleware" => ["globho.verify"]], function () {
	Route::post('create-professional', [PersonController::class, 'storeFromGlobho']);
	Route::put('professional', [PersonController::class, 'updateFromGlobho']);
	Route::post('update-appointment-by-globho', [ServiceGlobhoController::class, 'updateStateByGlobhoId']);
	Route::get("get-appointments-by-globho-id", [ServiceGlobhoController::class, "getInfoByGlobhoId"]);
	Route::post('create-appoinment', [AppointmentController::class, 'createFromGlobho']);
});
