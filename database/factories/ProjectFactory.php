<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(rand(2, 4), true);
        $techOptions = ['Laravel', 'PHP', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'MySQL', 'PostgreSQL', 'Redis', 'Vue.js', 'React', 'TypeScript', 'Node.js', 'Docker'];

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => implode("\n\n", fake()->paragraphs(3)),
            'url' => fake()->optional(0.7)->url(),
            'technologies' => fake()->randomElements($techOptions, rand(2, 5)),
            'sort_order' => 0,
            'published_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'published_at' => null,
        ]);
    }
}
