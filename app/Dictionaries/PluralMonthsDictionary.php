<?php
declare(strict_types=1);

namespace App\Dictionaries;

use Illuminate\Support\Arr;

class PluralMonthsDictionary
{
    private array $months = [
        'January'   => 'Января',
        'February'  => 'Февраля',
        'March'     => 'Марта',
        'April'     => 'Апреля',
        'May'       => 'Мая',
        'June'      => 'Июня',
        'July'      => 'Июля',
        'August'    => 'Августа',
        'September' => 'Сентября',
        'October'   => 'Октября',
        'November'  => 'Ноября',
        'December'  => 'Декабря'
    ];

    public function getRusPluralMonthByEngKey(string $key): string
    {
        return Arr::get($this->months,$key);
    }
}
