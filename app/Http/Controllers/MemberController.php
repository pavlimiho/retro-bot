<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimRequest;
use App\Http\Requests\StoreMember;
use App\Http\Requests\UpdateMember;
use App\Models\Member;
use App\Models\SimResult;
use App\Services\RaidBots;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::orderBy('name')->get();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMember $request)
    {
        Member::create($request->all());
        return redirect()->route('members.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMember $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());
        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->route('members.index');
    }
    
    public function sim($id, SimRequest $request, RaidBots $raidBots)
    {
        $member = Member::findOrFail($id);
        
        $data = $raidBots->getSimData(Arr::get($request, 'sim'));
        $jsonData = $raidBots->getSimDataFromJson(Arr::get($request, 'sim'));
        
        if (Arr::get($jsonData, 'simbot.player') !== Arr::get($member, 'name')) {
            throw ValidationException::withMessages(['sim' => 'Sim does not match the name']);
        }
        
        $member->sim_link = Arr::get($request, 'sim');
        $member->last_sim_update = Carbon::createFromTimestamp(Arr::get($jsonData, 'timestamp'))->format('Y-m-d H:i:s');
        $member->save();
        
        $simResult = new SimResult();
        $simResult->member_id = Arr::get($member, 'id');
        $simResult->link = Arr::get($request, 'sim');
        $simResult->json = json_encode($data);
        $simResult->save();
        
        return response()->json([
            'success' => true,
            'data' => [
                'data' => $data,
                'date' => Arr::get($member, 'last_sim_update'),
                'memberId' => Arr::get($member, 'id')
            ]
        ]);
    }
    
    public function note($id, Request $request)
    {
        $member = Member::findOrFail($id);
        $member->note = Arr::get($request, 'note');
        $member->save();
        
        return response()->json(['success' => true]);
    }
}
