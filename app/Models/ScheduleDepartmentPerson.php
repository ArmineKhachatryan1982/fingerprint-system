<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDepartmentPerson extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function person(){
        return $this->belongsTo(Person::class,'person_id');
    }
    public function schedule_name(){
        return $this->belongsTo(ScheduleName::class,'schedule_name_id');
    }

}
