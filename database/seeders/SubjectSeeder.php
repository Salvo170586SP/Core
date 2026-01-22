<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = config('Core.subjects');

        foreach ($subjects as $s) {
            Subject::create([
                'code' => $s['code'],
                'name' => $s['label'],
                'description' => $s['desc'],
                'hours' => $s['hours'],
            ]);
        }
    }
}
