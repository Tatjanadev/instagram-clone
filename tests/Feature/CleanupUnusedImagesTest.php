<?php

use App\Jobs\CleanupUnusedImages;
use App\Models\Post;
use App\Models\PostImage;
use App\Services\PostImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('cleanup job deletes unused images but keeps images referenced in the database', function () {
    Storage::fake('public');

    $disk = Storage::disk('public');

    $disk->put('posts/unused.jpg', 'fake image content');
    $disk->put('posts/used.jpg', 'fake image content');

    $post = Post::factory()->create();

    PostImage::create([
        'post_id' => $post->id,
        'image_path' => 'posts/used.jpg',
    ]);

    // Make the unused file appear two days old.
    $oldTimestamp = now()->subDays(2)->timestamp;

    touch($disk->path('posts/unused.jpg'), $oldTimestamp);

    $job = new CleanupUnusedImages;

    $job->handle(app(PostImageService::class));

    $disk->assertMissing('posts/unused.jpg');

    $disk->assertExists('posts/used.jpg');
});

test('cleanup job removes unused thumbnails but keeps referenced thumbnails', function () {
    Storage::fake('public');

    $disk = Storage::disk('public');

    $disk->put('posts/photo.jpg', 'original');
    $disk->put('posts/thumbnails/1.webp', 'thumbnail');

    $disk->put('posts/thumbnails/999.webp', 'unused thumbnail');

    $post = Post::factory()->create();

    PostImage::create([
        'post_id' => $post->id,
        'image_path' => 'posts/photo.jpg',
        'thumbnail_path' => 'posts/thumbnails/1.webp',
    ]);

    // Make all files older than 24 hours.
    $oldTimestamp = now()->subDays(2)->timestamp;

    foreach ($disk->allFiles('posts') as $file) {
        touch($disk->path($file), $oldTimestamp);
    }

    // Execute the cleanup Job.
    $job = new CleanupUnusedImages;
    $job->handle(app(PostImageService::class));

    // Referenced files must remain.
    $disk->assertExists('posts/photo.jpg');
    $disk->assertExists('posts/thumbnails/1.webp');

    // Unused thumbnail must be deleted.
    $disk->assertMissing('posts/thumbnails/999.webp');
});
