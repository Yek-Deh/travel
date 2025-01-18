<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class AdminFeatureController extends Controller
{
    //
    public function index(){
        $features = Feature::all();
        return view('admin.feature.index', compact('features'));
    }
    public function create(){
        return view('admin.feature.create');
    }
    public function create_submit(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'heading' => 'required',
            'description' => 'required',
        ]);

        $feature = new Feature();

        $feature->heading = $request->input('heading');
        $feature->description = $request->input('description');
        $feature->icon = $request->input('icon');
        $feature->save();

        return redirect()->route('admin_feature_index')->with('success', 'Feature Added Successfully');

    }
    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.feature.edit', compact('feature'));
    }
    public function edit_submit(Request $request,$id){
        $request->validate([
            'icon' => 'required',
            'heading' => 'required',
            'description' => 'required',
        ]);
        $feature =  Feature::findOrFail($id);
        $feature->heading = $request->input('heading');
        $feature->description = $request->input('description');
        $feature->icon = $request->input('icon');
        $feature->save();
        return redirect()->route('admin_feature_index')->with('success', 'Feature Updated Successfully');

    }
    public function delete($id){
        $feature = Feature::findOrFail($id);
        $feature->delete();
        return redirect()->route('admin_feature_index')->with('success', 'Feature Deleted Successfully');
    }
}
