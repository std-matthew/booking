<?php

use Illuminate\Database\Seeder;

use App\BookingLocation;
use App\BookingCategory;
use App\BookingType;
use App\BookingTime;

class BookingTableSeeder extends Seeder
{
    protected $times = [
        [
            'id' => 1,
            'start_time'  => '08:00',
            'end_time'  => '09:50',
        ],
        [
            'id' => 2,
            'start_time'  => '10:00',
            'end_time'  => '11:50',
        ],
        [
            'id' => 3,
            'start_time'  => '12:00',
            'end_time'  => '13:50',
        ],
        [
            'id' => 4,
            'start_time'  => '14:00',
            'end_time'  => '15:50',
        ],
        [
            'id' => 5,
            'start_time'  => '16:00',
            'end_time'  => '17:50',
        ],
        [
            'id' => 6,
            'start_time'  => '08:00',
            'end_time'  => '11:50',
        ],
        [
            'id' => 7,
            'start_time'  => '14:00',
            'end_time'  => '17:50',
        ],
        [
            'id' => 8,
            'start_time'  => '08:00',
            'end_time'  => '17:50',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteTables();
        $this->populateTables();
    }

    private function deleteTables() {
        DB::table('booking_locations')->delete();
    	DB::table('booking_categories')->delete();
        DB::table('booking_types')->delete();
        DB::table('booking_times')->delete();
    }

    private function populateTables() {
        foreach ($this->times as $time) {
            BookingTime::create($time);
        }

        factory(BookingLocation::class, 3)->create()->each(function($location) {
            $location->categories()->saveMany(factory(BookingCategory::class, 2)->create()->each(function($category) {
                $category->types()->saveMany(factory(BookingType::class, 5)->create()->each(function($type) {
                    $ids = BookingTime::all()->random(5)->pluck('id')->toArray();
                    $type->times()->attach($ids);
                }));
            }));
        });
    }
}
