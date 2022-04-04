<?php

use Carbon\Carbon;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;

function dateFormat($date)
{
    return Carbon::make($date)->isoFormat('dddd, D MMMM Y');
}

function dateTimeFormat($datetime)
{
    $date = Carbon::make($datetime)->isoFormat('dddd, D MMMM Y');
    $time = Carbon::make($datetime)->format('h:i A');

    return $date . ' - ' . $time;
}

function timeFormat($time)
{
    return Carbon::make($time)->format('h:i A');
}

function getOffset($daysName, $firstDate)
{
    foreach ($daysName as $i => $dayName) {
        if ($dayName == $firstDate->isoFormat('dddd')) {
            return $i;
        }
    }
}

function makePeriod($date)
{
    // Ambil tanggal pertama dan terakhir bulan ini untuk membuat periode
    $firstDate = $date->firstOfMonth()->toDateString();
    $lastDate = $date->lastOfMonth()->toDateString();

    return CarbonPeriod::create($firstDate, $lastDate);
}

function getCalendarData()
{
    $current = session('currentMonth') ? Carbon::make(session('currentMonth')) : now();
    $data['daysName'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $data['datesOfMonth'] = makePeriod($current);
    $data['offset'] = getOffset($data['daysName'], $current->firstOfMonth());
    // $data['activeSchedules'] = Schedule::getActive();
    $data['current'] = $current;

    // Ambil seluruh data perhari di bulan ini
    $data['dataInMonth'] = Schedule::getInMonth($data['datesOfMonth']);

    return $data;
}

function str($content)
{
    return Str::of($content);
}
