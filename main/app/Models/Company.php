<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // use HasFactory;

    protected  $fillable =
    [
        "address", "category", "city", "code", "country_code", "creation_date", "disabled", "email",
        "encoding_characters", "id", "logo", "name", "pbx", "send_email", "settings", "slogan", "state", "telephone",
        "tin", "type"
    ];
}
