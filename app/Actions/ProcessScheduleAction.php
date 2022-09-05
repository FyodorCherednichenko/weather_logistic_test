<?php
declare(strict_types=1);

namespace App\Actions;

use App\Dictionaries\DaysDictionary;
use App\Dictionaries\HollyDaysDictionary;
use App\Dictionaries\PluralMonthsDictionary;
use App\DTOs\Entities\ScheduleDTO;
use App\DTOs\Validators\ScheduleDTOValidator;
use Illuminate\Validation\ValidationException;

class ProcessScheduleAction
{
    private const DAY_IN_SECONDS = 86400,
                  DIRECTION_1 = 'Route_1',
                  DIRECTION_2 = 'Route_2',
                  DIRECTION_3 = 'Route_3',
                  ODD_DAYS = [
                      'Понедельник',
                      'Среда',
                      'Пятница',
                      'Воскресенье'
                  ],
                  EVEN_DAYS = [
                       'Вторник',
                       'Четверг',
                       'Суббота',
                      'Воскресенье'
                  ];

    public function __construct(
        public ScheduleDTO $dto,
        public ScheduleDTOValidator $validator,
        public PluralMonthsDictionary $months_dictionary,
        public DaysDictionary $days_dictionary,
        public HollyDaysDictionary $holly_day_dictionary
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function execute(array $data): array
    {
        $dto = $this->dto->createFromArray($data, $this->validator);
        $next_twenty_one_days = $this->createNextTwentyOneDays(strtotime($dto->date . $dto->time));

        if ($dto->direction === self::DIRECTION_1 || $dto->direction === self::DIRECTION_2) {
            $next_twenty_one_days = $this->clearScheduleForDirectionOneOrTwo($next_twenty_one_days, $dto->time);
        } elseif ($dto->direction === self::DIRECTION_3) {
            $next_twenty_one_days = $this->clearScheduleForDirectionThree($next_twenty_one_days, $dto->time);
        }

        return $next_twenty_one_days;
    }

    private function clearScheduleForDirectionOneOrTwo(array $next_twenty_one_days, string $time): array
    {
        if((strtotime($time) >= strtotime('16:00')) && (in_array($next_twenty_one_days[0]['day'], self::ODD_DAYS))) {
            unset($next_twenty_one_days[0]);
        }

        $clear_schedule = [];

        foreach ($next_twenty_one_days as $key => $next_twenty_one_day) {
            if(!(in_array($next_twenty_one_day['day'], self::EVEN_DAYS) || $this->holly_day_dictionary->isHollyDay($next_twenty_one_day['date']))) {
                $clear_schedule[] = $next_twenty_one_day;
            }
        }

        return $clear_schedule;
    }

    private function clearScheduleForDirectionThree(array $next_twenty_one_days, string $time): array
    {
        if((strtotime($time) >= strtotime('22:00')) && (in_array($next_twenty_one_days[0]['day'], self::EVEN_DAYS))) {
            unset($next_twenty_one_days[0]);
        }

        $clear_schedule = [];

        foreach ($next_twenty_one_days as $next_twenty_one_day) {
            if(!(in_array($next_twenty_one_day['day'], self::ODD_DAYS) || $this->holly_day_dictionary->isHollyDay($next_twenty_one_day['date']))) {
                $clear_schedule[] = $next_twenty_one_day;
            }
        }

        return $clear_schedule;
    }

    private function createNextTwentyOneDays(int $start_day): array
    {
        $next_twenty_one_days = [];

        for ($i = 0; $i < 21; $i++) {
            $start_day = $start_day + self::DAY_IN_SECONDS;
            $next_twenty_one_days[] = $this->mainTransform(getdate($start_day));
        }

        return $next_twenty_one_days;
    }

    private function mainTransform(array $date): array
    {
        return [
            'date'  => $this->frontZeroTransform($date['mday']) . '.' . $this->frontZeroTransform($date['mon']) . '.' . $date['year'],
            'day'   => $this->days_dictionary->getRusDayByEngKey($date['weekday']),
            'title' => $date['mday'] . ' ' . $this->months_dictionary->getRusPluralMonthByEngKey($date['month']),
        ];
    }

    private function frontZeroTransform(int $value): int|string
    {
        if (strlen((string) $value) < 2) {
            return '0' . $value;
        }

        return $value;
    }
}
