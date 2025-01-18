<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationPhoto;
use App\Models\DestinationVideo;
use Illuminate\Http\Request;

class AdminDestinationController extends Controller
{
    //
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.destination.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destination.create');
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:destinations',
            'slug' => 'required|alpha_dash|unique:destinations',
            'description' => 'required',
            'featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
        $request->featured_photo->move(public_path('uploads'), $final_name);
        $destination = new Destination();
        $destination->featured_photo = $final_name;
        $this->extracted($request, $destination);
        return redirect()->route('admin_destination_index')->with('success', 'Destination Added Successfully');

    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destination.edit', compact('destination'));
    }

    public function edit_submit(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:destinations,name,' . $id,
            'slug' => 'required|alpha_dash|unique:destinations,slug,' . $id,
            'description' => 'required',
        ]);
        $destination = Destination::findOrFail($id);
        if ($request->featured_photo) {
            $request->validate([
                'featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($destination->featured_photo) {
                unlink(public_path('uploads/') . $destination->featured_photo);
            }
            $final_name = 'destination_featured_' . time() . '.' . $request->featured_photo->extension();
            $request->featured_photo->move(public_path('uploads'), $final_name);
            $destination->featured_photo = $final_name;
        }
        $this->extracted($request, $destination);
        return redirect()->route('admin_destination_index')->with('success', 'Destination Updated Successfully');

    }

    public function delete($id)
    {
        $total = DestinationPhoto:: where('destination_id', $id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'First Delete All Photos of This Destination');
        }
        $total1 = DestinationVideo:: where('destination_id', $id)->count();
        if ($total1 > 0) {
            return redirect()->back()->with('error', 'First Delete All Videos of This Destination');
        }
        $destination = Destination::findOrFail($id);
        unlink(public_path('uploads/') . $destination->featured_photo);
        $destination->delete();
        return redirect()->route('admin_destination_index')->with('success', 'Destination Deleted Successfully');
    }


    public function destination_photos($id)
    {
        $destination = Destination::where('id', $id)->first();
        $destination_photos = DestinationPhoto::where('destination_id', $id)->get();
        return view('admin.destination.photos', compact('destination', 'destination_photos'));

    }

    public function destination_photo_submit(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'destination_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);
        $obj = new DestinationPhoto();
        $obj->destination_id = $id;
        $obj->photo = $final_name;
        $obj->save();
        return redirect()->back()->with('success', 'Destination Photo Added Successfully');

    }

    public function destination_photo_delete($id)
    {
        $destination_photo = DestinationPhoto::findOrFail($id);
        unlink(public_path('uploads/') . $destination_photo->photo);
        $destination_photo->delete();
        return redirect()->back()->with('success', 'Photo Deleted Successfully');
    }

    public function destination_videos($id)
    {
        $destination = Destination::where('id', $id)->first();
        $destination_videos = DestinationVideo::where('destination_id', $id)->get();
        return view('admin.destination.videos', compact('destination', 'destination_videos'));

    }

    public function destination_video_submit(Request $request, $id)
    {
        $request->validate([
            'video' => 'required',
        ]);

        $obj = new DestinationVideo();
        $obj->destination_id = $id;
        $obj->video = $request->input('video');
        $obj->save();
        return redirect()->back()->with('success', 'Destination Video Added Successfully');

    }

    public function destination_video_delete($id)
    {
        $destination_video = DestinationVideo::findOrFail($id);
          $destination_video->delete();
        return redirect()->back()->with('success', 'Video Deleted Successfully');
    }
    /**
     * @param Request $request
     * @param $destination
     * @return void
     */
    public function extracted(Request $request, $destination): void
    {
        $destination->name = $request->input('name');
        $destination->slug = $request->input('slug');
        $destination->description = $request->input('description');
        $destination->country = $request->input('country');
        $destination->language = $request->input('language');
        $destination->currency = $request->input('currency');
        $destination->area = $request->input('area');
        $destination->timezone = $request->input('timezone');
        $destination->visa_requirement = $request->input('visa_requirement');
        $destination->activity = $request->input('activity');
        $destination->best_time = $request->input('best_time');
        $destination->health_safety = $request->input('health_safety');
        $destination->map = $request->input('map');
        $destination->view_count = 1;
        $destination->save();
    }
}
