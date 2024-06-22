<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'whisnu@watumasclinic.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
            'phone' => '081234567890',
        ]);

        \App\Models\ProfileClinic::factory()->create([
            'name' => 'Watumas Clinic',
            'address' => 'Jl. Letjend Pol. Soemarto No.16, Watumas, Purwanegara, Kec. Purwokerto Tim., Kabupaten Banyumas, Jawa Tengah 53127',
            'phone' => '(0281) 7779220',
            'email' => 'official@watumasclinic.com',
            'doctor_name' => 'Dr. Ananda P.',
            'unique_code' => '7779220',
        ]);

        $this->call(DoctorSeeder::class);
    }
}
