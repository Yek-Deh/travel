<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Destination;
use App\Models\Package;
use App\Models\PackageAmenity;
use App\Models\PackageFaq;
use App\Models\PackageItinerary;
use App\Models\PackagePhoto;
use App\Models\PackageVideo;
use App\Models\Tour;
use Illuminate\Http\Request;

class AdminPackageController extends Controller
{
    //
    public function index()
    {
        $packages = Package::all();
        return view('admin.package.index', compact('packages'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.package.create', compact('destinations'));
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:packages',
            'slug' => 'required|alpha_dash|unique:packages',
            'description' => 'required',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'package_featured_' . time() . '.' . $request->featured_photo->extension();
        $request->featured_photo->move(public_path('uploads'), $final_name);

        $final_name1 = 'package_banner_' . time() . '.' . $request->banner->extension();
        $request->banner->move(public_path('uploads'), $final_name1);

        $package = new Package();
        $package->featured_photo = $final_name;
        $package->banner = $final_name1;
        $this->extracted($request, $package);
        return redirect()->route('admin_package_index')->with('success', 'Package Added Successfully');

    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.package.edit', compact('package', 'destinations'));
    }

    public function edit_submit(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:packages,name,' . $id,
            'slug' => 'required|alpha_dash|unique:packages,slug,' . $id,
            'description' => 'required',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
        ]);
        $package = Package::findOrFail($id);
        if ($request->featured_photo) {
            $request->validate([
                'featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($package->featured_photo) {
                unlink(public_path('uploads/') . $package->featured_photo);
            }
            $final_name = 'package_featured_' . time() . '.' . $request->featured_photo->extension();
            $request->featured_photo->move(public_path('uploads'), $final_name);
            $package->featured_photo = $final_name;
        }
        if ($request->banner) {
            $request->validate([
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($package->banner) {
                unlink(public_path('uploads/') . $package->banner);
            }
            $final_name1 = 'package_banner_' . time() . '.' . $request->banner->extension();
            $request->banner->move(public_path('uploads'), $final_name1);
            $package->banner = $final_name1;
        }
        $this->extracted($request, $package);
        return redirect()->route('admin_package_index')->with('success', 'Package Updated Successfully');

    }

    public function delete($id)
    {
        $total = PackagePhoto:: where('package_id', $id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'First Delete All Photos of This Package');
        }
        $total1 = PackageVideo:: where('package_id', $id)->count();
        if ($total1 > 0) {
            return redirect()->back()->with('error', 'First Delete All Videos of This Package');
        }

        $total2 = PackageAmenity:: where('package_id', $id)->count();
        if ($total2 > 0) {
            return redirect()->back()->with('error', 'First Delete All Amenities of This Package');
        }
        $total3 = PackageFaq:: where('package_id', $id)->count();
        if ($total3 > 0) {
            return redirect()->back()->with('error', 'First Delete All FAQs of This Package');
        }
        $total4 = PackageItinerary:: where('package_id', $id)->count();
        if ($total4 > 0) {
            return redirect()->back()->with('error', 'First Delete All Itineraries of This Package');
        }
        $total5 = Tour:: where('package_id', $id)->count();
        if ($total5 > 0) {
            return redirect()->back()->with('error', 'First Delete All Tours of This Package');
        }

        $package = Package::findOrFail($id);
        unlink(public_path('uploads/') . $package->featured_photo);
        unlink(public_path('uploads/') . $package->banner);
        $package->delete();
        return redirect()->route('admin_package_index')->with('success', 'Package Deleted Successfully');
    }

    public function extracted(Request $request, $package): void
    {
        $package->name = $request->input('name');
        $package->slug = $request->input('slug');
        $package->price = $request->input('price');
        $package->old_price = $request->input('old_price');
        $package->destination_id = $request->input('destination_id');
        $package->description = $request->input('description');
        $package->map = $request->input('map');
        $package->total_rating = 0;
        $package->total_score = 0;

        $package->save();
    }

    public function package_amenities($id)
    {
        $package = Package::where('id', $id)->first();
        $package_amenities_include = PackageAmenity::with('amenity')->where('package_id', $id)->where('type','Include')->get();
        $package_amenities_exclude = PackageAmenity::with('amenity')->where('package_id', $id)->where('type','Exclude')->get();
        $amenities = Amenity::latest()->get();
        return view('admin.package.amenities', compact('package', 'package_amenities_include', 'amenities', 'package_amenities_exclude'));

    }

    public function package_amenity_submit(Request $request, $id)
    {
        $total = PackageAmenity::where('package_id', $id)->where('amenity_id', $request->amenity_id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'This Item is Already Inserted');
        }

        $obj = new PackageAmenity();
        $obj->package_id = $id;
        $obj->amenity_id = $request->input('amenity_id');
        $obj->type = $request->input('type');
        $obj->save();
        return redirect()->back()->with('success', 'Item Added Successfully');

    }

    public function package_amenity_delete($id)
    {
        $obj = PackageAmenity::findOrFail($id);
        $obj->delete();
        return redirect()->back()->with('success', 'Item Deleted Successfully');
    }

    public function package_itineraries($id)
    {
        $package = Package::where('id', $id)->first();
        $package_itineraries = PackageItinerary::where('package_id', $id)->get();
        return view('admin.package.itineraries', compact('package', 'package_itineraries'));

    }

    public function package_itinerary_submit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $obj = new PackageItinerary();
        $obj->package_id = $id;
        $obj->name = $request->input('name');
        $obj->description = $request->input('description');
        $obj->save();
        return redirect()->back()->with('success', 'Item Added Successfully');

    }

