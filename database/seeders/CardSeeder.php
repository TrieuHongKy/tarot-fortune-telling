<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Card::truncate();

        $csvFile = fopen(base_path("database/data/cards.csv"), "r");

        $chunkSize = 200;

        $data = [];

        $firstline = TRUE;
        while (($rowData = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                if (isset($rowData[3], $rowData[4], $rowData[5], $rowData[6], $rowData[7], $rowData[8])){
                    $data [] = [
                        "name"        => $rowData['3'],
                        "image"       => $rowData['4'],
                        "description" => $rowData['6'],
                        "meaning_up"  => $rowData['7'],
                        "meaning_rev" => $rowData['8'],
                        "deck_id"     => $rowData['5']
                    ];
                }
            }
            $firstline = FALSE;
        }
        collect($data)->chunk($chunkSize)->each(function ($chunk){
            Card::insert($chunk->toArray());
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
