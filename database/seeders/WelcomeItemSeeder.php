<?php

namespace Database\Seeders;

use App\Models\WelcomeItem;
use Illuminate\Database\Seeder;

class WelcomeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $obj = new WelcomeItem();
        $obj->heading = "Welcome to TripSummit";
        $obj->description = "At TripSummit, our mission is to turn travel dreams into reality by providing personalized and memorable experiences. We leverage our expertise and trusted partners to ensure every trip is seamless and enjoyable.<br>
                We believe travel fosters personal growth and cultural understanding. Our goal is to help clients explore new destinations and connect with diverse cultures. We promote sustainable travel to positively impact communities and preserve our planet’s beauty.";
        $obj->photo = "about-1.jpg";
        $obj->video = "S4DI3Bve_bQ";
        $obj->button_text = "Read More";
        $obj->button_link = "#";
        $obj->status = "Show";
        $obj->save();
    }
}
