<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Tour;
use Illuminate\Http\Request;

class AdminTourController extends Controller
{
    //
    public function index()
    {
        $tours = Tour::with('package')->get();
        return view('admin.tour.index', compact('tours'));
    }

    public function create()
    {
        $packages = Package::orderBy('name', 'asc')->get();
        return view('admin.tour.create', compact('packages'));
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'tour_start_date' => 'required|date',
            'tour_end_date' => 'required|date',
            'booking_end_date' => 'required|date',
            'total_seat' => 'required',
        ]);

        $tour = new tour();
        $this->extracted($request, $tour);

        return redirect()->route('admin_tour_index')->with('success', 'tour Added Successfully');

    }

    public function edit($id)
    {
        $tour = tour::findOrFail($id);
        $packages = Package::orderBy('name', 'asc')->get();
        return view('admin.tour.edit', compact('tour', 'packages'));
    }

    public function edit_submit(Request $request, $id)
    {
        $request->validate([
            'tour_start_date' => 'required|date',
            'tour_end_date' => 'required|date',
            'booking_end_date' => 'required|date',
            'total_seat' => 'required',
        ]);
        $tour = tour::findOrFail($id);
        $this->extracted($request, $tour);
        return redirect()->route('admin_tour_index')->with('success', 'tour Updated Successfully');

    }

    public function delete($id)
    {
        $total = Booking::where('tour_id', $id)->count();
        if ($total > 0) {
            return redirect()->back()->with('error', 'This Tour has Bookings. So, it can not be deleted');
        }


        $tour = tour::findOrFail($id);
        $tour->delete();
        return redirect()->route('admin_tour_index')->with('success', 'tour Deleted Successfully');
    }

    public function tour_booking($tour_id, $package_id)
    {
        $all_data = Booking::with('user')->where('tour_id', $tour_id)->where('package_id', $package_id)->get();

        return view('admin.tour.booking', compact('all_data'));
    }

    public function tour_booking_delete($id)
    {
        $obj = Booking::where('id', $id)->first();
        $obj->delete();
        return redirect()->back()->with('success', 'Booking is Deleted Successfully');
    }

    public function tour_invoice($invoice_no)
    {
        $booking = Booking::with(['user', 'tour', 'package'])->where('invoice_no', $invoice_no)->first();
        return view('admin.tour.invoice', compact('booking'));

    }
    public function tour_booking_approve($id)
    {
        Booking::where('id', $id)->update(['payment_status' => 'Completed']);
        return redirect()->back()->with('success', 'Booking Approved Successfully');

    }
    /**
     * @param Request $request
     * @param $obj
     * @return void
     */
    public function extracted(Request $request, $obj): void
    {
        $obj->package_id = $request->package_id;
        $obj->tour_start_date = $request->tour_start_date;
        $obj->tour_end_date = $request->tour_end_date;
        $obj->booking_end_date = $request->booking_end_date;
        $obj->total_seat = $request->total_seat;
        $obj->save();
    }
}
