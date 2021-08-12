<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    //
    /* private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    } */

    public function general()
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }
}
