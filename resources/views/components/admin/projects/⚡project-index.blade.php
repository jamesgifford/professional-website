<?php

use App\Models\Project;
use Livewire\Component;

new class extends Component
{
    public function delete(Project $project): void
    {
        $project->delete();
    }

    /**
     * @return array<string, mixed>
     */
    public function with(): array
    {
        return [
            'projects' => Project::query()->latest()->get(),
        ];
    }
};
?>

<div>
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Projects') }}</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('admin.projects.create')" wire:navigate>
            {{ __('New Project') }}
        </flux:button>
    </div>

    <div class="space-y-2">
        @forelse ($projects as $project)
            <div wire:key="project-{{ $project->id }}" class="flex items-center justify-between gap-4 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-3">
                        <flux:heading size="sm" class="truncate">{{ $project->name }}</flux:heading>
                        @if ($project->isPublished())
                            <flux:badge size="sm" color="green">{{ __('Published') }}</flux:badge>
                        @else
                            <flux:badge size="sm" color="zinc">{{ __('Draft') }}</flux:badge>
                        @endif
                    </div>
                    @if ($project->technologies)
                        <flux:text size="sm" class="mt-1">
                            {{ implode(', ', $project->technologies) }}
                        </flux:text>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <flux:button variant="subtle" size="sm" icon="pencil-square" :href="route('admin.projects.edit', $project)" wire:navigate />
                    <flux:button variant="subtle" size="sm" icon="trash" wire:click="delete({{ $project->id }})" wire:confirm="{{ __('Are you sure you want to delete this project?') }}" />
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-zinc-300 dark:border-zinc-700 p-8 text-center">
                <flux:text>{{ __('No projects yet. Add your first one!') }}</flux:text>
            </div>
        @endforelse
    </div>
</div>
