<?php
 namespace  App\Traits;

 trait CalculateTotalHoursTrait
 {

    public function calculate($peopleDailyRecord,$client){
        //   dd($peopleDailyRecord);
          $fullTotalSeconds = 0;
            foreach ($peopleDailyRecord as $personId => $records) {
                // dd($fullTotalSeconds);
                // dd($records);
                $totalSeconds = 0;
                $delaytotalSeconds = 0;
                // dd($records);
                // if($personId == 75){
                    // dd($personId);

                    // dd($records);
                   // Iterate through each person's records
                    foreach ($records as $key=>&$data) {
                        // dd($key,$data);
                        // if (isset($data['working_times'])) {
                        //         $totalSeconds = 0;
                        //         // dd($totalSeconds);

                        //     foreach ($data['working_times'] as $time) {
                        //         // dump($time);
                        //         // Convert each time string (HH:MM:SS) to seconds
                        //         list($hours, $minutes, $seconds) = explode(':', $time);
                        //         $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
                        //         // list($hours, $minutes) = explode(':', $time);
                        //         // $totalSeconds += $hours * 3600 + $minutes * 60;
                        //     }
                        //     // dd($totalSeconds);
                        //     // dd( $peopleDailyRecord[$key]);
                        //     $data['daily_working_time'] = $totalSeconds;
                        //     // $peopleDailyRecord[$records][$key]['daily_working_time'] = $totalSeconds;
                        //     $fullTotalSeconds += $totalSeconds;

                        // }
                        if(isset($data['daily_working_times_totalSeconds'])){
                            $fullTotalSeconds+=$data['daily_working_times_totalSeconds'];
                        }

                        if (isset($data['delay_hour'])) {
                            foreach ($data['delay_hour'] as $delay) {
                                // Convert each time string (HH:MM:SS) to seconds
                                // list($hours, $minutes, $seconds) = explode(':', $delay);
                                // $delaytotalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
                                list($hours, $minutes) = explode(':', $delay);
                                $delaytotalSeconds += $hours * 3600 + $minutes * 60;
                            }
                        }
                        // dump($totalSeconds);
                   // dump($fullTotalSeconds);
                    }
            //    }//personId
                // dd($fullTotalSeconds);
                $fullTotalHours = floor($fullTotalSeconds / 3600);
                $fullTotalSeconds %= 3600;
                $fullTotalMinutes = floor($fullTotalSeconds / 60);
                $fullTotalSeconds %= 60;
                // dd( $fullTotalSeconds);


                // Convert total seconds back to hours, minutes, and seconds
                $totalHours = floor($totalSeconds / 3600);
                $totalSeconds %= 3600;
                $totalMinutes = floor($totalSeconds / 60);
                $totalSeconds %= 60;

                $delaytotalHours = floor($delaytotalSeconds / 3600);
                $delaytotalSeconds %= 3600;
                $delaytotalMinutes = floor($delaytotalSeconds / 60);
                $delaytotalSeconds %= 60;

                $peopleDailyRecord[$personId]['totalMonthDayCount'] =count($records);

                $peopleDailyRecord[$personId]['totalWorkingTimePerPerson'] = sprintf( '%d ժ, %d ր', $fullTotalHours, $fullTotalMinutes, $fullTotalSeconds);

                $peopleDailyRecord[$personId]['totaldelayPerPerson'] = sprintf('%d ժ, %d ր', $delaytotalHours, $delaytotalMinutes, $delaytotalSeconds);
                // dd($peopleDailyRecord);
                // dd($client->working_time,$totalHours);
                if($client->working_time !=null){
                    $clientWorkingHours = (float) $client->working_time; // Convert string to float
                    $personWorkingHours = (float) $totalHours;
                    if($clientWorkingHours>$personWorkingHours){
                        $peopleDailyRecord[$personId]['personWorkingTimeLessThenClientWorkingTime'] =true;

                    }

                }

            }
            // dd($peopleDailyRecord);
            return  $peopleDailyRecord;


        }


 }


