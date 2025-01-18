<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeItem;
use Illuminate\Http\Request;

class AdminWelcomeItemController extends Controller
{
    //
    public function index(){
        $welcome_item = WelcomeItem::where('id',1)->first();
        return view('admin.welcome.index', compact('welcome_item'));
    }
    public function update(Request $request){

        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'video' => 'required',
        ]);
        $obj =  WelcomeItem::where('id',1)->first();

        if ($request->photo) {
            $request->validate([
                'photo' => ['required','mimes:jpeg,jpg,png'],
            ]);
            if ($obj->photo) {
                unlink(public_path('uploads/') . $obj->photo);
            }
            $final_name = 'welcome_item_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $obj->photo = $final_name;
        }
        $obj->heading = $request->input('heading');
        $obj->description = $request->input('description');
        $obj->button_text = $request->input('button_text');
        $obj->button_link = $request->input('button_link');
        $obj->video = $request->input('video');
        $obj->status = $request->input('status');
        $obj->save();
        return redirect()->back()->with('success', 'Welcome Item Updated Successfully');
    }
}
