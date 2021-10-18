<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = TeamMember::with('team')->paginate(10);
        return view('member.index', [
            "members" => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();
        return view('member.create', [
            "teams" => $teams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required",
            "team_id" => "numeric|required"
        ]);
        TeamMember::create($data);
        return Redirect::route('member.index')->with("message", "Member created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TeamMember  $member
     * @return \Illuminate\Http\Response
     */
    public function show(TeamMember $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeamMember  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamMember $member)
    {
        $teams = Team::all();
        return view('member.edit', ["member" => $member, "teams" => $teams]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeamMember  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamMember $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeamMember  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamMember $member)
    {
        $deleted = $member->delete();
        return Redirect::route('member.index')->with("message", "Team member deleted successfully");
    }
}
