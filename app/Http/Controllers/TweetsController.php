<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tweet;
use App\User;
use Twitter;
use Response;

class TweetsController extends Controller
{
    
    public function index(Request $request)
    {
        $startdate = new \DateTime($request['startdate']);
        $enddate = new \DateTime($request['enddate']);
        $name = $request['name'];
        $timeline = $this->gather_timeline($name);

        
        if(count($timeline) > 0) 
        {
            $retweets_over_time = [];
            $user = User::create(array('tweet' => $timeline[0]));

            for ($i = 0; $i < count($timeline); $i++)
            {
                $tweet = $timeline[$i];
                $created_at = new \DateTime($tweet['created_at']);
                $date = $created_at->format('m-d-Y');
                if(isset($retweets_over_time[$date]) && $created_at > $startdate && $created_at < $enddate)
                {
                    $retweets_over_time[$date] += $tweet['retweet_count'];
                }
                elseif($created_at > $startdate && $created_at < $enddate)
                {
                    $retweets_over_time[$date] = $tweet['retweet_count'];
                }
            }
            $retweets_over_time_formatted = [];
            $days = array_keys($retweets_over_time);
            foreach($days as $day) {
                {
                    $single_day_stats = ['value' => $retweets_over_time[$day], 'date' => $day];
                    array_push($retweets_over_time_formatted, $single_day_stats);
                }
            }

            return response()->json(['retweets' => $retweets_over_time_formatted]);
        }
        else
        {
            return response()->json("Unable to find user");
        }
    }

    private function gather_timeline($name)
    {
        $aggregate_timeline = [];
        for ($page_number = 1; $page_number <= 16; $page_number++) {
            $timeline = Twitter::getUserTimeline(['screen_name' => $name, 'page' => $page_number, 'count' => 200, 'format' => 'array', 'exclude_replies' => true]);
            $aggregate_timeline = array_merge($aggregate_timeline, $timeline);

        }
        return $aggregate_timeline;
    }

    
    
}

// "Tue Dec 22 18:41:22 +0000 2015"
