<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class AdminTeamMemberController extends Controller
{
    //
    public function index()
    {
        $team_members = TeamMember::all();
        return view('admin.team_member.index', compact('team_members'));
    }

    public function create()
    {
        return view('admin.team_member.create');
    }

    public function create_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug'=> 'required|alpha_dash|unique:team_members',
            'designation' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $final_name = 'team_member_' . time() . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads'), $final_name);


        $team_member = new TeamMember();
        $team_member->photo = $final_name;
        $this->extracted($request, $team_member);

        return redirect()->route('admin_team_member_index')->with('success', 'team_member Added Successfully');

    }

    public function edit($id)
    {
        $team_member = TeamMember::findOrFail($id);
        return view('admin.team_member.edit', compact('team_member'));
    }

    public function edit_submit(Request $request, $id)
    {
        $team_member = TeamMember::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'slug'=> 'required|alpha_dash|unique:team_members,slug,' . $team_member->id,
            'designation' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($request->photo) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($team_member->photo) {
                unlink(public_path('uploads/') . $team_member->photo);
            }
            $final_name = 'team_member_' . time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads'), $final_name);

            $team_member->photo = $final_name;
        }
        $this->extracted($request, $team_member);
        return redirect()->route('admin_team_member_index')->with('success', 'TeamMember Updated Successfully');

    }

    public function delete($id)
    {
        $team_member = TeamMember::findOrFail($id);
        unlink(public_path('uploads/') . $team_member->photo);
        $team_member->delete();
        return redirect()->route('admin_team_member_index')->with('success', 'TeamMember Deleted Successfully');
    }

    /**
     * @param Request $request
     * @param $team_member
     * @return void
     */
    public function extracted(Request $request, $team_member): void
    {
        $team_member->name = $request->input('name');
        $team_member->slug = $request->input('slug');
        $team_member->designation = $request->input('designation');
        $team_member->email = $request->input('email');
        $team_member->phone = $request->input('phone');
        $team_member->address = $request->input('address');
        $team_member->biography = $request->input('biography');
        $team_member->facebook = $request->input('facebook');
        $team_member->twitter = $request->input('twitter');
        $team_member->linkedin = $request->input('linkedin');
        $team_member->instagram = $request->input('instagram');
        $team_member->save();
    }
}
