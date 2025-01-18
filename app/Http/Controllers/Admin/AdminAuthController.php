<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminAuthController extends Controller
{
    //
    public function login()
    {
        return view('admin.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password']
        ];

        if (Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin_dashboard');
        } else {

            return redirect()->route('admin_login')->with('error', 'The information you entered is incorrect! Please try again!');
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success', 'Logout is successful!');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_submit(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        if ($request->photo) {
            $request->validate([
                'photo' => ['mimes:jpeg,jpg,png'],
            ]);
            $final_name = 'admin_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);
            unlink(public_path('uploads/') . $admin->photo);
            $admin->photo = $final_name;
        }
        if ($request->new_password) {
            $request->validate([
                'new_password' => ['required'],
                'retype_password' => ['required', 'same:new_password'],
            ]);
            $admin->password = Hash::make(request('new_password'));
        }

        $admin->name = request('name');
        $admin->email = request('email');
        $admin->update();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function forgot_password()
    {
        return view('admin.forgot_password');
    }

    public function forgot_password_submit(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Email is not found');
        }

        $token = hash('sha256', time());
        $admin->token = $token;
        $admin->update();

        $reset_link = url('admin/reset-password/' . $token . '/' . $request->email);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='" . $reset_link . "'>Click Here</a>";

        Mail::to($request->email)->send(new WebsiteMail($subject, $message));

        return redirect()->back()->with('success', 'We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
    }

    public function reset_password($token, $email)
    {
        $admin = Admin::where('email', $email)->where('token', $token)->first();
        if (!$admin) {
            return redirect()->route('admin_login')->with('error', 'Token or email is not correct');
        }
        return view('admin.reset_password', compact('token', 'email'));
    }

    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $admin = Admin::where('email', $request->email)->where('token', $request->token)->first();
        $admin->password = Hash::make($request->password);
        $admin->token = "";
        $admin->update();

        return redirect()->route('admin_login')->with('success', 'Password reset is successful. You can login now.');
    }

}
