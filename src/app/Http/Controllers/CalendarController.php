<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFullYearRequest;
use App\Services\AlternativeCalendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    // реализовать маршрут GET: /{locale}/calendar/{year}, который будет
    // отдавать HTML с отрендеренным календарем на заданный год
    public function getFullYear(GetFullYearRequest $request)
    {
        $calendar = new AlternativeCalendar(1, 1, $request->year);

        return view('full-year')
            ->with('calendar', $calendar->getFullYear());
    }

    // реализовать маршрут GET: /{locale}/api/what-day-is/{day}-{month}-{year}, который
    // будет отдавать JSON с названием дня недели.
    // шаблон: {status: 'success|error', result: '{DayName}|null'}
    public function getDayName(Request $request)
    {
        $calendar = new AlternativeCalendar($request->day, $request->month, $request->year);
        $dayName  = $calendar->getDayName();

        return [
            'status' => $dayName ? 'success' : 'error',
            'result' => __('calendar.' . $dayName),
        ];
    }
}
