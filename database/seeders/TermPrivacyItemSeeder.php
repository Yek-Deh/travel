<?php

namespace Database\Seeders;

use App\Models\TermPrivacyItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermPrivacyItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $obj = new TermPrivacyItem();
        $obj->term = 'Term Data Here';
        $obj->privacy = 'Privacy Data Here';
        $obj->save();
    }
}
