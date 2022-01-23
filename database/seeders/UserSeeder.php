<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $admin = User::create([
            'name' => 'Admin',
            'username' => Str::slug($faker->word()),
            'email' => 'admin@admin.com',
            'password' => Hash::make('1234567890'),
            'image' => $faker->randomElement(['10.png', '1.png']),
            'phone' => $faker->phoneNumber()
        ]);

        $admin->assignRole(User::ADMIN);

        $user = User::create([
            'name' => 'User',
            'username' => Str::slug($faker->word()),
            'email' => 'user@user.com',
            'password' => Hash::make('1234567890'),
            'image' => $faker->randomElement(['10.png', '1.png']),
            'phone' => $faker->phoneNumber()
        ]);
        $user->assignRole(User::USER);


        for ($i=0; $i < rand(10, 20); $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email(),
                'username' => Str::slug($faker->name().$faker->word()),
                'password' => Hash::make('1234567890'),
                'status' => rand(1, 3),
                'image' => $faker->randomElement(['10.png', '1.png']),
                'phone' => $faker->phoneNumber()
            ]);
            $user->assignRole($faker->randomElement([User::USER, User::ADMIN]));
        }
    }
}
