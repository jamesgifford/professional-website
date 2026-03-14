<?php

use App\Models\Project;
use App\Models\ProjectScreenshot;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public ?Project $project = null;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public string $url = '';
    public string $technologiesInput = '';
    public bool $published = false;

    /** @var array<int, \Livewire\Features\SupportFileUploads\TemporaryUploadedFile> */
    public array $newScreenshots = [];

    /** @var array<int, array{id: int, path: string, alt_text: string|null}> */
    public array $existingScreenshots = [];

    public function mount(?Project $project = null): void
    {
        if ($project?->exists) {
            $this->project = $project;
            $this->name = $project->name;
            $this->slug = $project->slug;
            $this->description = $project->description;
            $this->url = $project->url ?? '';
            $this->technologiesInput = implode(', ', $project->technologies ?? []);
            $this->published = $project->isPublished();
            $this->existingScreenshots = $project->screenshots
                ->map(fn (ProjectScreenshot $s) => ['id' => $s->id, 'path' => $s->path, 'alt_text' => $s->alt_text])
                ->toArray();
        }
    }

    public function updatedName(string $value): void
    {
        if (! $this->project?->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function removeExistingScreenshot(int $index): void
    {
        unset($this->existingScreenshots[$index]);
        $this->existingScreenshots = array_values($this->existingScreenshots);
    }

    public function removeNewScreenshot(int $index): void
    {
        unset($this->newScreenshots[$index]);
        $this->newScreenshots = array_values($this->newScreenshots);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:projects,slug,' . $this->project?->id],
            'description' => ['required', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'technologiesInput' => ['nullable', 'string'],
            'published' => ['boolean'],
            'newScreenshots' => ['array'],
            'newScreenshots.*' => ['image', 'max:5120'],
        ]);

        $technologies = array_values(array_filter(
            array_map('trim', explode(',', $validated['technologiesInput']))
        ));

        $data = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'url' => $validated['url'] ?: null,
            'technologies' => $technologies,
        ];

        if ($validated['published'] && ! $this->project?->published_at) {
            $data['published_at'] = now();
        } elseif (! $validated['published']) {
            $data['published_at'] = null;
        }

        if ($this->project?->exists) {
            $this->project->update($data);
        } else {
            $this->project = Project::create($data);
        }

        // Sync existing screenshots (remove deleted ones)
        $keepIds = collect($this->existingScreenshots)->pluck('id')->toArray();
        $this->project->screenshots()->whereNotIn('id', $keepIds)->delete();

        // Store new screenshots
        $maxOrder = $this->project->screenshots()->max('sort_order') ?? 0;
        foreach ($this->newScreenshots as $file) {
            $path = $file->store('screenshots', 'public');
            $this->project->screenshots()->create([
                'path' => $path,
                'sort_order' => ++$maxOrder,
            ]);
        }

        session()->flash('status', $this->project->wasRecentlyCreated ? __('Project created.') : __('Project updated.'));

        $this->redirect(route('admin.projects.index'), navigate: true);
    }
};
?>

<div>
    <div class="mb-6">
        <flux:heading size="xl">{{ $project?->exists ? __('Edit Project') : __('New Project') }}</flux:heading>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-2xl">
        <flux:input wire:model.live.debounce.300ms="name" :label="__('Name')" required />

        <flux:input wire:model="slug" :label="__('Slug')" required />

        <flux:textarea wire:model="description" :label="__('Description')" rows="8" required />

        <flux:input wire:model="url" :label="__('URL')" type="url" placeholder="https://" />

        <flux:input wire:model="technologiesInput" :label="__('Technologies')" :description="__('Comma-separated list (e.g. Laravel, Tailwind CSS, MySQL)')" />

        {{-- Existing screenshots --}}
        @if (count($existingScreenshots))
            <flux:field>
                <flux:label>{{ __('Current Screenshots') }}</flux:label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-2">
                    @foreach ($existingScreenshots as $index => $screenshot)
                        <div wire:key="existing-{{ $screenshot['id'] }}" class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                            <img src="{{ Storage::disk('public')->url($screenshot['path']) }}" alt="{{ $screenshot['alt_text'] ?? '' }}" class="w-full aspect-video object-cover" />
                            <button type="button" wire:click="removeExistingScreenshot({{ $index }})" class="absolute top-2 right-2 size-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            </flux:field>
        @endif

        {{-- New screenshots --}}
        <flux:field>
            <flux:label>{{ __('Add Screenshots') }}</flux:label>
            <input type="file" wire:model="newScreenshots" multiple accept="image/*" class="mt-2 text-sm text-zinc-600 dark:text-zinc-400" />
            <flux:error name="newScreenshots.*" />
            @if (count($newScreenshots))
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4">
                    @foreach ($newScreenshots as $index => $file)
                        <div wire:key="new-{{ $index }}" class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                            <img src="{{ $file->temporaryUrl() }}" alt="" class="w-full aspect-video object-cover" />
                            <button type="button" wire:click="removeNewScreenshot({{ $index }})" class="absolute top-2 right-2 size-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs">
                                &times;
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </flux:field>

        <flux:field variant="inline">
            <flux:label>{{ __('Publish') }}</flux:label>
            <flux:switch wire:model="published" />
        </flux:field>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">
                {{ $project?->exists ? __('Update Project') : __('Create Project') }}
            </flux:button>
            <flux:button variant="ghost" :href="route('admin.projects.index')" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>
        </div>
    </form>
</div>
