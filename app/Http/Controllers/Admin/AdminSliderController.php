<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    //
    public function index(){
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }
    public function create(){
        return view('admin.slider.create');
    }
    public function create_submit(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'text' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'slider_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);



        $slider = new Slider();
        $slider->photo = $final_name;
        $slider->heading = $request->input('heading');
        $slider->text = $request->input('text');
        $slider->button_text = $request->input('button_text');
        $slider->button_link = $request->input('button_link');
        $slider->save();

        return redirect()->route('admin_slider_index')->with('success', 'Slider Added Successfully');

    }
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }
    public function edit_submit(Request $request,$id){
        $request->validate([
            'heading' => 'required',
            'text' => 'required',
        ]);
        $slider =  Slider::findOrFail($id);
        if ($request->photo) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($slider->photo) {
                unlink(public_path('uploads/') . $slider->photo);
            }
            $final_name = 'slider_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $slider->photo = $final_name;
        }
        $slider->heading = $request->input('heading');
        $slider->text = $request->input('text');
        $slider->button_text = $request->input('button_text');
        $slider->button_link = $request->input('button_link');
        $slider->save();
        return redirect()->route('admin_slider_index')->with('success', 'Slider Updated Successfully');

    }
    public function delete($id){
        $slider = Slider::findOrFail($id);
        unlink(public_path('uploads/') . $slider->photo);
        $slider->delete();
        return redirect()->route('admin_slider_index')->with('success', 'Slider Deleted Successfully');
    }
}
