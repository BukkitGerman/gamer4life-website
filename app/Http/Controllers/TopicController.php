<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TopicController extends Controller
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
    
    public function create()
    {
        $sql = DB::SELECT('SELECT * FROM head_topics;');
        $head_topics = json_decode(json_encode($sql), true);
        return view('forum.topic.create', compact('head_topics'));
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
            'name' => ['required', 'string', 'alpha_dash', 'min:2','max:30'],
            'topic' => ['required', 'string'],
        ]);
        DB::INSERT('INSERT INTO topics (topic) VALUES (?);', [$data['name']]);
        $sql = DB::SELECT('SELECT id FROM topics WHERE topic = ?;', [$data['name']]);
        $topic_id = json_decode(json_encode($sql[0]), true)["id"];
        DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (?, ?);', [$data['topic'], $topic_id]);
        DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES (?, ?, ?);', ["Create ".$data['name']." Post" ,"post.create.".strtolower($data['name']), "Allows the user to create ".$data['name']." posts"]);
        return redirect('forum')->with('success', 'Topic wurde erfolgreich angelegt.');
    }

    public function destroy($id)
    {
        if(Auth::User()->can('topic.delete')){
            $sql = DB::DELETE('DELETE FROM topics WHERE id = ?', [$id]);
            if($sql == 1)
                return redirect('forum')->with('success', 'Topic wurde erfolgreich gelöscht.');
        }
        return redirect('forum')->with('error', 'Topic konnte nicht gelöscht werden!');
        
    }
}
