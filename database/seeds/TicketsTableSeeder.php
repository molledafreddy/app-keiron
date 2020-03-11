<?php

use Illuminate\Database\Seeder;

use App\Ticket;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ticket::class)->times(10)->create();

    }
}
