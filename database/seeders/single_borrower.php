<?php

namespace Database\Seeders;

use App\Models\borrower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class single_borrower extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        borrower::create();
    }
}
