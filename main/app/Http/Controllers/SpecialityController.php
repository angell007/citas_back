<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialityResource;
use App\Models\Speciality;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sede = 0)
    {
        return SpecialityResource::collection(Speciality::orderBy('name', 'ASC')->get(['id', 'name']));
        // return SpecialityResource::collection(Speciality::where('sede_id', $sede)->get(['id', 'name']));
    }


    public function paginate()
    {
        try {
            return $this->success(
                Speciality::orderBy('name')->when(request()->get('name'), function (Builder $q) {
                    $q->where('name', 'like', '%' . request()->get('name') . '%');
                })->paginate(request()->get('pageSize', 10), ['*'], 'page', request()->get('page', 1))
            );
        } catch (\Throwable $th) {
            return  $this->errorResponse([$th->getMessage(), $th->getFile(), $th->getLine()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function show(Speciality $speciality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function edit(Speciality $speciality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speciality $speciality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speciality $speciality)
    {
        //
    }
}
