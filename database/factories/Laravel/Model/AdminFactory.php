<?php

namespace Database\Factories\Laravel\Model;

use Laravel\Model\Admin; // Adjust this based on your namespace
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            //
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('admin123')
            
        ];
    }
}
