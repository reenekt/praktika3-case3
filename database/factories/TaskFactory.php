<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description_content' => $this->makeDescriptionContentFieldValue(),
            'status' => $this->faker->randomElement(TaskStatusEnum::cases()),
            'author_id' => User::factory(),
            'assignee_id' => $this->faker->boolean() ? User::factory() : null,
            'deadline_at' => $this->faker->boolean() ? Carbon::now()->addDays($this->faker->numberBetween(1, 14))->startOfDay() : null,
        ];
    }

    public function author(User $user): static
    {
        return $this->state([
            'author_id' => $user->id,
        ]);
    }

    protected function makeDescriptionContentFieldValue(): string
    {
        return collect($this->faker->paragraphs(rand(1, 5)))
            ->map(fn($p) => "<p>{$p}</p>")
            ->implode('');
    }
}
