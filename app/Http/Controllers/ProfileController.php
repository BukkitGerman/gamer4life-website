<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Log;
use Image;


class ProfileController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        
        $id = DB::SELECT('SELECT id FROM users WHERE name = ?', [$name]);
        if(empty($id))
            return redirect()->route('landing');
        $user = User::findOrFail($id[0]->id);
        $about = "";
        $about = DB::SELECT('SELECT about FROM profile WHERE user_id = ?', [$user->id]);
        if(empty($about)){
            DB::INSERT('INSERT INTO profile (user_id) VALUES (?);', [$user->id]);
            $route = "/profile/".$user->name;
            return redirect($route);
        }else{
            $about = json_decode(json_encode($about[0]), true);
        }

        $current = Auth::User();
        $follow = false;
        $follower_list = DB::SELECT('SELECT follower_id from user_follows_user WHERE user_id = ?;', [$current->id]);
        foreach ($follower_list as $follower) {
            if($follower->follower_id == $id[0]->id){
                $follow = true;
            }
        }
        $follower_count = DB::SELECT('SELECT COUNT(*) FROM user_follows_user WHERE follower_id = ?;', [$user->id]);
        $post_count = DB::SELECT('SELECT COUNT(*) FROM post_has_authors WHERE user_id = ?;', [$user->id]);
        $post = json_decode(json_encode($post_count[0]), true)['COUNT(*)'];
        $follower = json_decode(json_encode($follower_count[0]), true)['COUNT(*)'];

        $sql = DB::SELECT('SELECT ts_verify FROM users WHERE id = ?', [$user->id]);
        $ts = json_decode(json_encode($sql[0]), true)["ts_verify"];

        return view('profile.index', compact('user', 'current', 'follow', 'follower', 'post', 'about', 'ts'));
    }


    public function teamspeak_verify(Request $request){
        $data = $request->validate([
            'uid' => ['required', 'string', 'min:8'],
        ]);
        $sql = DB::SELECT('SELECT ts_uid FROM users WHERE id = ?', [Auth::User()->id]);
        $uid = json_decode(json_encode($sql[0]),true)['ts_uid'];
        if($uid == "NULL" || $data['uid'] != $uid)
            $sql = DB::INSERT("UPDATE users SET ts_uid = ? WHERE id = ?", [$data['uid'], Auth::User()->id]);
        
        $code_db = DB::SELECT('SELECT ts_code FROM users WHERE id = ?', [Auth::User()->id]);
        $code = "nein";
        if(is_null(json_decode(json_encode($code_db[0]),true)['ts_code'])){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
        
            for ($i = 0; $i < 6; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            $sql = DB::INSERT("UPDATE users SET ts_code = ? WHERE id = ?", [$randomString, Auth::User()->id]);
            $code_db = DB::SELECT('SELECT ts_code FROM users WHERE id = ?', [Auth::User()->id]);
            $code = json_decode(json_encode($code_db[0]),true)['ts_code'];
        }else{
            $code = json_decode(json_encode($code_db[0]),true)['ts_code'];
        }

        $url = 'http://localhost:1337';
        $pore = http_build_query(['uid' => $data['uid'], 'code' => $code, 'pw' => '0024200']);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => $pore,
            ),
        );
        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );
        return redirect('profileedit');
    }

    public function teamspeak_verify_code(Request $request){
        $data = $request->validate([
            'code' => ['required', 'string', 'min:6'],
        ]);
        $code_db = DB::SELECT('SELECT ts_code FROM users WHERE id = ?', [Auth::User()->id]);
        if($data['code'] == json_decode(json_encode($code_db[0]),true)['ts_code']){
            DB::UPDATE('UPDATE users SET ts_verify = true WHERE id = ?', [Auth::User()->id]);
        }
        return redirect('/profile/'.Auth::User()->name);
    }

    public function chat(){
        return redirect('/')->with('warning', 'Chat noch nicht verfügbar!');
    }

    public function indexPost_follow(Request $request)
    {
        $input = $request->all();
        DB::INSERT('INSERT INTO user_follows_user (user_id, follower_id) VALUES (?, ?);', [Auth::User()->id, $input['profile_id']]);
        Log::Info($input['profile_id']);
        $user = User::findOrFail($input['profile_id']);
        $route = "/profile/".$user->name;
        return redirect($route);
    }

    public function indexPost_unfollow(Request $request)
    {
        $input = $request->all();
        DB::DELETE('DELETE FROM user_follows_user WHERE user_id = ? AND follower_id = ?;', [Auth::User()->id, $input['profile_id']]);
        Log::Info($input['profile_id']);
        $user = User::findOrFail($input['profile_id']);
        $route = "/profile/".$user->name;
        return redirect($route);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit()
    {

        $user = Auth::user();
        $about = DB::SELECT('SELECT about FROM profile WHERE user_id = ?', [$user->id]);
        if(empty($about)){
            DB::INSERT('INSERT INTO profile (user_id) VALUES (?);', [$user->id]);
            $about = "";
        }else{
            $about = json_decode(json_encode($about[0]), true)["about"];
        }

        $sql = DB::SELECT('SELECT ts_uid FROM users WHERE id = ?', [$user->id]);
        $uid = json_decode(json_encode($sql[0]), true)["ts_uid"];
        if(is_null($uid)){
            $uid = "";
        }

        $sql = DB::SELECT('SELECT ts_verify FROM users WHERE id = ?', [$user->id]);
        $ts_verify = json_decode(json_encode($sql[0]), true)["ts_verify"];

        return view('profile.edit', compact('user', 'about', 'uid', 'ts_verify'));
    }

    public function update_avatar(Request $request)
    {
        $user = Auth::user();
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . "." . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/images/avatars/'. $filename));
            $sql = DB::SELECT('SELECT avatar FROM users WHERE id = ?', [$user->id]);
            $pre_avatar = json_decode(json_encode($sql[0]),true)['avatar'];
            if($pre_avatar != "default.jpg")
                unlink(public_path('/images/avatars/'. $pre_avatar));
            $user->avatar = $filename;
            $user->save();
        }
            

        if($request->has('about')){
            $about = $request->input('about');
            DB::UPDATE('UPDATE profile SET about = ? WHERE user_id = ?', [$about, $user->id]);
        }

        $route = "/profile/".$user->name;
        return redirect($route);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
