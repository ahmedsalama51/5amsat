<?php

namespace App\Http\Controllers;

// use DB;
use App\Post;
use App\User;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class PagesControllers extends Controller
{
    var $posts;
    var $tags;
    var $categories; 
    public function __construct()
    {
    	// recent 3 posts
		$this->posts = Post::where('is_published','1')->get()->sortByDesc('id')->take(3);
		// top 3 viewd post
		$this->topviewd = Post::where('is_published','1')->get()->sortByDesc('views_num')->take(3);
		// $this->tags = \DB::table('tags')->get();
		$this->tags = Tag::all()->take(3)->reverse();
		// $this->categories = \DB::table('categories')->get();
		$this->categories = Category::all()->take(3)->reverse();
    }
	
	public function index(){

		// return view ('index',compact('posts','tags','categories'));
		$sortedPosts = Post::all()->where('is_published','1')->sortByDesc('id');
		$slideposts = $sortedPosts->take(6);
		$recent2posts = $sortedPosts->slice(6,2)->reverse();
		$recent4posts = $sortedPosts->slice(8,2)->reverse();
		// return $recent2posts;
		return view('index',compact('slideposts','recent2posts','recent4posts'),['posts'=> $this->posts,'categories'=> $this->categories,'tags'=> $this->tags,'topviewd'=>$this->topviewd]);
	}

	public function about(){
		$users = User::all();
		return view ('pages.about',compact('users'),['posts'=> $this->posts,'categories'=> $this->categories,'tags'=> $this->tags,'topviewd'=>$this->topviewd]);
	}


}
