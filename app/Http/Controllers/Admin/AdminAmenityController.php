<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\PackageAmenity;
use Illuminate\Http\Request;

class AdminAmenityController extends Controller
{
    //
    public function index()
    {
        $amenities = Amenity::all();
        return view('admin.amenity.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenity.create');
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:amenities',
        ]);

        $amenity = new Amenity();

        $amenity->name = $request->input('name');
        $amenity->save();

        return redirect()->route('admin_amenity_index')->with('success', 'Amenity Added Successfully');

    }

    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('admin.amenity.edit', compact('amenity'));
    }

    public function edit_submit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:amenities,name,' . $id,
        ]);
        $amenity = Amenity::findOrFail($id);
        $amenity->name = $request->input('name');
        $amenity->save();
        return redirect()->route('admin_amenity_index')->with('success', 'Amenity Updated Successfully');

    }

    public function delete($id)
    {
        $total = PackageAmenity::where('amenity_id', $id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'Amenity is Assigned to Package(s), So it can not be deleted');
        }

        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return redirect()->route('admin_amenity_index')->with('success', 'Amenity Deleted Successfully');
    }
}
