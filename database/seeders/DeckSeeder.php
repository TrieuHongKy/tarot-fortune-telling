<?php

namespace Database\Seeders;

use App\Models\Deck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        Deck::truncate();

        $csvFile = fopen(base_path("database/data/decks.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                Deck::create([
                    "name"       => $data['3'],
                    "description" => $data['5']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
