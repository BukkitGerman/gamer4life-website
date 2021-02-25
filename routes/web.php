<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('landing');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/insertdata', function(){

    DB::INSERT('INSERT INTO users (id, name, email, password, created_at, updated_at) VALUES (1, "BukkitGerman", "preussjustin@outlook.de", "$2y$10$lmQVbgKYVdR.MXns6Qg5Gu4CdMOvFx8ULmUyGfm2kjfBN.9s50722", "2021-02-09 22:41:57", "2021-02-09 22:41:57");');
    DB::INSERT('INSERT INTO users (id, name, email, password, created_at, updated_at) VALUES (2, "Test", "test@test.de", "$2y$10$RjzKzZvvpeD8kt2kk3F25Oi/WK7W2hjXWnARF9nz9UT5vRppfZeOq", "2021-02-09 22:41:57", "2021-02-09 22:41:57");');

    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Administrator", "administrator", "can do everything");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Dashboard", "dashboard.show", "See the Dashboard");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Post", "post.create", "Allows the user to create posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Changelog", "changelog.create", "Allows the user to create a Changelog");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Allow to edit Posts", "post.edit", "Allows the user to edit posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Allow to delete Posts", "post.delete", "Allows the user to delete posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Events Post", "post.create.events", "Allows the user to create events posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Gaming Post", "post.create.gaming", "Allows the user to create gaming posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Advice Post", "post.create.advice", "Allows the user to create advice posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Info Post", "post.create.info", "Allows the user to create info posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Application from Exile Post", "post.create.application_from_exile", "Allows the user to create Application from Exile posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Complaint Post", "post.create.complaint", "Allows the user to create complaint posts");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Create Topics", "topic.create", "Allows the user to create Topics");');
    DB::INSERT('INSERT INTO permissions (name, slug, description) VALUES ("Allow to delete Topics", "topic.delete", "Allows the user to delete Topics");');
    
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 1);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 2);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 3);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 4);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 5);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 6);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 7);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 8);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 9);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 10);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 11);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 12);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 13);');
    DB::INSERT('INSERT INTO user_has_permissions (user_id, permission_id) VALUES (1, 14);');

    DB::INSERT('INSERT INTO topics (id, topic) VALUES (1, "Events");');
    DB::INSERT('INSERT INTO topics (id, topic) VALUES (2, "Gaming");');
    DB::INSERT('INSERT INTO topics (id, topic) VALUES (3, "Advice");');
    DB::INSERT('INSERT INTO topics (id, topic) VALUES (4, "Info");');
    DB::INSERT('INSERT INTO topics (id, topic) VALUES (5, "Application_from_exile");');
    DB::INSERT('INSERT INTO topics (id, topic) VALUES (6, "Complaint");');

    DB::INSERT('INSERT INTO head_topics (head_topic) VALUES ("Community");');
    DB::INSERT('INSERT INTO head_topics (head_topic) VALUES ("Verwaltung");');
    DB::INSERT('INSERT INTO head_topics (head_topic) VALUES ("Spiele");');

    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (1, 1);');
    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (1, 2);');
    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (2, 3);');
    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (2, 4);');
    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (2, 5);');
    DB::INSERT('INSERT INTO head_topic_has_topics (head_topic_id, topic_id) VALUES (2, 6);');

    DB::INSERT('INSERT INTO posts (title, body, topic, slug, active) VALUES ("Erster Beitrag", "Der Text des ersten Beitrags.", 1, "erster beitrag", true);');
    DB::INSERT('INSERT INTO post_has_authors (user_id, post_id) VALUES (1, 1);');

    DB::INSERT('INSERT INTO posts (title, body, topic, slug, active) VALUES ("Zweiter Beitrag", "Der Text des Zweiten Beitrags.", 1, "zweiter beitrag", true);');
    DB::INSERT('INSERT INTO post_has_authors (user_id, post_id) VALUES (1, 2);');

    $date = new DateTime('15.02.2020');
    $result = $date->format('d-m-Y');
    DB::INSERT('INSERT INTO changelogs (title, body, date, author) VALUES ("Erster Changelog", "Body des ersten Changelogs", ?, 1);', [$date]);
    $date = new DateTime('16.02.2020');
    $result = $date->format('d-m-Y');
    DB::INSERT('INSERT INTO changelogs (title, body, date, author) VALUES ("Zweiter Changelog", "Body des Zweiten Changelogs", ?, 1);', [$date]);


    return redirect('/')->with('status', 'Testdaten erfolgreich eingesetzt!');
});


//Profile Routes
Route::redirect('profile','/');
Route::get('/profile/{name}', [App\Http\Controllers\ProfileController::class, 'index'])->where('name', '[A-Za-z0-9_.]+')->name('profile');
Route::POST('/profile/{name}', [App\Http\Controllers\ProfileController::class, 'update_avatar'])->where('name', '[A-Za-z0-9_.]+')->name('profile_post');
Route::POST('/chat', [App\Http\Controllers\ProfileController::class, 'chat'])->name('chat');
Route::POST('/follow', [App\Http\Controllers\ProfileController::class, 'indexPost_follow'])->where('name', '[A-Za-z0-9_.]+')->name('follow');
Route::POST('/unfollow', [App\Http\Controllers\ProfileController::class, 'indexPost_unfollow'])->where('name', '[A-Za-z0-9_.]+')->name('unfollow');
Route::get('/profileedit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile_edit');
Route::POST('/verifytscode', [App\Http\Controllers\ProfileController::class, 'teamspeak_verify_code'])->name('teamspeak_verify_code');
Route::POST('/gettscode', [App\Http\Controllers\ProfileController::class, 'teamspeak_verify'])->name('teamspeak_verify');

//Changelog Routes
Route::prefix('changelog')->group(function () {
    Route::get('/', [App\Http\Controllers\ChangelogController::class, 'index'])->name('changelog');
    Route::get('/{id}', [App\Http\Controllers\ChangelogController::class, 'showChangelog'])->where('id', '[0-9]')->name('changelog.post');
    Route::get('/create', [App\Http\Controllers\ChangelogController::class, 'create'])->name('createChangelog')->middleware("permissions:changelog.create");

});

//Forum Routes
Route::prefix('forum')->group(function () {
    Route::get('/', [App\Http\Controllers\ForumController::class, 'index'])->name('forum');
    Route::get('/create', [App\Http\Controllers\PostController::class, 'create'])->name('createPost')->middleware("permissions:post.create");
    Route::get('/createTopic', [App\Http\Controllers\TopicController::class, 'create'])->name('createTopic')->middleware("permissions:topic.create");

    Route::get('/{topic}', [App\Http\Controllers\ForumController::class, 'topic'])->name('forum.events');
    Route::get('/{topic}/{id}', [App\Http\Controllers\PostController::class, 'topic'])->where('id', '[0-9]')->name('post');
    Route::Post('/post/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update')->middleware("permissions:post.edit");

});

//Login und Rechteverwaltung
Route::resource('dashboard', 'App\Http\Controllers\DashboardController')->middleware('permissions:administrator');
Route::resource('permissions', 'App\Http\Controllers\PermissionController')->middleware('permissions:administrator');
Route::resource('users', 'App\Http\Controllers\UserController')->middleware('permissions:administrator');
Route::resource('groups', 'App\Http\Controllers\GroupController')->middleware('permissions:administrator');
Route::resource('post', 'App\Http\Controllers\PostController')->middleware('permissions:post.create');
Route::resource('changelogs', 'App\Http\Controllers\ChangelogController')->middleware('permissions:changelog.create');
Route::resource('topic', 'App\Http\Controllers\TopicController')->middleware('permissions:topic.create');