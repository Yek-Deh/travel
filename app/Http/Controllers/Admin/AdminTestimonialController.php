<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    //
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'comment' => 'required',
            'designation' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'testimonial_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);


        $testimonial = new Testimonial();
        $testimonial->photo = $final_name;
        $testimonial->name = $request->input('name');
        $testimonial->designation = $request->input('designation');
        $testimonial->comment = $request->input('comment');
        $testimonial->save();

        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial Added Successfully');

    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function edit_submit(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'comment' => 'required',
            'designation' => 'required',
        ]);
        $testimonial = Testimonial::findOrFail($id);
        if ($request->photo) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($testimonial->photo) {
                unlink(public_path('uploads/') . $testimonial->photo);
            }
            $final_name = 'testimonial_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $testimonial->photo = $final_name;
        }
        $testimonial->name = $request->input('name');
        $testimonial->designation = $request->input('designation');
        $testimonial->comment = $request->input('comment');
        $testimonial->save();
        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial Updated Successfully');

    }

    public function delete($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        unlink(public_path('uploads/') . $testimonial->photo);
        $testimonial->delete();
        return redirect()->route('admin_testimonial_index')->with('success', 'Testimonial Deleted Successfully');
    }
}
