<?php

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $body = '';
    public bool $published = false;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $newFeaturedImage = null;
    public bool $removeFeaturedImage = false;

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

    public function removeFeaturedImage(): void
    {
        $this->removeFeaturedImage = true;
        $this->newFeaturedImage = null;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $this->post?->id],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'published' => ['boolean'],
            'newFeaturedImage' => ['nullable', 'image', 'max:5120'],
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?: null,
            'body' => $validated['body'],
        ];

        if ($this->newFeaturedImage) {
            if ($this->post?->featured_image) {
                Storage::disk('public')->delete($this->post->featured_image);
            }
            $data['featured_image'] = $this->newFeaturedImage->store('featured-images', 'public');
        } elseif ($this->removeFeaturedImage && $this->post?->featured_image) {
            Storage::disk('public')->delete($this->post->featured_image);
            $data['featured_image'] = null;
        }

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

        {{-- Featured image --}}
        <flux:field>
            <flux:label>{{ __('Featured Image') }}</flux:label>
            @if ($post?->featured_image && ! $removeFeaturedImage)
                <div class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 mt-2 max-w-sm">
                    <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="" class="w-full aspect-video object-cover" />
                    <button type="button" wire:click="removeFeaturedImage" class="absolute top-2 right-2 size-6 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs">
                        &times;
                    </button>
                </div>
            @else
                <input type="file" wire:model="newFeaturedImage" accept="image/*" class="mt-2 text-sm text-zinc-600 dark:text-zinc-400" />
                @if ($newFeaturedImage)
                    <div class="rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 mt-2 max-w-sm">
                        <img src="{{ $newFeaturedImage->temporaryUrl() }}" alt="" class="w-full aspect-video object-cover" />
                    </div>
                @endif
            @endif
            <flux:error name="newFeaturedImage" />
        </flux:field>

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
