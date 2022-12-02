<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Closure;
use DateInterval;
use DatePeriod;
use Exception;
use Throwable;

/**
 * Class DateService
 */
class DateService
{
    /**
     * @param  array  $date
     * @return array
     *
     * @throws Throwable
     */
    public function getDateRangeFromArray(array $date)
    {
        if (isset($date['interval'])) {
            return $this->getDateRangeFromInterval($date['interval']);
        }

        return [
            Carbon::parse($date['start'])->startOfDay(),
            Carbon::parse($date['end'])->endOfDay(),
        ];
    }

    /**
     * @param  string  $interval
     * @return array
     *
     * @throws Throwable
     */
    public function getDateRangeFromInterval(string $interval)
    {
        throw_unless(
            isset($this->getIntervalRanges()[$interval]),
            new Exception('Invalid interval.')
        );

        return array_values($this->getIntervalRanges()[$interval]());
    }

    /**
     * @param  string  $timezone
     * @return Closure[]
     */
    private function getIntervalRanges(string $timezone = 'UTC')
    {
        return [
            'today' => function () use ($timezone) {
                return [
                    'start' => today($timezone),
                    'end' => now($timezone),
                ];
            },
            'yesterday' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subDay(),
                    'end' => today($timezone),
                ];
            },
            'theDayBeforeYesterday' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subDays(2),
                    'end' => today($timezone)->subDay(),
                ];
            },
            '12h' => function () use ($timezone) {
                return [
                    'start' => now($timezone)->subHours(12)->startOfHour(),
                    'end' => now($timezone),
                ];
            },
            '24h' => function () use ($timezone) {
                return [
                    'start' => now($timezone)->subHours(24)->startOfHour(),
                    'end' => now($timezone),
                ];
            },
            '7d' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subDays(7),
                    'end' => now($timezone),
                ];
            },
            '30d' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subDays(30),
                    'end' => now($timezone),
                ];
            },
            'thisWeek' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->startOfWeek(),
                    'end' => now($timezone),
                ];
            },
            'lastWeek' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subWeek()->startOfWeek(),
                    'end' => today($timezone)->subWeek()->endOfWeek(),
                ];
            },
            'thisMonth' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->startOfMonth(),
                    'end' => now($timezone),
                ];
            },
            'lastMonth' => function () use ($timezone) {
                return [
                    'start' => today($timezone)->subMonth()->startOfMonth(),
                    'end' => today($timezone)->subMonth()->endOfMonth(),
                ];
            },
        ];
    }

    /**
     * @param  null|array  $range
     * @return array|string[]
     */
    private function getRangeData(null|array $range)
    {
        if (is_null($range)) {
            return [
                'interval' => 'today',
            ];
        }

        return $range;
    }

    /**
     * @param  array|null  $range
     * @param  bool  $exact
     * @return array
     *
     * @throws Exception
     */
    public function getRangeSettingsFromRangeArray(null|array $range, bool $exact = false)
    {
        $range = $this->getRangeData($range);

        if (isset($range['interval'])) {
            return $this->getRangeSettingsFromIntervalString($range['interval'], $exact);
        }

        $startDate = Carbon::parse($range['start']);
        $endDate = Carbon::parse($range['end']);

        switch (true) {
            case $startDate->diff($endDate)->days === 0 || $startDate->diff($endDate)->days < 7:
                $spec = 'PT30M';
                $query = 'INTERVAL 30 MINUTE';
                break;
            case $startDate->diff($endDate)->days && $startDate->diff($endDate)->days <= 60:
                $spec = 'P1D';
                $query = 'INTERVAL 1 DAY';
                break;
            default:
                $spec = 'P1W';
                $query = 'INTERVAL 7 DAY';
        }

        return [
            'period' => new DatePeriod(
                $startDate,
                new DateInterval($spec),
                $endDate
            ),
            'period_step_in_seconds' => $this->getTotalSecondsFromIntervalString($spec),
            'settings' => [
                'query' => $query,
                'spec' => $spec,
                'start' => $startDate,
                'end' => $endDate,
            ],
        ];
    }

    /**
     * @param  string|null  $interval
     * @param  bool  $exact
     * @param  string  $fallback
     * @return array
     *
     * @throws \Exception
     */
    private function getRangeSettingsFromIntervalString(
        string $interval = null,
        bool $exact = false,
        string $fallback = 'today'
    ) {
        $mappings = $exact ? $this->getExactIntervalStringMappings() : $this->getIntervalStringMappings();
        $settings = $mappings[$interval] ?? $mappings[$fallback];
        $period = new DatePeriod(
            $settings['start'],
            new DateInterval($settings['spec']),
            $settings['end']
        );

        return [
            'period' => $period,
            'period_step_in_seconds' => $this->getTotalSecondsFromIntervalString($settings['spec']),
            'settings' => $settings,
        ];
    }

    /**
     * @return array
     */
    private function getExactIntervalStringMappings()
    {
        return [
            'all' => [
                'query' => 'INTERVAL 1 MONTH',
                'spec' => 'P1M',
                'start' => today()->subMonths(6),
                'end' => now(),
            ],
            'today' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => today(),
                'end' => now(),
            ],
            'yesterday' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => today()->subDay(),
                'end' => today(),
            ],
            'theDayBeforeYesterday' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => today()->subDays(2),
                'end' => today()->subDay(),
            ],
            '12h' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => now()->subHours(12),
                'end' => now(),
            ],
            '24h' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => now()->subHours(24),
                'end' => now(),
            ],
            '7d' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subWeek(),
                'end' => today()->endOfDay(),
            ],
            '30d' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subMonth(),
                'end' => today()->endOfDay(),
            ],
            'thisWeek' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->startOfWeek(),
                'end' => today()->endOfWeek(),
            ],
            'lastWeek' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subWeek()->startOfWeek(),
                'end' => today()->startOfWeek(),
            ],
            'thisMonth' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->startOfMonth(),
                'end' => today()->endOfMonth(),
            ],
            'lastMonth' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subMonth()->startOfMonth(),
                'end' => today()->startOfMonth(),
            ],
        ];
    }

    /**
     * @return array
     */
    private function getIntervalStringMappings()
    {
        return [
            'all' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => today(),
                'end' => null,
            ],
            'today' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => today(),
                'end' => $this->nearestNow('+30 minutes')->subMinutes(30),
            ],
            'yesterday' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => Carbon::yesterday(),
                'end' => today(),
            ],
            'theDayBeforeYesterday' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => Carbon::yesterday()->subDay(),
                'end' => Carbon::yesterday(),
            ],
            '12h' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => Carbon::now()->subHours(12)->startOfHour(),
                'end' => $this->nearestNow('+30 minutes')->subMinutes(30),
            ],
            '24h' => [
                'query' => 'INTERVAL 30 MINUTE',
                'spec' => 'PT30M',
                'start' => Carbon::now()->subHours(24)->startOfHour(),
                'end' => $this->nearestNow('+30 minutes')->subMinutes(30),
            ],
            '7d' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subWeek(),
                'end' => today()->endOfDay(),
            ],
            '30d' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subMonth(),
                'end' => today()->endOfDay(),
            ],
            'thisWeek' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->startOfWeek(),
                'end' => today()->endOfDay(),
            ],
            'lastWeek' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subWeek()->startOfWeek(),
                'end' => today()->startOfWeek(),
            ],
            'thisMonth' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->startOfMonth(),
                'end' => today()->endOfDay(),
            ],
            'lastMonth' => [
                'query' => 'INTERVAL 1 DAY',
                'spec' => 'P1D',
                'start' => today()->subMonth()->startOfMonth(),
                'end' => today()->startOfMonth(),
            ],
        ];
    }

    /**
     * @param $interval
     * @return Carbon
     */
    private function nearestNow($interval)
    {
        $instance = today();

        while ($instance->lessThan(now())) {
            $instance->modify($interval);
        }

        return $instance;
    }

    /**
     * @param $interval
     * @return float
     *
     * @throws \Exception
     */
    public function getTotalSecondsFromIntervalString($interval)
    {
        return (new CarbonInterval($interval))->totalSeconds;
    }

    /**
     * @param  string  $string
     * @param  string  $fallback
     * @return mixed
     */
    public function getRangeSettingsForLogsFromString(string $string, string $fallback = 'today')
    {
        return $this->getIntervalStringMappingsForLogs()[$string]
            ?? $this->getIntervalStringMappingsForLogs()[$fallback];
    }

    /**
     * @return array
     */
    private function getIntervalStringMappingsForLogs()
    {
        return [
            'today' => [
                'start' => today(),
                'end' => Carbon::tomorrow(),
            ],
            'yesterday' => [
                'start' => Carbon::yesterday(),
                'end' => today(),
            ],
            'theDayBeforeYesterday' => [
                'start' => Carbon::yesterday()->subDay(),
                'end' => Carbon::yesterday(),
            ],
        ];
    }
}
