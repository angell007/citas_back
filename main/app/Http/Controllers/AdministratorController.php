<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Traits\ApiResponser;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            return $this->success(Administrator::orderBy('name', 'DESC')->get(['name As text', 'id As value']));
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function paginate()
    {
        try {
            return $this->success(
                Administrator::orderBy('name')->when(request()->get('name'), function (Builder $q) {
                    $q->where('name', 'like', '%' . request()->get('name') . '%');
                })->paginate(request()->get('pageSize', 10), ['*'], 'page', request()->get('page', 1))
            );
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function store()
    {
        try {
            $administrator = Administrator::updateOrCreate(['id' => request()->get('id')], request()->all());
            return ($administrator->wasRecentlyCreated === true) ? $this->success('creado con exito') : $this->success('Actualizado con exito');
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }
}
