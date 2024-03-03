<?php

namespace Database\Seeders;

use App\Models\Spread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Spread::truncate();

        $csvFile = fopen(base_path("database/data/spreads.csv"), "r");

        $chunkSize = 100;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                $data [] = [
                    "card_id"       => $rowData['2'],
                    "theme_id" => $rowData['4'],
                    "card_position" => $rowData['3'],
                    "warning" => $rowData['5'],
                    "advise" => $rowData['6'],
                    "meaning" => $rowData['7'],
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            }
            $firstline = FALSE;
        }

        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Spread::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
