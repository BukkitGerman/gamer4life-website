<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
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
        
    }

    public function topic($topic, $id)
    {
        $topic_id = DB::SELECT('SELECT id FROM topics WHERE topic = ?', [$topic]);
        if($topic == null || empty($topic))
            return redirect()->route('forum');
        $sql = DB::SELECT('SELECT * FROM posts WHERE id = ? AND topic = ?;', [$id, json_decode(json_encode($topic_id[0]), true)["id"]]);
        if(empty($sql))
             return redirect()->route('forum');
        $post = json_decode(json_encode($sql[0]), true);
        $sql = DB::SELECT('SELECT * FROM post_has_authors WHERE post_id = ?;', [$id]);
        $author_id = json_decode(json_encode($sql[0]), true);
        $sql = DB::SELECT('SELECT * FROM users WHERE id = ?;', [$author_id['user_id']]);
        $author = json_decode(json_encode($sql[0]), true);
        array_push($post, ['name' => $author['name']]);
        return view('forum.post', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sql = DB::SELECT('SELECT * FROM topics;');
        $topics = json_decode(json_encode($sql), true);
        return view('forum.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $data = $request->validate([
            'title' => ['required', 'string', 'min:4','max:255'],
            'text' => ['required', 'string', 'min:10'],
            'topic' => ['required', 'string',],
        ]);

        DB::INSERT('INSERT INTO posts (title, body, topic, slug, active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?);', [$request->title, $request->text, $request->topic, $request->title, true, $current_timestamp, $current_timestamp]);
        $sql = DB::SELECT('SELECT id FROM posts WHERE slug = ? AND created_at = ?', [$request->title, $current_timestamp]);
        $id = json_decode(json_encode($sql[0]), true);
        DB::INSERT('INSERT INTO post_has_authors (user_id, post_id) VALUES (?, ?);', [Auth::User()->id, $id['id']]);
        return redirect('forum')->with('success', 'Post wurde erfolgreich angelegt.');
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
        $post = DB::SELECT("SELECT * FROM posts WHERE id = ?", [$id]);
        $post = json_decode(json_encode($post[0]), true);
        $sql = DB::SELECT('SELECT * FROM topics;');
        $topics = json_decode(json_encode($sql), true);
        return view('forum.edit', compact("id", "post", "topics"));
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
            'title' => ['required', 'string', 'min:4','max:255'],
            'text' => ['required', 'string', 'min:10'],
            'topic' => ['required', 'string',],
        ]);

        $sql = DB::Update('UPDATE posts SET title = ?, body = ?, topic = ?, slug = ? WHERE id = ?', [$data['title'], $data['text'], $data['topic'], $data['title'], $id]);
        if($sql == 1)
            return redirect('forum')->with('success', 'Post wurde erfolgreich bearbeitet.');
        return redirect('forum')->with('error', 'Ein fehler beim speichern ist aufgetreten!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sql = DB::DELETE('DELETE FROM posts WHERE id = ?', [$id]);
        if($sql == 1)
            return redirect('forum')->with('success', 'Post wurde erfolgreich gelöscht.');
        return redirect('forum')->with('error', 'Post konnte nicht gelöscht werden!');
        
    }
}
