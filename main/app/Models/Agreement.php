<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        "contract_name",
        "contract_number",
        "department_id",
        "company_id",
        "regimen",
        "site",
        "eps_id"
    ];
}
