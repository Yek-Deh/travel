<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\Admin;
use App\Models\BlogCategory;
use App\Models\Booking;
use App\Models\CounterItem;
use App\Models\Destination;
use App\Models\DestinationPhoto;
use App\Models\DestinationVideo;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Package;
use App\Models\PackageAmenity;
use App\Models\PackageFaq;
use App\Models\PackageItinerary;
use App\Models\PackagePhoto;
use App\Models\PackageVideo;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Review;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\User;
use App\Models\WelcomeItem;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    //
    public function home()
    {
        $sliders = Slider::all();
        $welcome_item = WelcomeItem::first();
        $features = Feature::all();
        $testimonials = Testimonial::all();
        $destinations = Destination::latest()->get()->take(3);
        $packages = Package::with(['destination', 'package_amenities', 'package_itineraries', 'tours', 'reviews'])
            ->orderBy('id', 'desc')->get()->take(3);
        $posts = Post::with('blog_category')->latest()->get()->take(3);   //just to show 3 items
        return view('front.home', compact('sliders', 'welcome_item', 'features', 'testimonials', 'posts', 'destinations', 'packages'));
    }

    public function about()
    {
        $welcome_item = WelcomeItem::first();
        $features = Feature::all();
        $counter_item = CounterItem::first();
        return view('front.about', compact('welcome_item', 'features', 'counter_item'));
    }

    public function team_members()
    {
        $team_members = TeamMember::paginate(4);
        return view('front.team_members', compact('team_members'));
    }

    public function team_member($slug)
    {
        $team_member = TeamMember::where('slug', $slug)->first();
        return view('front.team_member', compact('team_member'));
    }

    public function faq()
    {
        $faqs = Faq::all();
        return view('front.faq', compact('faqs'));
    }

    public function blog()
    {
        $posts = Post::with('blog_category')->paginate(3);
        return view('front.blog', compact('posts'));

    }

    public function post($slug)
    {
        $categories = BlogCategory::all();
        $post = Post::with('blog_category')->where('slug', $slug)->first();
        $latest_posts = Post::latest()->get()->take(3);
        return view('front.post', compact('post', 'categories', 'latest_posts'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->first();
        $posts = Post::with('blog_category')->where('blog_category_id', $category->id)->paginate(9);
        return view('front.category', compact('category', 'posts'));
    }

    public function destinations()
    {
        $destinations = Destination::latest()->paginate(3);
        return view('front.destinations', compact('destinations'));
    }

    public function destination($slug)
    {
        $destination = Destination::where('slug', $slug)->first();
        $destination->view_count = $destination->view_count + 1;
        $destination->update();

        $destination_photos = DestinationPhoto::where('destination_id', $destination->id)->get();
        $destination_videos = DestinationVideo::where('destination_id', $destination->id)->get();

        $packages = Package::with(['destination', 'package_amenities', 'package_itineraries', 'tours', 'reviews'])->orderBy('id', 'desc')
            ->where('destination_id', $destination->id)->get()->take(3);
        return view('front.destination', compact('destination', 'destination_photos', 'destination_videos', 'packages'));
    }

    public function package($slug)
    {
        $package = Package::with('destination')->where('slug', $slug)->first();
        $package_amenities_include = PackageAmenity::with('amenity')->where('package_id', $package->id)->where('type', 'Include')->get();
        $package_amenities_exclude = PackageAmenity::with('amenity')->where('package_id', $package->id)->where('type', 'Exclude')->get();
        $package_itineraries = PackageItinerary::where('package_id', $package->id)->get();
        $package_photos = PackagePhoto::where('package_id', $package->id)->get();
        $package_videos = PackageVideo::where('package_id', $package->id)->get();
        $package_faqs = PackageFaq::where('package_id', $package->id)->get();
        $tours = Tour::where('package_id', $package->id)->get();
        $reviews = Review::with('user')->where('package_id', $package->id)->get();
        return view('front.package', compact('package', 'package_amenities_include', 'package_amenities_exclude',
            'package_itineraries', 'package_photos', 'package_videos', 'package_faqs', 'tours', 'reviews'));

    }

    public function packages(Request $request)
    {
        $form_name = $request->name;
        $form_min_price = $request->min_price;
        $form_max_price = $request->max_price;
        $form_destination_id = $request->destination_id;
        $form_review = $request->review;

        $destinations = Destination::orderBy('name', 'asc')->get();
        $packages = Package::with(['destination', 'package_amenities', 'package_itineraries', 'tours', 'reviews'])->orderBy('id', 'desc');
        if ($request->name != '') {
            $packages = $packages->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->min_price != '') {
            $packages = $packages->where('price', '>=', $request->min_price);
        }

        if ($request->max_price != '') {
            $packages = $packages->where('price', '<=', $request->max_price);
        }

        if ($request->destination_id != '') {
            $packages = $packages->where('destination_id', $request->destination_id);
        }
        if ($request->review != 'all' && request()->review != '') {
            $packages = $packages->whereRaw('ROUND(total_score/total_rating) = ?', [$request->review]);
        }
        $packages = $packages->paginate(6);
        return view('front.packages', compact('destinations', 'packages',
            'form_name', 'form_min_price', 'form_max_price', 'form_destination_id', 'form_review'));
    }

    public function wishlist($package_id)
    {
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'Please login first to add this item to your wishlist!');
        }

        $user_id = Auth::guard('web')->id();

        $check = Wishlist::where('user_id', $user_id)->where('package_id', $package_id)->count();
        if ($check > 0) {
            return redirect()->back()->with('error', 'This item is already in your wishlist!');
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = $user_id;
        $wishlist->package_id = $package_id;
        $wishlist->save();

        return redirect()->back()->with('success', 'Item is added to your wishlist!');

    }

    public function payment(Request $request)
    {
//        dd($request->all());
        $user_id = Auth::guard('web')->id();
        $package = Package::where('id', $request->input('package_id'))->first();
        $total_price = $request->input('ticket_price') * $request->input('total_person');
        // Check the tour selection
        if (!$request->tour_id) {
            return redirect()->back()->with('error', 'Please select a tour first!');
        }
        // Check the tour availability
        $tour_data = Tour::where('id', $request->tour_id)->first();
        $total_allowed_seats = $tour_data->total_seat;
        if ($total_allowed_seats != '-1') {
            $total_booked_seats = 0;
            $all_data = Booking::where('tour_id', $request->tour_id)->where('package_id', $request->package_id)->get();
            foreach ($all_data as $data) {
                $total_booked_seats += $data->total_person;
            }
            $remaining_seats = $total_allowed_seats - $total_booked_seats;
            if ($total_booked_seats + $request->total_person > $total_allowed_seats) {
                return redirect()->back()->with('error', 'Sorry! Only ' . $remaining_seats . ' seats are available for this tour!');
            }
        }

        if ($request->input('payment_method') == 'Stripe') {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $package->name,
                            ],
                            'unit_amount' => $total_price * 100,
                        ],
                        'quantity' => $request->input('total_person'),
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe_success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe_cancel'),
            ]);
            //dd($response);
            if (isset($response->id) && $response->id != '') {
                // session()->put('product_name', $request->product_name);
                // session()->put('quantity', $request->quantity);
                // session()->put('price', $request->price);
                session()->put('total_person', $request->total_person);
                session()->put('tour_id', $request->tour_id);
                session()->put('package_id', $request->package_id);
                session()->put('user_id', $user_id);
                session()->put('paid_amount', $total_price);
                return redirect($response->url);
            } else {
                return redirect()->route('stripe_cancel');
            }
        } else {

            $obj = new Booking;
            $obj->tour_id = $request->input('tour_id');
            $obj->package_id = $request->input('package_id');
            $obj->user_id = Auth::guard('web')->id();
            $obj->total_person = $request->input('total_person');
            $obj->paid_amount = $total_price;
            $obj->payment_method = "Cash";
            $obj->payment_status = 'Pending';
            $obj->invoice_no = time();
            $obj->save();
            return redirect()->back()->with('warning', 'Payment is pending and waiting for confirmation!');
        }


    }

    public function stripe_success(Request $request)
    {
        if (isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            $obj = new Booking;
            $obj->tour_id = session()->get('tour_id');
            $obj->package_id = session()->get('package_id');
            $obj->user_id = session()->get('user_id');
            $obj->total_person = session()->get('total_person');
            $obj->paid_amount = session()->get('paid_amount');
            $obj->payment_method = "Stripe";
            $obj->payment_status = 'Completed';
            $obj->invoice_no = time();
            $obj->save();

//            $payment = new Payment();
//            $payment->payment_id = $response->id;
//            $payment->product_name = session()->get('product_name');
//            $payment->quantity = session()->get('quantity');
//            $payment->amount = session()->get('price');
//            $payment->currency = $response->currency;
//            $payment->customer_name = $response->customer_details->name;
//            $payment->customer_email = $response->customer_details->email;
//            $payment->payment_status = $response->status;
//            $payment->payment_method = "Stripe";
//            $payment->save();

            return redirect()->back()->with('success', 'Payment is successful!');

            unset($_SESSION['tour_id']);
            unset($_SESSION['package_id']);
            unset($_SESSION['user_id']);
            unset($_SESSION['total_person']);
            unset($_SESSION['paid_amount']);

        } else {
            return redirect()->route('stripe_cancel');
        }
    }

    public function stripe_cancel()
    {
        return redirect()->back()->with('error', 'Payment is cancelled!');
    }

    public
    function enquiry_form_submit(Request $request, $id)
    {
        $package = Package::where('id', $id)->first();
        $admin = Admin::where('id', 1)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);
        $subject = "Enquiry about: " . $package->name;
        $message = " <b>Name:</b><br> " . $request->name . "<br><br> ";
        $message .= "<b> Email:</b><br> " . $request->email . "<br><br> ";
        $message .= "<b> Phone:</b><br> " . $request->phone . "<br><br> ";
        $message .= "<b> Message:</b><br> " . nl2br($request->message) . "<br> ";

        Mail::to($admin->email)->send(new WebsiteMail($subject, $message));
        return redirect()->back()->with('success', 'Your enquiry is submitted successfully. We will contact you soon. ');

    }

    public function review_submit(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'rating' => 'required',
        ]);
        $obj = new Review;
        $obj->user_id = Auth::guard('web')->id();
        $obj->package_id = $request->input('package_id');
        $obj->rating = $request->input('rating');
        $obj->comment = $request->input('comment');
        $obj->save();
        $package_data = Package::where('id', $request->input('package_id'))->first();
        $package_data->total_rating = $package_data->total_rating + 1;
        $package_data->total_score = $package_data->total_score + $request['rating'];
        $package_data->save();


        return redirect()->back()->with('success', 'Review is submitted successfully!');

    }

    public
    function registration()
    {
        return view('front.registration');
    }

    public
    function registration_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $token = hash('sha256', time());

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->token = $token;
        $user->save();
        $verification_link = route('registration_verify', ['email' => $request->email, 'token' => $token]);
        $subject = 'User Account Verification';
        $message = 'Please click on the below link to verify your email address: <a href="' . $verification_link . '">Verify Email</a>';

        Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->back()->with('success', 'Registration Successful. Please check your email to verify your account.');
    }

    public
    function registration_verify($email, $token)
    {
        $user = User::where('token', $token)->where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login');
        }
        $user->token = '';
        $user->status = 1;
        $user->update();
        return redirect()->route('login')->with('success', 'Your email is verified. You can login now.');
    }

    public
    function login()
    {
        return view('front.login');
    }

    public
    function login_submit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
            'status' => 1,
        ];

        if (Auth::guard('web')->attempt($data)) {
            return redirect()->route('user_dashboard')->with('success', 'Login Successful.');
        } else {
            return redirect()->route('login')->with('error', 'The information you entered is incorrect! Please try again!')->withInput();
        }
    }

    public
    function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Logout is successful!');
    }

    public
    function forget_password()
    {
        return view('front.forget-password');
    }

    public
    function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email is not found');
        }

        $token = hash('sha256', time());
        $user->token = $token;
        $user->update();

        $reset_link = route('reset_password', ['token' => $token, 'email' => $user->email]);        //or below
//        $reset_link = url('reset-password/'.$token.'/'.$request->email);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br > ";
        $message .= "<a href = '" . $reset_link . "' > Click Here </a > ";

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->back()->with('success', 'We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
    }

    public
    function reset_password($token, $email)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token or email is not correct');
        }
        return view('front.reset-password', compact('token', 'email'));
    }

    public
    function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user = User::where('email', $request->email)->where('token', $request->token)->first();
        $user->password = Hash::make($request->password);
        $user->token = "";
        $user->update();

        return redirect()->route('login')->with('success', 'Password reset is successful. You can login now.');
    }
}
