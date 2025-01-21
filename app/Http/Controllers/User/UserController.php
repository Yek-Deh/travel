<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Message;
use App\Models\MessageComment;
use App\Models\Review;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    //
    public function dashboard()
    {
        $total_complete_orders = Booking::where('user_id', Auth::guard('web')->id())->where('payment_status', 'Completed')->count();
        $total_pending_orders = Booking::where('user_id', Auth::guard('web')->id())->where('payment_status', 'Pending')->count();
        return view('user.dashboard', compact('total_complete_orders', 'total_pending_orders'));
    }

    public function booking()
    {
        $all_data = Booking::with(['tour', 'package'])->where('user_id', Auth::guard('web')->id())->get();
        return view('user.booking', compact('all_data'));

    }

    public function invoice($invoice_no)
    {
        $admin_data = Admin::where('id', 1)->first();
        $booking = Booking::with(['tour', 'package'])->where('invoice_no', $invoice_no)->first();
        return view('user.invoice', compact('invoice_no', 'booking', 'admin_data'));

    }

    public function wishlist()
    {
        $wishlist = Wishlist::with('package')->where('user_id', Auth::guard('web')->id())->get();
        return view('user.wishlist', compact('wishlist'));
    }

    public function wishlist_delete($id)
    {
        $obj = Wishlist::where('id', $id)->first();
        $obj->delete();
        return redirect()->back()->with('success', 'Wishlist item is deleted successfully! ');
    }

    public function message()
    {
        $message_check = Message::where('user_id', Auth::guard('web')->id())->first();
        $message = Message::where('user_id', Auth::guard('web')->id())->first();


        if ($message) {
            $message_comments = MessageComment::where('message_id', $message->id)->orderBy('id', 'desc')
                ->get();
        } else {
            $message_comments = [];
        }
        return view('user.message', compact('message_check', 'message_comments'));

    }

    public function message_start()
    {
        $message_check = Message::where('user_id', Auth::guard('web')->id())->count();
        if ($message_check > 0) {
            return redirect()->back()->with('error', 'You have already started a conversation!');
        }
        $obj = new Message;
        $obj->user_id = Auth::guard('web')->id();
        $obj->save();
        return redirect()->back();
    }

    public function message_submit(Request $request)
    {
        $request->validate([
            'comment' => 'required',
        ]);
        $message = Message::where('user_id', Auth::guard('web')->id())->first();
        $obj = new MessageComment;
        $obj->message_id = $message->id;
        $obj->sender_id = Auth:: guard('web')->id();
        $obj->type = 'User';
        $obj->comment = $request->comment;
        $obj->save();


        $message_link = route('admin_message_detail', $message->id);
        $subject = 'New User Message';
        $message = 'Please click on the following link to see the new message from the user: <a href="' . $message_link . '">Click Here</a>';
        $admin_data = Admin::where('id', 1)->first();

        Mail::to($admin_data->email)->send(new WebsiteMail($subject, $message));

        return redirect()->back()->with('success', 'Message is sent successfully!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile');
    }

    public function profile_submit(Request $request)
    {
        $user = User::where('id', Auth::guard('web')->id())->first();
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['required'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'zip' => ['required'],
        ]);

        if ($request->photo) {
            $request->validate([
                'photo' => ['mimes:jpeg,jpg,png'],
            ]);
            if ($user->photo) {
                unlink(public_path('uploads/') . $user->photo);
            }
            $final_name = 'user_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $user->photo = $final_name;
        }
        if ($request->password) {
            $request->validate([
                'password' => ['required'],
                'retype_password' => ['required', 'same:password'],
            ]);
            $user->password = Hash::make(request('new_password'));
        }

        $user->name = request('name');
        $user->email = request('email');
        $user->phone = request('phone');
        $user->country = request('country');
        $user->state = request('state');
        $user->city = request('city');
        $user->address = request('address');
        $user->zip = request('zip');
        $user->update();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function review()
    {
        $reviews = Review::with('package')->where('user_id', Auth::guard('web')->id())->get();
        return view('user.review', compact('reviews'));

    }

}
