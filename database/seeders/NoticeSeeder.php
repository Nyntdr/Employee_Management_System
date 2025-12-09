<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notices')->insert([
            [
                'title' => 'Employee See this!!',
                'content'=>'Loremu ipsum dahila is coming out soon.',
                'posted_by'=> 3,
                'published_at'=>now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
