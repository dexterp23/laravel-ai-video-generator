<?php

namespace Database\Seeders;

use App\Models\CronLock;
use Illuminate\Database\Seeder;

class CronLockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = getAllDbTables();
        foreach ($tables as $table) {
            CronLock::firstOrCreate(
                ['table' => $table],
                [
                    'table' => $table,
                    'date' => now()
                ]
            );
        }
    }
}
