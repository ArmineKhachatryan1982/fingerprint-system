<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Models\Client;
use App\Models\ClientSchedule;
use App\Models\SchedueName;
use App\Models\ScheduleName;
use App\Models\Staff;
use App\Repositories\Interfaces\ScheduleNameInterface;
use Illuminate\Support\Facades\Auth;

class ScheduleNameRepository implements ScheduleNameInterface
{

    public function index(){
        // dd(MyHelper::find_auth_user_client());

        $client_schedules = ClientSchedule::where('client_id',MyHelper::find_auth_user_client())->pluck('schedule_name_id');

        $data = ScheduleName::whereIn('id',$client_schedules)->latest()->get();
        // dd($data);

        return $data;
    }

    public function creat(){

    }
    public function store($dto){

        $data = ScheduleName::create($dto);

        $client = Client::where('user_id',Auth::id())->value('id');

        $clients_schedule = ClientSchedule::create([
            "client_id" => MyHelper::find_auth_user_client(),
            "schedule_name_id" => $data->id

        ]);

        return $data;


    }
    public function edit($id){

        $data = ScheduleName::with('schedule_details')->findOrFail($id);

        return $data;

    }
    public function update($dto, $id){

        $data = ScheduleName::where('id',$id)->first();
        $data->update($dto);

        return true;

    }


}


