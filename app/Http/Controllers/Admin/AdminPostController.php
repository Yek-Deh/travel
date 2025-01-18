<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::with('blog_category')->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.post.create', compact('categories'));
    }

    public function create_submit(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'slug' => 'required|alpha_dash|unique:posts',
            'description' => 'required',
            'short_description' => 'required',
            'blog_category_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'post_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);


        $post = new Post();
        $post->photo = $final_name;
        $post->blog_category_id = $request->input('blog_category_id');
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->short_description = $request->input('short_description');
        $post->slug = $request->input('slug');
        $post->save();

        return redirect()->route('admin_post_index')->with('success', 'post Added Successfully');

    }

    public function edit($id)
    {
        $categories = BlogCategory::all();
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post', 'categories'));
    }

    public function edit_submit(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'slug' => 'required|alpha_dash|unique:posts,slug,' . $id,
            'description' => 'required',
            'short_description' => 'required',
            'blog_category_id' => 'required',
        ]);
        $post = Post::findOrFail($id);
        if ($request->photo) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($post->photo) {
                unlink(public_path('uploads/') . $post->photo);
            }
            $final_name = 'post_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $post->photo = $final_name;
        }
        $post->blog_category_id = $request->input('blog_category_id');
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->short_description = $request->input('short_description');
        $post->slug = $request->input('slug');
        $post->save();
        return redirect()->route('admin_post_index')->with('success', 'Post Updated Successfully');

    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        unlink(public_path('uploads/') . $post->photo);
        $post->delete();
        return redirect()->route('admin_post_index')->with('success', 'Post Deleted Successfully');
    }

}
