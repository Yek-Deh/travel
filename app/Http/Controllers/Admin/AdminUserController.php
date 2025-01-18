<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WebsiteMail;
use App\Models\Admin;
use App\Models\Message;
use App\Models\MessageComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{
    //
    public function message()
    {
        $messages = Message::with('user')->get();
        return view('admin.user.message', compact('messages'));
    }

    public function message_detail($id)
    {
        $message_comments = MessageComment::where('message_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.user.message_detail', compact('message_comments', 'id'));
    }

    public function message_submit(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $obj = new MessageComment();
        $obj->message_id = $id;
        $obj->sender_id = 1;
        $obj->type = 'Admin';
        $obj->comment = $request->comment;
        $obj->save();


        $message_link = route('user_message');
        $subject = 'Admin Message';
        $text = 'Please click on the following link to see the new comment from the admin: <a href="' . $message_link . '">Click Here</a>';
//        $user_email = $request->input('user_email');

        $message = Message::with('user')->where('id', $id)->first();
        $user_email = $message->user->email;
        Mail::to($user_email)->send(new WebsiteMail($subject, $text));

        return redirect()->back()->with('success', 'Message is sent successfully!');
    }
}
