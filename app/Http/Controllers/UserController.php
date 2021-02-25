<?php

namespace App\Http\Controllers;

use App\Models\User;
use Junges\ACL\Http\Models\Permission;
use Junges\ACL\Http\Models\Group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $usr = Auth::user();
        return view('users.index', compact('users', 'usr'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $groups = Group::all();
        return view('users.create', compact('permissions', 'groups'));
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
            'name' => ['required', 'string', 'max:64', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => Hash::make($data["password"]),
        ]);


        if(isset($request['permissions'])){
            $user->syncPermissions($request['permissions']);
        }

        if(isset($request['groups'])){
            $user->syncGroups($request['groups']);
        }

        return redirect('users')->with('success', 'User wurde erfolgreich angelegt.');
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
        $user = User::findOrFail($id);

        $permissions = Permission::all();

        $groups = Group::all();

        return view('users.edit', compact('user', 'permissions', 'groups'));
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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:64'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        
        $users = User::all();

        $user = User::findOrFail($id);

        foreach ($users as $usr) {
            if($usr->email == $data['email']){
                if($usr->email != $user->email){
                    return redirect('users')->with('error', 'Diese Email existiert bereits bei einem anderen User.');
                }
            }
        }

        if($user->email != $data['email'] && $user->name != $data['name']){
            User::whereId($id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
        }elseif($user->email != $data['email']){
            User::whereId($id)->update([
                'email' => $data['email'],
            ]);
        }elseif($user->name != $data['name']){
            User::whereId($id)->update([
                'name' => $data['name'],
            ]);
        }

        if(!isset($request['groups'])){
            $user->revokeAllGroups();
        }else{
            $user->syncGroups($request['groups']);
        }

        if(!isset($request['permissions'])){
            $user->revokeAllPermissions();
        }else{
            $user->syncPermissions($request['permissions']);
        }

        return redirect('users')->with('success', 'User wurde erfolgreich editiert.');
    }       

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->revokeAllPermissions();

        $user->revokeAllGroups();

        $user->delete();

        return redirect('users')->with('success', 'User wurde erfolgreich gelöscht.');
    }
}
