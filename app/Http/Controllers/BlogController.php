<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\PostService;

class BlogController extends Controller
{
    //
	public function index(Request $request)
	{
		$tag = $request->get('tag');
		$postService = new PostService($tag);
		$data = $postService->lists();
		$layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
		return view($layout, $data);
	}

	public function showPost($slug,Request $request)
	{
		$post = Post::with('tags')->where('slug', $slug)->firstOrFail();
		$tag = $request->get('tag');
		if ($tag) {
			$tag = Tag::where('tag', $tag)->firstOrFail();
		}
		return view($post->layout, compact('post', 'tag'));
	}
}
