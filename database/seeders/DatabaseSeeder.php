<?php

namespace Database\Seeders;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        ## House Cleaning
        DB::table('settings')->truncate();

        ## Settings
        Setting::firstOrCreate(
            ['setting'          => 'installed'],
            [
                'value'         => false,
                'default'       => false,
                'description'   => 'Is OpenInnovaCDR installed'
            ]
        );
    }
}
