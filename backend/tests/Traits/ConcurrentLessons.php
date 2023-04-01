<?php

namespace Tests\Traits;

use App\Models\ConcurrentLessonTime;
use App\Models\Customer;
use App\Models\LessonsPlan;
use App\Models\Sale;
use Carbon\Carbon;
use Database\Seeders\DaySeeder;

trait ConcurrentLessons
{
  private Customer $customer;
  public array $data;

  private function getExpectedReservations(): int
  {
    return array_reduce(range(0, 30), function($carry, $count) {
      return array_key_exists(Carbon::now()->addDays($count)->dayOfWeek, $this->data) ? $carry + 1 : $carry;
    }, 0);
  }

  private function createCustomer(): void
  {
    $this->customer = Customer::factory()->create();
  }

  private function createSale(): void
  {
    Sale::factory()->create([
      'customer_id' => $this->customer->id,
      'lessons_plan_id' => LessonsPlan::factory()->create()->id,
      'date' => Carbon::now(),
    ]);
  }

  private function createConcurrentLessonTimes(): void
  {
    $this->seed(DaySeeder::class);

    $concurrentLessonTime = ConcurrentLessonTime::factory()->create();
    $concurrentLessonTime->days()->attach(array_values($this->daysFactory));
  }

  private function setData(): void
  {
    $this->data = array_fill_keys(
      $this->daysFactory, 
      ConcurrentLessonTime::all()->first()->time
    );
  }

  public function createConcurrentLessonsDependencies(): void
  {
    $this->createCustomer();
    $this->createSale();
    $this->createConcurrentLessonTimes();
    $this->setData();
  }
}
