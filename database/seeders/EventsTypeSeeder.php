<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventType;

class EventsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventType::query()->create(['et_name' => 'معالم دينية']);
        EventType::query()->create(['et_name' => 'معالم تاريخية']);
        EventType::query()->create(['et_name' => 'متاحف']);
        EventType::query()->create(['et_name' => 'ترفيه']);
    }
}
