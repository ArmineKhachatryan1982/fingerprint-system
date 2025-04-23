<?php

namespace App\Http\Controllers\Api\Turnstile;

use App\Events\TemplateCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\TouchSystemRequest;
use App\Models\Person;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TouchSystemController extends Controller
{
    public function  index(TouchSystemRequest  $request){
        

            $person= Person::where('template', 0)
            ->with('person_permission')
            ->orderBy('id', 'desc')
            ->first();
            if($person){
                $entryCodeId = $person?->person_permission?->pluck('entry_code_id')->first();

                $touchExplode = explode('#',$request->touch[0]);
                // dd($getTime[1]);
                $touch =  $touchExplode[0];
                $dateTime = Carbon::createFromTimestamp($touchExplode[1])->format('y-m-d h:i:s');
                // dd($dateTime);
                $data = [
                    "people_id" => $person->id,
                    "entry_code" => $entryCodeId,
                    "touch" =>$touch,
                    "date"=> $dateTime,
                    "type" => "touchId",
                    "direction" => "enter",
                    "online"=> $request->online,
                    "mac"=>$request->mac
                ];
                // dd($data);
                $templates = Template::create($data);

            }else{
                // dd($request->all());
                $data = $this->match($request->all());


            }

    }
    public function match( $request){

        try {
            dd( $request->all());

            $touch = $request['touch'][0];

            $touchExplode = explode('#', $touch);
            // dd($touchExplode);
            $newTemplateHex = $touchExplode[0];
            // dd($newTemplateHex);
            $matchedUser = $this->identifyUser( $newTemplateHex, 700);
                dd($matchedUser);
            return response()->json([
                'matched_user' => $matchedUser,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

    }
    private function identifyUser(string $newTemplateHex, int $threshold = 700): ?string
    {
        // dd($newTemplateHex);
        $newTemplate = $this->hexToBytes($newTemplateHex);
        // dd($newTemplate);
        $templatesAll = Template::all();
        foreach ($templatesAll as $user => $templates) {
            // dd($templates);
            // foreach ($templates as $templateHex) {
                // dd($templates->touch);
                // $template = $this->hexToBytes($templateHex);
                $template = $this->hexToBytes($templates->touch);
                $distance = $this->hammingDistance($template, $newTemplate);
                dd($distance,$threshold);

                if ($distance < $threshold) {
                    $user = Person::findOrFail( $templates->people_id);
                    // dd($user);
                    // dd(44);
                    return $user;
                }else{
                    dd(54);
                }
            // }
        }

        return null;
    }

    private function hexToBytes(string $hex): string
    {
        // dd($hex);


        // dd( strlen($hex));// должно быть 1040 //1132

        $bytes = hex2bin($hex);
        // dd($bytes);
        // dd(strlen($bytes));
        // if (strlen($bytes) !== 520) {
        if (strlen($bytes) !== 566) {

            throw new \Exception("Шаблон должен быть ровно 520 байт");
        }

        return $bytes;
    }

    private function hammingDistance(string $a, string $b): int
    {

        // dd( $a,  $b);
        if (strlen($a) !== strlen($b)) {
            throw new \Exception("Длины шаблонов не совпадают");
        }

        $distance = 0;
        for ($i = 0; $i < strlen($a); $i++) {
            $xor = ord($a[$i]) ^ ord($b[$i]);
            $distance += substr_count(decbin($xor), '1');
        }
        // dd($distance);
        return $distance;
    }
}
