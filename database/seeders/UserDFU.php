<?php

namespace Database\Seeders;

use App\Models\Obras;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDFU extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
            'name' => 'Mateus',
            'email' => 'eng.mserpa@gmail.com'

        ]);
        Obras::factory()->create([[
            'obra' => 'Obra 1'
        ]]);
    }
}
