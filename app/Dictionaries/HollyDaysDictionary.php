<?php
declare(strict_types=1);

namespace App\Dictionaries;

class HollyDaysDictionary
{
    private array $holly_days = [
        '01.01',
        '23.02',
        '08.03',
        '09.05'
    ];

    public function isHollyDay(string $date): bool
    {
        return in_array(substr($date,0,5), $this->holly_days);
    }

}
