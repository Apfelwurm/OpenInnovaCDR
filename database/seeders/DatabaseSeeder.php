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
                'type'          => 'BOOL',
                'default'       => false,
                'description'   => 'Is OpenInnovaCDR installed'
            ]
        );
        Setting::firstOrCreate(
            ['setting'          => 'automatic_caller_creation'],
            [
                'value'         => true,
                'type'          => 'BOOL',
                'default'       => true,
                'description'   => 'enable automatic creation of callers from CDRs'
            ]
        );
        Setting::firstOrCreate(
            ['setting'          => 'automatic_caller_update'],
            [
                'value'         => true,
                'type'          => 'BOOL',
                'default'       => true,
                'description'   => 'enable automatic update of callers from CDRs'
            ]
        );
    }
}
