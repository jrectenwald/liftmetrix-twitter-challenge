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
        
        if(count($timeline) > 0) 
        {
            $user = User::create(array('tweet' => $timeline[0]));
            $user->create_tweets($timeline);
            return response()->json([
                'User' => $user->name, 
                'Number of tweets' => $user->number_of_tweets(),
                'Number of tweets with link' => $user->number_of_tweets_with_link(),
                'Number of retweets' => $user->number_of_retweets(),
                'Average tweet length' => $user->average_tweet_length(),
                'Optimal tweet time' => $user->optimal_tweet_time()
            ]);
        }
        else
        {
            return response()->json("Unable to find user");
        }

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
