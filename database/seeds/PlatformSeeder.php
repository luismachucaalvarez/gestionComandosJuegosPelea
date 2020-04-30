<?php

use App\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platform = new Platform();
        $platform->name = 'PlayStation 4';
        $platform->save();
    }
}
