<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    public function run(): void
    {
        EventType::factory()->count(10)->create();
    }
}
