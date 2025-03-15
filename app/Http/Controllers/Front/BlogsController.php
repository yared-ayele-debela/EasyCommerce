<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CmsPage;

use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BlogsController extends Controller
{
    //
    public function index(Request $request){

        $appsettings=AppSetting::all()->toArray();
        $cms_pages=CmsPage::all()->toArray();


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

        // If a search term is provided in the request, filter blogs by title
        if ($request->has('search') && $request->input('search') !== '') {
            $searchTerm = $request->input('search');
            $blogsQuery->where('title', 'like', '%' . $searchTerm . '%');
        }



        return view('NewFrontEndPage.blogs.index',compact('latestFiveBlogs','blogCounts','blog_category','blogs','appsettings','cms_pages'));
    }

    public function details($id){
        $shareComponent = \Share::page(
            'https://www.positronx.io/create-autocomplete-search-in-laravel-with-typeahead-js/',
            'Your share text comes here',
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();

            $blog_comment = BlogComment::where('blog_id', $id)
            ->where('status', 1)
            ->simplePaginate(4);



        // dd($blog_comment);
        $count_blog_comment=$blog_comment->count();
        $appsettings=AppSetting::all()->toArray();
        $cms_pages=CmsPage::all()->toArray();
        $blogs=Blogs::FindorFail($id)->first();
        // dd($blogs);
        if($blogs){
            return view('NewFrontEndPage.blogs.detail',compact('shareComponent','count_blog_comment','blogs','appsettings','cms_pages','blog_comment'));
        }else{
            Alert::toast('Blogs not found','error');
            return redirect()->back();
        }
    }

    public function store(Request $request){
        // dd($request->all());
            $blog = new BlogComment();
            $blog->comment = $request->input('comment');
            $blog->fullname=$request->input('fullname');
            $blog->email=$request->input('email');
            $blog->blog_id=$request->input('id');
            $blog->save();

            Alert::toast('Your comment has been saved!','success');
            return redirect()->back();
    }
}
