<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{

	
	public function blogList(){

		$posts = Post::latest()->get();

		return view('dashboard.blog.index', compact('posts'));
	}

	/**
	 * Creates a blog.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function createBlog(){

		return view('dashboard.blog.create');
	}	


	/**
	 * Saves a blog.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function saveBlog(Request $request){
		
		$request->validate([
			'title' => ['required', 'string', 'max:255'],
			'post_body' => ['required', 'string'],
			'thumbnail' => ['required', 'image', 'mimes:jpg,png,jpeg'],
		]);

		$published = $request->status != 'draft' ? 1 : 0;
		$published_at = $request->status != 'draft' ? now() : null;

		$post = Post::create([
			'title' => $request->title,
			'slug' => Str::slug($request->title),
			'post_body' => $request->post_body,
			'status' => $request->status,
			'published' => $published,
			'published_at' => $published_at,
		]);

		$this->uploadThumbnail($post);
		
		\Session::flash('success', 'Blog created successfully');

		return redirect()->route('blog-list');	
	}	

	/**
	 * edit Blog
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editBlog($slug){

		$post = Post::where('slug', $slug)->firstOrfail();

		return view('dashboard.blog.edit',compact('post'));
	}


	/**
	 * updates Blog
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateBlog(Request $request, $slug){
		
		$request->validate([
			'title' => ['required', 'string', 'max:255'],
			'post_body' => ['required', 'string'],
			'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);

		$post = Post::where('slug', $slug)->firstOrfail();


		$published = $request->status != 'draft' ? 1 : 0;
		$published_at = $request->status != 'draft' ? now() : null;


		$post->update([
			'title' => $request->title,
			'slug' => Str::slug($request->title),
			'post_body' => $request->post_body,
			'status' => $request->status,
			'published' => $published,
			'published_at' => $published_at,
		]);

		$this->uploadThumbnail($post);

		\Session::flash('success', 'Blog updated successfully');

		return redirect()->route('blog-list');
	}


	/**
	 * Uploads a thumbnail.
	 *
	 * @param      <type>  $blog  The blog
	 */
	public function uploadThumbnail($blog){

		if (request()->has('thumbnail')) {

			if (is_file(get_blog_thumbnail($blog->thumbnail))) {
				unlink(get_blog_thumbnail($blog->thumbnail));
			}

			$file 	= request()->file('thumbnail');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= Str::slug($blog->slug).'.'.$ext;
			$save  	= $file->storeAs('public/blog/', $name);

			$blog->update([
				'thumbnail' => $name,
			]);
		}

	}


	/**
	 * blog actions
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function actions(Request $request){

		$post = Post::where('slug', $request->slug);

		switch ($request) {
			case $request->status == 'publish':
			$post->update([
				'published' => 1,
				'published_at' => now(),
			]);
			break;
			
			case $request->status == 'unpublish':
			$post->update([
				'published' => 0,
				'published_at' => null,
			]);
			break;
			
			default:
			$post->delete();
			break;
		}

		return response()->json(['success' => 'Blog is '.$request->status]);

	}
}
