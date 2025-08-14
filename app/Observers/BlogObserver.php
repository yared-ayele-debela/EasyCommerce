<?php

namespace App\Observers;

use App\Models\Blogs;
use Illuminate\Support\Facades\Cache;

class BlogObserver
{
    /**
     * Handle the Blogs "created" event.
     */
     public function created(Blogs $blog)
    {
        $this->clearBlogCache($blog);
    }

    /**
     * Handle events after a blog is updated.
     */
    public function updated(Blogs $blog)
    {
        $this->clearBlogCache($blog);
    }

    /**
     * Handle events after a blog is deleted.
     */
    public function deleted(Blogs $blog)
    {
        $this->clearBlogCache($blog);
    }

    /**
     * Clear related blog caches
     */
    protected function clearBlogCache(Blogs $blog)
    {
        // Clear detail cache
        Cache::forget("blog_detail_{$blog->id}");

        // Clear comment cache for the blog
        Cache::forget("blog_comments_{$blog->id}_page_1");

        // Clear list-related caches (you may adjust keys if using filters)
        Cache::forget('latest_five_blogs');
        Cache::forget('blog_counts');
        Cache::forget('blog_categories');

        // Optionally, you can clear all filtered blog list caches dynamically
        // Example: use Cache::tags('blogs')->flush() if using cache tagging
    }
}
