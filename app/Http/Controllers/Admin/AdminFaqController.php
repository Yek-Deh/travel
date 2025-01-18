<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    //
    public function index(){
        $faqs = Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }
    public function create(){
        return view('admin.faq.create');
    }
    public function create_submit(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = new Faq();

        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

        return redirect()->route('admin_faq_index')->with('success', 'faq Added Successfully');

    }
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }
    public function edit_submit(Request $request,$id){
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        $faq =  Faq::findOrFail($id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();
        return redirect()->route('admin_faq_index')->with('success', 'faq Updated Successfully');

    }
    public function delete($id){
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admin_faq_index')->with('success', 'faq Deleted Successfully');
    }
}
