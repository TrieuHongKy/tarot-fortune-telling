<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Theme::truncate();

        $csvFile = fopen(base_path("database/data/themes.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                Theme::create([
                    "name"       => $data['3'],
                    "description" => $data['4']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
