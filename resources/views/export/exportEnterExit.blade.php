<!DOCTYPE html>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Armobil</title>

</head>
@php
    use Carbon\Carbon;

    use App\Models\AttendanceSheet;
    use Illuminate\Support\Facades\DB;
   
    $monthYear = $mounth ?? null;

    $startOfMonth = Carbon::parse("$monthYear-01")->startOfMonth();
    $endOfMonth = Carbon::parse("$monthYear-01")->endOfMonth();
    $groupedEntries = $groupedEntries ?? null;

@endphp

<body>
    <div>
        {{-- {{ dd($groupedEntries) }} --}}

        <table>
            <thead>
                <tr>
                    <td colspan="20" >Հաշվետվություն {{ $monthYear }}-ի դրությամբ</td>

                </tr>
                <tr>


                </tr>

                <tr>
                    <th rowspan="2">Հ/Հ</th>
                    <th rowspan="2">ID</th>
                    <th rowspan="2">Անուն</th>
                    <th rowspan="2">Ազգանուն</th>
                        @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                                        <th colspan="2">{{ $date->format('d') }}</th>
                        @endfor
                    <th rowspan="2">Օրերի քանակ</th>
                    <th rowspan="2">ժամերի քանակ</th>
                    <th rowspan="2">Ուշացման ժամանակի գումար</th>
                </tr>
                <tr>
                    @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                        <th>Մուտք</th>
                        <th>Ելք</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedEntries as $peopleId => $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $peopleId }}</td>
                        <td>{{ getPeople($peopleId)->name ?? null }}</td>
                        <td>{{ getPeople($peopleId)->surname ?? null }}</td>

                    @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay())
                        <td class="p-0 text-center">
                            @if(isset($item[$date->format('d')]['enter']))
                                @if (is_array($item[$date->format('d')]['enter']))
                                        {{ $item[$date->format('d')]['enter'][0] }}

                                @else
                                  <div class="editable" style="width:20px;height:20px;background-color:grey"></div>
                                @endif
                            @endif
                        </td>
                        <td class="p-0 text-center">

                            @if(isset($item[$date->format('d')]['exit']))
                                                               @if (is_array($item[$date->format('d')]['exit']))
                                                                 <span>
                                                                     {{  last(array_slice($item[$date->format('d')]['exit'], -1))  }}
                                                                 </span>
                                                               @else

                                                                 <div class="editable" style="width:20px;height:20px;background-color:grey"></div>


                                                               @endif

                                                            @endif
                        </td>
                    @endfor
                    <td>{{ $item['totalMonthDayCount'] }}</td>
                    <td class="{{ isset($item['personWorkingTimeLessThenClientWorkingTime']) ? 'text-danger' : '' }}">
                        {{ $item['totalWorkingTimePerPerson'] }}
                        </td>
                    <td>{{ $item['totaldelayPerPerson'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
{{-- {{ dd(777) }} --}}
</html>

