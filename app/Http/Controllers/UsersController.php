<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tweet;
use App\User;
use Twitter;
use Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $aggregate_timeline = [];

        for ($page_number = 1; $page_number <= 1; $page_number++) {
            $timeline = Twitter::getUserTimeline(['screen_name' => $name, 'page' => $page_number, 'count' => 200, 'format' => 'array', 'exclude_replies' => true, 'include_rts' => false]);
            $aggregate_timeline = array_merge($aggregate_timeline, $timeline);

        }

        $user = User::create(array(
            'name' => $aggregate_timeline[0]['user']['name'], 
            'user_name' => $aggregate_timeline[0]['user']['screen_name']
        ));

        $user->create_tweets($aggregate_timeline);

        return view('users.show', array('user' => $user, 'tweets' => $user->tweets()));

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
