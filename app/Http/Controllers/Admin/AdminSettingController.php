<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    //
    public function index()
    {
        $setting = Setting::where('id', 1)->first();
        return view('admin.setting.index', compact('setting'));

    }


    public function update(Request $request)
    {
        $obj = Setting::where('id', 1)->first();
        if ($request->logo) {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($obj->logo) {
                unlink(public_path('uploads/') . $obj->logo);
            }
            $final_name = 'logo_' . time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('uploads'), $final_name);

            $obj->logo = $final_name;
        }
        if ($request->favicon) {
            $request->validate([
                'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($obj->favicon) {
                unlink(public_path('uploads/') . $obj->favicon);
            }
            $final_name = 'favicon_' . time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('uploads'), $final_name);

            $obj->favicon = $final_name;
        }
        $obj->top_bar_phone = $request->top_bar_phone;
        $obj->top_bar_email = $request->top_bar_email;
        $obj->footer_address = $request->footer_address;
        $obj->footer_phone = $request->footer_phone;
        $obj->footer_email = $request->footer_email;
        $obj->facebook = $request->facebook;
        $obj->twitter = $request->twitter;
        $obj->youtube = $request->youtube;
        $obj->linkedin = $request->linkedin;
        $obj->instagram = $request->instagram;
        $obj->copyright = $request->copyright;
        $obj->save();
        return redirect()->back()->with('success', 'Setting is Updated Successfully');
    }
}
