<?php

namespace App\Services;

/*
 * Тестовое задание: Альтернативный Календарь
 *
 * Имеем:
 */
class AlternativeCalendar
{
    // в каждом году 11 месяцев (нет декабря)
    protected array $monthsList = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        //'December',
    ];

    // в каждом месяце 42 дня
    protected int $daysInRegularMonth = 42;

    // а если порядковый номер месяца в году кратен 3-м, то 41 день
    protected int $daysInLeapMonth = 41;

    // каждая неделя имеет 6 дней, нет суббот. первый день - понедельник
    protected array $dayNamesList = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        //'Saturday',
        'Sunday',
    ];

    // 1 Января 1800 года это Воскресенье
    protected array $greatBigBang = [1, 1, 1800, 'Sunday'];

    // дата отрисовки [day, month, year]
    protected array $renderDate;

    // устанавливаем $renderDate
    public function __construct(int $day, int $month, int $year)
    {
        $this->renderDate = [$day, $month, $year];
    }

    // отрисовать год целый
    public function getFullYear(): null|array
    {
        $dayNameKey = array_search($this->getDayName(), $this->dayNamesList);
        $fullYear   = [];

        foreach ($this->monthsList as $monthKey => $monthName) {
            $daysInMonth = $this->daysInRegularMonth;

            // каждый месяц, кратный 3-м - високосный
            if (($monthKey + 1) % 3 == 0) {
                $daysInMonth = $this->daysInLeapMonth;
            }
            // каждый год, кратный 3-м - високосный, в Январе такого года - 41 день
            elseif ($monthKey == 0 && $this->renderDate[2] % 3 == 0) { // если кратен 3, то это не Январь, по этому стоит elseif
                $daysInMonth = $this->daysInLeapMonth;
            }

            // создан месяц
            $month = [
                'name' => $monthName,
                'days' => [],
            ];

            // в месяц добавлены дни
            for ($number = 1; $number <= $daysInMonth; $number++) {
                $month['days'][] = [
                    'number' => $number,
                    'name'   => $this->dayNamesList[$dayNameKey],
                ];

                $dayNameKey = ($dayNameKey + 1) < count($this->dayNamesList)
                    ? $dayNameKey + 1 : 0;
            }

            // месяц добавлен в год
            $fullYear[] = $month;
        }

        return $fullYear;
    }

    // какой это день недели
    public function getDayName(): null|string
    {
        $daysPassed    = $this->getDaysPassed();
        $dayNamesCount = count($this->dayNamesList);
        $weeksPassed   = floor($daysPassed / $dayNamesCount);
        $weekDaysLeft  = $daysPassed - ($dayNamesCount * $weeksPassed);
        $weeksShift    = array_search($this->greatBigBang[3], $this->dayNamesList);
        $key           = ($weekDaysLeft + $weeksShift) % $dayNamesCount;

        return $this->dayNamesList[$key];
    }

    // сколько дней прошло с 1 Января 1800 года
    protected function getDaysPassed()
    {
        $d1 = $this->greatBigBang;
        $d2 = $this->renderDate;

        $yearsPassed = $d2[2] - $d1[2];
        $daysPassed  = 0;

        // прошло дней относительно года
        if ($d1[2] != $d2[2]) {
            $leaps = floor($yearsPassed / 3); // каждый год, кратный 3-м - високосный
            $extra = ($this->daysInRegularMonth - $this->daysInLeapMonth) * $leaps; // лишние дни

            $daysPassed += ($this->daysInRegularMonth * count($this->monthsList)) * $yearsPassed;
            $daysPassed -= $extra;
        }

        // прошло дней относительно месяца
        if ($d1[1] != $d2[1]) {
            $monthsPassed = ($d2[1] - $d1[1]) + ($yearsPassed * count($this->monthsList));
            $leaps = floor($monthsPassed / 3); // каждый месяц, кратный 3-м - високосный
            $extra = ($this->daysInRegularMonth - $this->daysInLeapMonth) * $leaps; // лишние дни

            $daysPassed += ($d2[1] - $d1[1]) * $this->daysInRegularMonth;
            $daysPassed -= $extra;
        }

        // прошло дней
        if ($d1[0] != $d2[0]) {
            $daysPassed += $d2[0] - $d1[0];
        }

        return $daysPassed;
    }
}
