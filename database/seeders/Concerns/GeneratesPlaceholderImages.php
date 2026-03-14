<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;

trait GeneratesPlaceholderImages
{
    /** @var list<array{bg: array<int, int>, fg: array<int, int>}> */
    private array $palettes = [
        ['bg' => [15, 23, 42], 'fg' => [56, 189, 248]],    // slate + sky
        ['bg' => [24, 24, 27], 'fg' => [52, 211, 153]],     // zinc + emerald
        ['bg' => [30, 10, 60], 'fg' => [192, 132, 252]],    // purple tones
        ['bg' => [20, 30, 30], 'fg' => [251, 191, 36]],     // dark teal + amber
        ['bg' => [40, 10, 10], 'fg' => [251, 113, 133]],    // dark red + rose
        ['bg' => [10, 30, 40], 'fg' => [96, 165, 250]],     // navy + blue
    ];

    /**
     * @param  array{bg: array<int, int>, fg: array<int, int>}|null  $palette
     */
    private function generatePlaceholderImage(
        string $label,
        string $directory,
        int $width = 1280,
        int $height = 720,
        ?string $subtitle = null,
        ?array $palette = null,
    ): string {
        $palette ??= $this->palettes[array_rand($this->palettes)];

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

        // Grid pattern
        for ($x = 0; $x < $width; $x += 40) {
            imageline($image, $x, 0, $x, $height, $subtle);
        }
        for ($y = 0; $y < $height; $y += 40) {
            imageline($image, 0, $y, $width, $y, $subtle);
        }

        // Decorative UI elements
        $rectColor = imagecolorallocatealpha($image, $palette['fg'][0], $palette['fg'][1], $palette['fg'][2], 110);
        imagefilledrectangle($image, 60, 60, 300, 100, $rectColor);
        imagefilledrectangle($image, 60, 120, 500, 140, $subtle);
        imagefilledrectangle($image, 60, 160, 420, 180, $subtle);

        imagefilledrectangle($image, $width - 320, 60, $width - 60, $height - 60, $subtle);

        for ($c = 0; $c < 3; $c++) {
            $cardY = 80 + ($c * 120);
            imagefilledrectangle($image, $width - 300, $cardY, $width - 80, $cardY + 100, $bg);
            imagerectangle($image, $width - 300, $cardY, $width - 80, $cardY + 100, $rectColor);
        }

        for ($row = 0; $row < 4; $row++) {
            $lineY = 220 + ($row * 50);
            $lineWidth = rand(300, 560);
            imagefilledrectangle($image, 60, $lineY, 60 + $lineWidth, $lineY + 12, $subtle);
        }

        // Label
        $fontSize = 5;
        $labelX = (int) (($width - strlen($label) * imagefontwidth($fontSize)) / 2);
        $labelY = (int) ($height / 2 - 20);
        imagestring($image, $fontSize, $labelX, $labelY, $label, $fg);

        if ($subtitle) {
            $subtitleX = (int) (($width - strlen($subtitle) * imagefontwidth(3)) / 2);
            imagestring($image, 3, $subtitleX, $labelY + 30, $subtitle, $muted);
        }

        Storage::disk('public')->makeDirectory($directory);
        $filename = $directory.'/'.fake()->uuid().'.png';
        $fullPath = Storage::disk('public')->path($filename);

        imagepng($image, $fullPath);
        imagedestroy($image);

        return $filename;
    }
}
