<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminBlogCategoryController extends Controller
{
    //
    public function index(){
        $blog_categories = BlogCategory::all();
        return view('admin.blog_category.index', compact('blog_categories'));
    }
    public function create(){
        return view('admin.blog_category.create');
    }
    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|alpha_dash|unique:blog_categories',
        ]);

        $blog_category = new BlogCategory();

        $blog_category->name = $request->input('name');
        $blog_category->slug = $request->input('slug');
        $blog_category->save();

        return redirect()->route('admin_blog_category_index')->with('success', 'blog_category Added Successfully');

    }
    public function edit($id)
    {
        $blog_category = BlogCategory::findOrFail($id);
        return view('admin.blog_category.edit', compact('blog_category'));
    }
    public function edit_submit(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories,slug,'.$id,
        ]);
        $blog_category =  BlogCategory::findOrFail($id);
        $blog_category->name = $request->input('name');
        $blog_category->slug = $request->input('slug');
        $blog_category->save();
        return redirect()->route('admin_blog_category_index')->with('success', 'Blog Category Updated Successfully');

    }
    public function delete($id){
        $total = Post:: where('blog_category_id', $id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'This Blog Category is in use. So you can not delete it.');
        }
        $blog_category = BlogCategory::findOrFail($id);
        $blog_category->delete();
        return redirect()->route('admin_blog_category_index')->with('success', 'Blog Category Deleted Successfully');
    }
}
