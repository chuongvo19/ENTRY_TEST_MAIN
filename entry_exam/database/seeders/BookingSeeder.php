<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            foreach (range(1, rand(1, 5)) as $index) {
                $hotel->bookings()->create([
                    'customer_name' => 'Customer ' . $index,
                    'customer_contact' => 'contact' . $index . '@example.com',
                    'checkin_time' => $checkin_time = Carbon::now()->subDays(rand(1, 10)),
                    'checkout_time' => Carbon::parse($checkin_time)->addDays(rand(1, 10)),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
