<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0;$i<5;$i++) {
            DB::table('posts')->insert([
                'title' => fake()->text(255),
                'author' => fake()->name(),
                'excerpt' => fake()->text(),
                'text' => fake()->text(),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
