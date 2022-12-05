<?php

namespace App\Enums\Date;

enum IntervalTypes: string
{
    case ALL = 'all';
    case TODAY = 'today';
    case YESTERDAY = 'yesterday';
    case TWELVE_HOURS = '12H';
    case TWENTY_FOUR_HOURS = '24H';
    case SEVEN_DAYS = '7d';
    case THIRTY_DAYS = '30d';
    case THIS_WEEK = 'thisWeek';
    case LAST_WEEK = 'lastWeek';
    case THIS_MONTH = 'thisMonth';
    case LAST_MONTH = 'lastMonth';
}
