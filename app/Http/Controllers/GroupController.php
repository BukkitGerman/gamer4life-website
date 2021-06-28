<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;
use Junges\ACL\Http\Models\User;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        $usr = Auth::user();
        return view('groups.index', compact('groups', 'usr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('groups.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateddata = $request->validate([
            'name' => ['required', 'max:64'],
            'slug' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ]);

        $group = Group::create($validateddata);

        if($request['permissions'] != null){
            $group->assignPermissions($request['permissions']);
        }

        return redirect('groups')->with('success', 'Group wurde erfolgreich erstellt.');
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
        $group = Group::findOrFail($id);
        $permissions = Permission::all();
        return view('groups.edit', compact('group', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateddata = $request->validate([
            'name' => ['required', 'max:64'],
            'slug' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
        ]);

        Group::whereId($id)->update($validateddata);

        $group = Group::findOrFail($id);

        if($request['permissions'] != null){
            $group->syncPermissions($request['permissions']);
        }

        if(!isset($request['permissions'])){
            $group->revokeAllPermissions();
        }

        return redirect('groups')->with('success', "Group wurde erfolgreicht editiert.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->revokeAllPermissions();
        $group->delete();

        return redirect('groups')->with('success', 'Group wurde erfolgreicht gelöscht.');
    }
}
