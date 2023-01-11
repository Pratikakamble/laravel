<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $departments =  Department::pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'department_id' => fake()->randomElement($departments),
            'email' => fake()->unique()->safeEmail(),
            'course' => fake()->word(),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'image'=> fake()->imageUrl($width=400, $height=400)
        ];
    }
}
