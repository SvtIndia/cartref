<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Models\Category;

class BlogsController extends Controller
{
    //

    public function index()
    {
        $blogs = Post::where('status', 'PUBLISHED')->paginate(30);
        $categories = Category::where('status', 1)->get();

        return view('blogs')->with([
            'blogs' => $blogs,
            'categories' => $categories
        ]);
    }

    public function blog($slug)
    {
        
        $blog = Post::where('status', 'PUBLISHED')->where('slug', $slug)->first();

        $previous = Post::where('status', 'PUBLISHED')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();
        $next = Post::where('status', 'PUBLISHED')->where('id', '>', $blog->id)->orderBy('id')->first();
        
        if(empty($blog))
        {
            return abort(404);
        }

        return view('blog')->with([
            'blog' => $blog,
            'previous' => $previous,
            'next' => $next
        ]);
    }
}
