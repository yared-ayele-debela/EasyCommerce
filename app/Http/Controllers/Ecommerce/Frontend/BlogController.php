<?php

namespace App\Http\Controllers\Ecommerce\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
{
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

    $blogs = $blogsQuery->latest()->paginate(6); // paginate if needed

    if ($request->ajax()) {
        return view('Ecommerce.blogs.partials.blog-list', compact('blogs'))->render();
    }

    $fiveMonthsAgo = now()->subMonths(5);

    $blogCounts = Blogs::select(DB::raw('COUNT(*) as post_count, YEAR(created_at) as year, MONTH(created_at) as month'))
        ->where('created_at', '>=', $fiveMonthsAgo)
        ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
        ->orderBy('year', 'desc')->orderBy('month', 'desc')
        ->get();

    $blog_category = BlogCategory::where('status', 1)->get();
    $latestFiveBlogs = Blogs::latest()->take(5)->get();

    return view('Ecommerce.blogs.index', compact('blogs', 'latestFiveBlogs', 'blogCounts', 'blog_category'));
}


    public function details($id)
    {

        $id = decrypt($id);
        $blog_comment = BlogComment::where('blog_id', $id)
            ->where('status', 1)
            ->simplePaginate(4);
        $count_blog_comment = $blog_comment->count();

        $blogs = Blogs::FindorFail($id)->first();
        if ($blogs) {
        return view('Ecommerce.blogs.detail', compact('blog_comment',  'blogs','count_blog_comment'));


    } else {
            return redirect()->back()->with('error', 'Blogs not found');
        }
    }

    public function store(Request $request)
    {

        $blog = new BlogComment();
        $blog->comment = $request->input('comment');
        $blog->fullname = $request->input('fullname');
        $blog->email = $request->input('email');
        $blog->blog_id = $request->input('id');
        $blog->save();


        return redirect()->back()->with('success', 'Comment added successfully');
    }
}
