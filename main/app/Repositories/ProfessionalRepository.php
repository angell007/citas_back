<?php

namespace App\Repositories;

use App\Models\Person;
use App\Models\Usuario;
use App\Models\WorkContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessionalRepository
{
    public function paginate()
    {
        $urlBase = DB::table('site_settings')->get(['url', 'folder_functionaries'])->first();

        return   DB::table('people as p')
            ->select(
                'p.id',
                DB::raw('Concat_ws("", "' . $urlBase->url . '" ,p.image_blob) As image'),
                'p.identifier',
                'p.status',
                DB::raw('Concat_ws(" ", p.first_name, p.first_surname ) as full_name'),
                'p.first_surname',
                'p.first_name',
                'pos.name as position',
                'd.name as dependency',
                'c.name as company',
                DB::raw('w.id AS work_contract_id')
            )
            ->join('work_contracts as w', function ($join) {
                $join->on('p.id', '=', 'w.person_id')
                    ->whereRaw('w.id IN (select MAX(a2.id) from work_contracts as a2
                                    join people as u2 on u2.id = a2.person_id group by u2.id)');
            })
            ->join('companies as c', 'c.id', '=', 'w.company_id')
            ->join('positions as pos', 'pos.id', '=', 'w.position_id')
            ->join('dependencies as d', 'd.id', '=', 'pos.dependency_id')

            ->when(request()->get('identifier'), function ($q) {
                $q->where('p.identifier', 'like', request()->get('identifier') . '%');
            })
            ->when(request()->get('name'), function ($q) {
                $q->Where(DB::raw('concat(p.first_name," ",p.first_surname)'), 'LIKE', request()->get('name') . '%');
            })
            ->when(request()->get('status'), function ($q) {
                $q->where('p.status',  request()->get('status'));
            })

            ->when(request()->get('company'), function ($q) {
                $q->where('c.name',  'like', request()->get('company')  . '%');
            })
            ->paginate(request()->get('pageSize'), ['*'], 'page', request()->get('page'));
    }

    public function store()
    {

        $mydata = collect(json_decode(request()->get('form')))->except(['signature_blob', 'image_blob']);

        if (request()->file('signature_blob')) {
            $mydata['signature_blob'] = getFilename('signature_blob');
        }
        if (request()->file('image_blob')) {
            $mydata['image_blob'] = getFilename('image_blob');
        }

        $person = Person::updateOrCreate(['id' => $mydata->get('id')], $mydata->all());

        $person->companies()->sync($mydata->get('companies'));
        $person->specialities()->sync($mydata->get('specialities'));

        WorkContract::create([
            'company_id' => $mydata->get('company_id'),
            'liquidated' =>  0,
            'salary' => 0,
            'person_id' => $person->id,
            'work_contract_type_id' => $mydata->get('contract'),
            'date_end' => Carbon::now()->addDecade(),
            'turn_type' => 'Fijo',
        ]);

        Usuario::create([
            'person_id' => $person->id,
            'usuario' => $mydata->get('identifier'),
            'password' => Hash::make($mydata->get('identifier')),
            'change_password' => 1,
        ]);

        return ['id' => $person->id];
    }

    public function show($id)
    {
        return Person::select('*')->with(['specialities:id', 'companies:id'])
            ->find($id);
    }
}
