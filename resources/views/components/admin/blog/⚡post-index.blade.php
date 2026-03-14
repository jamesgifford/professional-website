<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component
{
    public function delete(Post $post): void
    {
        $post->delete();
    }

    /**
     * @return array<string, mixed>
     */
    public function with(): array
    {
        return [
            'posts' => Post::query()->latest()->get(),
        ];
    }
};
?>

<div>
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl">{{ __('Blog Posts') }}</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('admin.blog.create')" wire:navigate>
            {{ __('New Post') }}
        </flux:button>
    </div>

    <div class="space-y-2">
        @forelse ($posts as $post)
            <div wire:key="post-{{ $post->id }}" class="flex items-center justify-between gap-4 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-3">
                        <flux:heading size="sm" class="truncate">{{ $post->title }}</flux:heading>
                        @if ($post->isPublished())
                            <flux:badge size="sm" color="green">{{ __('Published') }}</flux:badge>
                        @else
                            <flux:badge size="sm" color="zinc">{{ __('Draft') }}</flux:badge>
                        @endif
                    </div>
                    <flux:text size="sm" class="mt-1">
                        {{ $post->published_at?->format('M j, Y') ?? __('Not published') }}
                    </flux:text>
                </div>

                <div class="flex items-center gap-2">
                    <flux:button variant="subtle" size="sm" icon="pencil-square" :href="route('admin.blog.edit', $post)" wire:navigate />
                    <flux:button variant="subtle" size="sm" icon="trash" wire:click="delete({{ $post->id }})" wire:confirm="{{ __('Are you sure you want to delete this post?') }}" />
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-zinc-300 dark:border-zinc-700 p-8 text-center">
                <flux:text>{{ __('No posts yet. Create your first one!') }}</flux:text>
            </div>
        @endforelse
    </div>
</div>
