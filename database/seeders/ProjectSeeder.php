<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('screenshots');
        Storage::disk('public')->makeDirectory('screenshots');

        $projects = Project::factory()->count(4)->create();
        Project::factory()->draft()->create();

        $palettes = [
            ['bg' => [15, 23, 42], 'fg' => [56, 189, 248]],   // slate + sky
            ['bg' => [24, 24, 27], 'fg' => [52, 211, 153]],    // zinc + emerald
            ['bg' => [30, 10, 60], 'fg' => [192, 132, 252]],   // purple tones
            ['bg' => [20, 30, 30], 'fg' => [251, 191, 36]],    // dark teal + amber
        ];

        foreach ($projects as $index => $project) {
            $count = rand(1, 5);
            $palette = $palettes[$index % count($palettes)];

            for ($i = 1; $i <= $count; $i++) {
                $path = $this->generateScreenshot($project->name, $i, $count, $palette);
                $project->screenshots()->create([
                    'path' => $path,
                    'alt_text' => $project->name.' - Screenshot '.$i,
                    'sort_order' => $i,
                ]);
            }
        }
    }

    /**
     * @param  array{bg: array<int, int>, fg: array<int, int>}  $palette
     */
    private function generateScreenshot(string $projectName, int $number, int $total, array $palette): string
    {
        $width = 1280;
        $height = 720;

        $image = imagecreatetruecolor($width, $height);

        $bg = imagecolorallocate($image, ...$palette['bg']);
        $fg = imagecolorallocate($image, ...$palette['fg']);
        $muted = imagecolorallocate($image,
            (int) ($palette['bg'][0] * 0.6 + $palette['fg'][0] * 0.4),
            (int) ($palette['bg'][1] * 0.6 + $palette['fg'][1] * 0.4),
            (int) ($palette['bg'][2] * 0.6 + $palette['fg'][2] * 0.4),
        );
        $subtle = imagecolorallocate($image,
            min(255, $palette['bg'][0] + 20),
            min(255, $palette['bg'][1] + 20),
            min(255, $palette['bg'][2] + 20),
        );

        imagefill($image, 0, 0, $bg);

        // Draw a grid pattern
        for ($x = 0; $x < $width; $x += 40) {
            imageline($image, $x, 0, $x, $height, $subtle);
        }
        for ($y = 0; $y < $height; $y += 40) {
            imageline($image, 0, $y, $width, $y, $subtle);
        }

        // Draw some decorative rectangles
        $rectColor = imagecolorallocatealpha($image, $palette['fg'][0], $palette['fg'][1], $palette['fg'][2], 110);
        imagefilledrectangle($image, 60, 60, 300, 100, $rectColor);
        imagefilledrectangle($image, 60, 120, 500, 140, $subtle);
        imagefilledrectangle($image, 60, 160, 420, 180, $subtle);

        // Sidebar mock
        imagefilledrectangle($image, $width - 320, 60, $width - 60, $height - 60, $subtle);

        // Card mocks in sidebar
        for ($c = 0; $c < 3; $c++) {
            $cardY = 80 + ($c * 120);
            imagefilledrectangle($image, $width - 300, $cardY, $width - 80, $cardY + 100, $bg);
            imagerectangle($image, $width - 300, $cardY, $width - 80, $cardY + 100, $rectColor);
        }

        // Content area mocks
        for ($row = 0; $row < 4; $row++) {
            $lineY = 220 + ($row * 50);
            $lineWidth = rand(300, 560);
            imagefilledrectangle($image, 60, $lineY, 60 + $lineWidth, $lineY + 12, $subtle);
        }

        // Project name (large)
        $fontSize = 5;
        $nameX = (int) (($width - strlen($projectName) * imagefontwidth($fontSize)) / 2);
        $nameY = (int) ($height / 2 - 20);
        imagestring($image, $fontSize, $nameX, $nameY, $projectName, $fg);

        // Screenshot label
        $label = "Screenshot {$number} of {$total}";
        $labelX = (int) (($width - strlen($label) * imagefontwidth(3)) / 2);
        imagestring($image, 3, $labelX, $nameY + 30, $label, $muted);

        $filename = 'screenshots/'.fake()->uuid().'.png';
        $fullPath = Storage::disk('public')->path($filename);

        imagepng($image, $fullPath);
        imagedestroy($image);

        return $filename;
    }
}
