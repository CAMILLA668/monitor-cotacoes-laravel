<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AssetSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(AssetSeeder::class);
        User::updateOrCreate(
            ['email' => 'demo@marketwatch.test'],
            [
                'name'  => 'Usuário Demo',
                'password'  => 12345678,
                'status'    => true
            ]
        );
    }
}
