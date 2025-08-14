<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    protected $cacheTime = 60 * 60; // cache time in seconds (1 hour)

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $category_id = $request->input('category_id', '');
        $archive = $request->input('archive', '');

        // Cache key for blogs list based on filters and page
        $page = $request->input('page', 1);
        $cacheKey = "blogs_page_{$page}_search_{$search}_category_{$category_id}_archive_{$archive}";

        $blogs = Cache::tags(['hotels'])->remember($cacheKey, $this->cacheTime, function () use ($request) {
            $blogsQuery = Blogs::where('status', 1);

            if ($request->has('search') && $request->input('search') !== '') {
                $blogsQuery->where('title', 'like', '%' . $request->input('search') . '%');
            }

            if ($request->has('category_id')) {
                $blogsQuery->where('category_id', $request->input('category_id'));
            }

            if ($request->has('archive')) {
                [$year, $month] = explode('-', $request->input('archive'));
                $blogsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
            }

            return $blogsQuery->latest()->paginate(6);
        });

        if ($request->ajax()) {
            return view('Ecommerce.blogs.partials.blog-list', compact('blogs'))->render();
        }

        $fiveMonthsAgo = now()->subMonths(5);

        $blogCounts = Cache::tags(['hotels'])->remember('blog_counts', $this->cacheTime, function () use ($fiveMonthsAgo) {
            return Blogs::select(DB::raw('COUNT(*) as post_count, YEAR(created_at) as year, MONTH(created_at) as month'))
                ->where('created_at', '>=', $fiveMonthsAgo)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        });

        $blog_category = Cache::tags(['hotels'])->remember('blog_categories', $this->cacheTime, function () {
            return BlogCategory::where('status', 1)->get();
        });

        $latestFiveBlogs = Cache::tags(['hotels'])->remember('latest_five_blogs', $this->cacheTime, function () {
            return Blogs::latest()->take(5)->get();
        });

        return view('Ecommerce.blogs.index', compact('blogs', 'latestFiveBlogs', 'blogCounts', 'blog_category'));
    }

    public function details($id)
    {
        $id = decrypt($id);

        $blog_comment = Cache::tags(['blogs'])->remember("blog_comments_{$id}_page_1", $this->cacheTime, function () use ($id) {
            return BlogComment::where('blog_id', $id)
                ->where('status', 1)
                ->simplePaginate(4);
        });

        $count_blog_comment = $blog_comment->count();

        $blogs = Cache::tags(['blogs'])->remember("blog_detail_{$id}", $this->cacheTime, function () use ($id) {
            return Blogs::findOrFail($id);
        });

        return view('Ecommerce.blogs.detail', compact('blog_comment', 'blogs', 'count_blog_comment'));
    }

    public function store(Request $request)
    {
        $blog = new BlogComment();
        $blog->comment = $request->input('comment');
        $blog->fullname = $request->input('fullname');
        $blog->email = $request->input('email');
        $blog->blog_id = $request->input('id');
        $blog->save();

        // Clear related caches after adding a new comment
        $blogId = $request->input('id');
        Cache::forget("blog_comments_{$blogId}_page_1");

        return redirect()->back()->with('success', 'Comment added successfully');
    }
}
