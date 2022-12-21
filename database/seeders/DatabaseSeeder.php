<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Gig;
use App\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory(10)->create();

        foreach ($user as $value) {
            $company = Company::factory(10)->create([
                'user_id' => $value->id
            ]);

            foreach($company as $company_value){
                Gig::factory(10)->create([
                    'company_id' => $company_value->id
                ]);
            }
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
