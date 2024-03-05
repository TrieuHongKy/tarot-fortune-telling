<?php

namespace Database\Seeders;

use App\Models\DeckCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeckCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    : void{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // tắt kiểm tra khóa ngoại

        DeckCard::truncate();

        $csvFile = fopen(base_path("database/data/deck_cards.csv"), "r");

        $firstline = TRUE;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE){
            if (!$firstline){
                DeckCard::create([
                    "deck_id"       => $data['1'],
                    "card_id" => $data['2'],
                    "position" => $data['3']
                ]);
            }
            $firstline = FALSE;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // khôi phục kiểm tra khóa ngoại

        fclose($csvFile);
    }
}
