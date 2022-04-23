<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ __('calendar.Title') }}</title>

    <style>
        body {
            font-family: BlinkMacSystemFont, -apple-system, sans-serif;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }
        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .calendar {
            background: #adadad;
            display: grid;
            gap: 5px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            padding: 5px;
        }
        .calendar-month {
            background: white;
            padding: 5px;
        }
        .calendar-days {
            display: grid;
            gap: 2px;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            margin-top: 5px;
        }
        .calendar-day {
            background: white;
            border: 1px solid #adadad;
            display: flex;
            flex-direction: column;
            padding: 5px;
        }
        .calendar-day-name {
            font-size: 12px;
        }
    </style>
</head>
<body>

<ul class="calendar">
    @foreach($calendar as $month)
        <li class="calendar-month">
            <strong>{{ __('calendar.' . $month['name']) }}</strong>

            <ul class="calendar-days">
                @foreach($month['days'] as $day)
                    <li class="calendar-day">
                        <span>{{ $day['number'] }}</span>
                        <span class="calendar-day-name">{{ __('calendar.' . $day['name']) }}</span>
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>

</body>
</html>
