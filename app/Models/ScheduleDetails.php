<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetails extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function schedule(){

        return $this->bolongsTo(ScheduleName::class, 'schedule_name_id');
    }
    
}
