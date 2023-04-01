<?php

namespace Tests\Traits;

use Carbon\Carbon;

trait DaysFactory
{
  public $daysFactory = [
    Carbon::MONDAY,
    Carbon::TUESDAY,
    Carbon::WEDNESDAY,
    Carbon::THURSDAY,
    Carbon::FRIDAY,
    Carbon::SATURDAY,
  ];
}
