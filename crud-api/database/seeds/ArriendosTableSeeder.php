<?php

use Illuminate\Database\Seeder;

class ArriendosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Arriendo::class, 10)->create();

    }
}