    public function package_itinerary_delete($id)
    {
        $obj = PackageItinerary::findOrFail($id);
        $obj->delete();
        return redirect()->back()->with('success', 'Item Deleted Successfully');
    }

    public function package_photos($id)
    {
        $package = Package::where('id', $id)->first();
        $package_photos = PackagePhoto::where('package_id', $id)->get();
        return view('admin.package.photos', compact('package', 'package_photos'));

    }

    public function package_photo_submit(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'package_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);
        $obj = new PackagePhoto();
        $obj->package_id = $id;
        $obj->photo = $final_name;
        $obj->save();
        return redirect()->back()->with('success', 'Photo Added Successfully');

    }

    public function package_photo_delete($id)
    {
        $package_photo = PackagePhoto::findOrFail($id);
        unlink(public_path('uploads/') . $package_photo->photo);
        $package_photo->delete();
        return redirect()->back()->with('success', 'Photo Deleted Successfully');
    }

    public function package_videos($id)
    {
        $package = Package::where('id', $id)->first();
        $package_videos = PackageVideo::where('package_id', $id)->get();
        return view('admin.package.videos', compact('package', 'package_videos'));
    }

    public function package_video_submit(Request $request, $id)
    {
        $request->validate([
            'video' => 'required',
        ]);
        $obj = new PackageVideo();
        $obj->package_id = $id;
        $obj->video = $request->input('video');
        $obj->save();
        return redirect()->back()->with('success', 'Video Added Successfully');

    }

    public function package_video_delete($id)
    {
        $package_video = PackageVideo::findOrFail($id);
        $package_video->delete();
        return redirect()->back()->with('success', 'Video Deleted Successfully');
    }

    public function package_faqs($id)
    {
        $package = Package::where('id', $id)->first();
        $package_faqs = PackageFaq::where('package_id', $id)->get();
        return view('admin.package.faqs', compact('package', 'package_faqs'));
    }

    public function package_faq_submit(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        $obj = new PackageFaq();
        $obj->package_id = $id;
        $obj->question = $request->input('question');
        $obj->answer = $request->input('answer');
        $obj->save();
        return redirect()->back()->with('success', 'FAQ Added Successfully');

    }

    public function package_faq_delete($id)
    {
        $package_faq = PackageFaq::findOrFail($id);
        $package_faq->delete();
        return redirect()->back()->with('success', 'FAQ Deleted Successfully');
    }
}
