<?php

namespace App\Models;

use Database\Factories\ProjectScreenshotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectScreenshot extends Model
{
    /** @use HasFactory<ProjectScreenshotFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'path',
        'alt_text',
        'sort_order',
    ];

    public function getFullPathAttribute(): ?string
    {
        $filename = $this->attributes['path'] ?? null;

        return $filename ? 'images/screenshots/'.$filename : null;
    }

    /**
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
