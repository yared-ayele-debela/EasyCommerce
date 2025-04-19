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
    public function index(Request $request){

        $blogs=Blogs::get();
        $fiveMonthsAgo = now()->subMonths(5);

        $blogCounts = Blogs::select(DB::raw('COUNT(*) as post_count, YEAR(created_at) as year, MONTH(created_at) as month'))
            ->where('created_at', '>=', $fiveMonthsAgo)
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $blog_category=BlogCategory::all()->where('status',1);
        $latestFiveBlogs = Blogs::latest()->take(5)->get();

        $blogsQuery = Blogs::where('status', 1);

        if ($request->has('search') && $request->input('search') !== '') {
            $searchTerm = $request->input('search');
            $blogsQuery->where('title', 'like', '%' . $searchTerm . '%');
        }

        return view('Ecommerce.blogs.index',compact('latestFiveBlogs','blogCounts','blog_category','blogs'));
    }

    public function details($id){

        $id=decrypt($id);
        $blog_comment = BlogComment::where('blog_id', $id)
        ->where('status', 1)
        ->simplePaginate(4);
        $count_blog_comment=$blog_comment->count();

        $blogs=Blogs::FindorFail($id)->first();
        if($blogs){
            return view('Ecommerce.blogs.detail',compact('count_blog_comment','blogs','blog_comment'));
        }else{
            return redirect()->back()->with('error','Blogs not found');
        }
    }

    public function store(Request $request){

            $blog = new BlogComment();
            $blog->comment = $request->input('comment');
            $blog->fullname=$request->input('fullname');
            $blog->email=$request->input('email');
            $blog->blog_id=$request->input('id');
            $blog->save();


            return redirect()->back()->with('success','Comment added successfully');
    }
}
