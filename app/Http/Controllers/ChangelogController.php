<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::SELECT('SELECT * FROM changelogs ORDER BY date DESC');
        $changelogs = json_decode(json_encode($data), true);
        return view('changelog.index', compact('changelogs'));
    }

    public function showChangelog($id)
    {
        $data = DB::SELECT('SELECT * FROM changelogs WHERE id = ?', [$id]);
        $changelog = json_decode(json_encode($data), true)[0];
        $author = DB::SELECT('SELECT name FROM users WHERE id = ?', [$changelog['author']]);
        $changelog['author'] = json_decode(json_encode($author), true)[0]["name"];
        return view('changelog.post', compact('changelog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('changelog.create');
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
            'title' => ['required', 'string', 'min:4','max:255'],
            'text' => ['required', 'string', 'min:10'],
            'date' => ['required', 'date'],
        ]);
        $current_timestamp = Carbon::now()->toDateTimeString();
        $author = Auth::User();

        $state = DB::INSERT('INSERT INTO changelogs (title, body, date, author, created_at, updated_at) VALUES (?, ?, ?, ? , ?, ?);', [$data['title'], $data['text'], $data['date'], $author->id, $current_timestamp, $current_timestamp]);
        if($state == 1)
            return redirect('changelog')->with('success', 'Changelog wurde erfolgreich angelegt.');
        return redirect('changelog')->with('error', 'Ein fehler beim anlegen ist aufgetreten.');
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
