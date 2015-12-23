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
        $timeline = $this->gather_timeline($name);
        $user = User::create(array('tweet' => $timeline[0]));
        $user->create_tweets($timeline);

        return view('users.show', array('user' => $user, 'tweets' => $user->tweets()));

    }

    private function gather_timeline($name)
    {
        $aggregate_timeline = [];
        for ($page_number = 1; $page_number <= 1; $page_number++) {
            $timeline = Twitter::getUserTimeline(['screen_name' => $name, 'page' => $page_number, 'count' => 200, 'format' => 'array', 'exclude_replies' => true]);
            $aggregate_timeline = array_merge($aggregate_timeline, $timeline);

        }
        return $aggregate_timeline;
    }
}
