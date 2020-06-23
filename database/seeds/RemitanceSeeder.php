<?php

use Illuminate\Database\Seeder;

class RemitanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('remitances')->delete();
        factory(App\Remitance::class, 150)->create();
    }
}
