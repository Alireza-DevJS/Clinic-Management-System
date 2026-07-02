<?php

namespace App\Models;

use App\Enums\WeekDay;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
     use HasFactory;
   protected $guarded = [];

  protected function casts(): array
{
    return [
        'day_of_week' => WeekDay::class,
    ];
}
}
