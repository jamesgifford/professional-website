<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectScreenshot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectScreenshot>
 */
class ProjectScreenshotFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'path' => 'screenshots/'.fake()->uuid().'.png',
            'alt_text' => fake()->sentence(),
            'sort_order' => 0,
        ];
    }
}
