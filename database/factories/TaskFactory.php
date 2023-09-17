<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject'      => fake()->text(100),
            'description'  => fake()->text(),
            'status'       => array_rand(['in_progress', 'resolved', 'new', 'feedback', 'rejected']),
            'type'         => array_rand(['bug', 'support', 'feature']),
            'due_date'     => now()->addDays(15)->format('Y-m-d'),
            'start_date'   => now()->format('Y-m-d'),
        ];
    }
}
