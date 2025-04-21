<?php
namespace App\Services;

use App\Helpers\MyHelper;
use App\Models\Absence;
use App\Models\AttendanceSheet;
use App\Traits\ReportFilterTrait;
use Carbon\Carbon;

class ReportFilterService

{
    use ReportFilterTrait;

    public function __construct(protected AttendanceSheet $model){}

    public function filterService($data){

        $data['month'] = $data['month'] ??\Carbon\Carbon::now()->format('Y-m');
        $department_id = $data['department_id'] ?? null;

        session()->put('selected_department_id',$department_id );
        session()->put('selected_month',  $data['month']);
         // dd($data['month']);
        $attendance_sheet = AttendanceSheet::forClient($data['month'], $department_id)->get();
        // dd($attendance_sheet);
        $data['attendance_sheet'] = $attendance_sheet;
        // dd($data['attendance_sheet']);
        $data['client_department'] = Myhelper::get_client_department();
        $data['client_id'] = Myhelper::find_auth_user_client();

        $service = $this->filter($data);
        // dd($service);

        $person_data_from_attendance = $this->fill_absent_person_date($service,$data['month']);

        $data['attendance_sheet']= $person_data_from_attendance;
        $data['i']=0;


        return $data;

    }
    public function fill_absent_person_date($service,$month){

        foreach($service as $peopleId => &$dailyRecords){
            // dd($peopleId,  $dailyRecords);
            $absence = Absence::where('person_id',$peopleId)->get();
            if(count($absence)>0){

            }
            foreach($absence as $ab){

                $startDate = \Carbon\Carbon::parse($ab->start_date);
                $endDate = \Carbon\Carbon::parse($ab->end_date);

                $get_absence_person_start_month = $startDate->format('Y-m');
                $get_absence_person_end_month = $endDate->format('Y-m');

                 // Определяем первый и последний день текущего месяца
                $firstDayOfMonth = \Carbon\Carbon::parse($month . '-01');
                $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
                 //    dd($firstDayOfMonth, $lastDayOfMonth);

                if ($month == $get_absence_person_start_month || $month == $get_absence_person_end_month) {
                  // Определяем диапазон дней, которые попадают в текущий месяц
                      $get_start_day = max($startDate->format('d'), 1); // Если начало в прошлом месяце, берем 1-й день

                    $get_end_day = min($endDate->format('d'), $lastDayOfMonth->format('d')); // Если конец в будущем месяце, берем последний день текущего

                    for ($i = $get_start_day; $i <= $get_end_day; $i++) {
                        $dayKey = str_pad($i, 2, '0', STR_PAD_LEFT); // Преобразуем 1 в '01', 2 в '02' и т. д.
                        // $dayKey = (int) $i; // Преобразуем в число
                        $dailyRecords[$dayKey]['absence'] = $ab->type;
                    }
                }
            }


        }

        return $service;

    }



}
