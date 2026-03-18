<?php

namespace Database\Seeders;

use App\Models\Post;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::cleanDirectory(public_path('images/featured'));

        $posts = Post::factory()->count(12)->create();
        Post::factory()->draft()->count(2)->create();

        // Give most posts a featured image
        foreach ($posts as $post) {
            if (fake()->boolean(75)) {
                $post->update([
                    'featured_image' => $this->generatePlaceholderImage(
                        label: $post->title,
                        directory: 'images/featured',
                    ),
                ]);
            }
        }
    }
}
