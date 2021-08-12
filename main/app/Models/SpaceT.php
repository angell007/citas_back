<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceT extends Model
{
    
    protected $table = 'spacesdos';
    
    protected $fillable =  [
        'agendamiento_id',
        'status',
        'hour_start',
        'hour_end',
        'long',
        'person_id',
        'backgroundColor',
        'className'
    ];

    public function agendamiento()
    {
        return $this->belongsTo(Agendamiento::class);
    }
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function getHourStartAttributte()
    {
        return date('Y-m-d\TH:i:s\Z', strtotime($this->attributes['hour_star']));
    }
    public function getHourEndAttributte()
    {
        return date('Y-m-d\TH:i:s\Z', strtotime($this->attributes['hour_end']));
    }
}
