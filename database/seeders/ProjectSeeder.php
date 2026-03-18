<?php

namespace Database\Seeders;

use App\Models\Project;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProjectSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::cleanDirectory(public_path('images/screenshots'));

        $projects = Project::factory()->count(8)->create();
        Project::factory()->draft()->count(2)->create();

        foreach ($projects as $index => $project) {
            $palette = $this->palettes[$index % count($this->palettes)];

            // Give most projects a featured image
            if (fake()->boolean(80)) {
                $project->update([
                    'featured_image' => $this->generatePlaceholderImage(
                        label: $project->name,
                        directory: 'images/featured',
                        subtitle: 'Featured',
                        palette: $palette,
                    ),
                ]);
            }

            // Screenshots
            $count = rand(1, 5);
            for ($i = 1; $i <= $count; $i++) {
                $filename = $this->generatePlaceholderImage(
                    label: $project->name,
                    directory: 'images/screenshots',
                    subtitle: "Screenshot {$i} of {$count}",
                    palette: $palette,
                );
                $project->screenshots()->create([
                    'path' => 'images/screenshots/'.$filename,
                    'alt_text' => $project->name.' - Screenshot '.$i,
                    'sort_order' => $i,
                ]);
            }
        }
    }
}
