<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Junges\ACL\Http\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class ForumController extends Controller
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
    public function index()
    {

        $head_topics = DB::SELECT('SELECT head_topic FROM head_topics');
        $arr = [];
        foreach(json_decode(json_encode($head_topics), true) as $head_topic){
            $haed_topic_id = DB::SELECT('SELECT id FROM head_topics WHERE head_topic = ?;', [$head_topic['head_topic']]);
            $topics = DB::SELECT('SELECT topic_id FROM head_topic_has_topics WHERE head_topic_id = ?', [json_decode(json_encode($haed_topic_id[0]), true)['id']]);
            $topics_id = json_decode(json_encode($topics), true);
            $topics = [];
            foreach($topics_id as $topic_id){
                $topic = DB::SELECT('SELECT topic FROM topics WHERE id = ?', [$topic_id['topic_id']]);
                $topic_count = DB::SELECT('SELECT COUNT(*) FROM posts WHERE topic = ?', [$topic_id['topic_id']]);
                array_push($topics , [json_decode(json_encode($topic[0]), true)['topic'], (int)json_decode(json_encode($topic_count[0]), true)['COUNT(*)']]);
            }
            array_push($arr, array($head_topic['head_topic'] => $topics));
        }
        return view('forum.index', compact('arr'));
    }

    public function topic($topic){
        $topic_id = DB::SELECT('SELECT id FROM topics WHERE topic = ?', [$topic]);
        if($topic_id == null || empty($topic_id))
            return redirect()->route('forum');
        $topic_ = json_decode(json_encode($topic_id[0]), true);
        $posts = DB::SELECT('SELECT * FROM posts WHERE topic = ?', [json_decode(json_encode($topic_id[0]), true)["id"]]);
        $posts = json_decode(json_encode($posts), true);
        return view('forum.topic', compact('posts', 'topic', 'topic_'));
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
    public function edit($id)
    {
        //
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
