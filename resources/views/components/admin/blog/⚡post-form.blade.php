<?php

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $body = '';
    public bool $published = false;

    public function mount(?Post $post = null): void
    {
        if ($post?->exists) {
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt ?? '';
            $this->body = $post->body;
            $this->published = $post->isPublished();
        }
    }

    public function updatedTitle(string $value): void
    {
        if (! $this->post?->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $this->post?->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'published' => ['boolean'],
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?: null,
            'body' => $validated['body'],
        ];

        if ($validated['published'] && ! $this->post?->published_at) {
            $data['published_at'] = now();
        } elseif (! $validated['published']) {
            $data['published_at'] = null;
        }

        if ($this->post?->exists) {
            $this->post->update($data);
        } else {
            $this->post = Post::create($data);
        }

        session()->flash('status', $this->post->wasRecentlyCreated ? __('Post created.') : __('Post updated.'));

        $this->redirect(route('admin.blog.index'), navigate: true);
    }
};
?>

<div>
    <div class="mb-6">
        <flux:heading size="xl">{{ $post?->exists ? __('Edit Post') : __('New Post') }}</flux:heading>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-2xl">
        <flux:input wire:model.live.debounce.300ms="title" :label="__('Title')" required />

        <flux:input wire:model="slug" :label="__('Slug')" required />

        <flux:textarea wire:model="excerpt" :label="__('Excerpt')" :description="__('A short summary shown on the blog listing.')" rows="2" />

        <flux:textarea wire:model="body" :label="__('Content')" rows="15" required />

        <flux:field variant="inline">
            <flux:label>{{ __('Publish') }}</flux:label>
            <flux:switch wire:model="published" />
        </flux:field>

        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit">
                {{ $post?->exists ? __('Update Post') : __('Create Post') }}
            </flux:button>
            <flux:button variant="ghost" :href="route('admin.blog.index')" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>
        </div>
    </form>
</div>
