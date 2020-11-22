<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messenger')->insert([
            [
                'id' => 1,
                'name' => 'Telegram'
            ], [
                'id' => 2,
                'name' => 'Viber'
            ]
        ]);
    }
}
