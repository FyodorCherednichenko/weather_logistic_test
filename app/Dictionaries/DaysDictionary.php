<?php
declare(strict_types=1);

namespace App\Dictionaries;

use Illuminate\Support\Arr;

class DaysDictionary
{
    private array $days = [
      'Monday'    => 'Понедельник',
      'Tuesday'   => 'Вторник',
      'Wednesday' => 'Среда',
      'Thursday'  => 'Четверг',
      'Friday'    => 'Пятница',
      'Saturday'  => 'Суббота',
      'Sunday'    => 'Воскресенье',
    ];

    public function getRusDayByEngKey(string $key): string
    {
        return Arr::get($this->days,$key);
    }
}
