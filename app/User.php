<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use App\Tweet;

class User extends Eloquent {

    protected $collection = 'users';

    protected $fillable = ['name', 'handle'];

    function __construct($tweet) {
        $tweet = reset($tweet);
        $this->name  = $tweet['user']['name'];
        $this->handle = $tweet['user']['screen_name'];
    }
    
    public function tweets()
    {
        return $this->embedsMany('Tweet');
    }

    public function number_of_tweets()
    {
        return count($this['tweets']);
    }

    public function number_of_tweets_with_link()
    {
        return count($this['tweets']->where('link_count', '>', 0));
    }

    public function number_of_retweets()
    {
        $total_retweet_count = 0;
        for ($i = 0; $i < $this->number_of_tweets(); $i++) {
            $total_retweet_count += $this->tweets[$i]['favorite_count'];
        }
        return $total_retweet_count;
    }

    public function average_tweet_length()
    {
        $number_of_tweets = $this->number_of_tweets();
        $total_tweet_length = 0;
        for ($i = 0; $i < $this->number_of_tweets(); $i++) {
            $total_tweet_length += $this->tweets[$i]['length'];
        }
        return (floor($total_tweet_length / $number_of_tweets));
    }

     public function create_tweets($timeline)
    {
        for ($i = 0; $i < count($timeline); $i++) {
            $reg_exUrl = '#\bhttps?://[^\s()<>]#';
            $text = $timeline[$i]['text'];
            preg_match_all($reg_exUrl, $text, $links);
            $link_count = count($links[0]);

            $this->tweets()->create(array(
                'length' => strlen($timeline[$i]['text']),
                'retweet_count' => $timeline[$i]['retweet_count'],
                'favorite_count' => $timeline[$i]['favorite_count'],
                'link_count' => $link_count,
                'datetime' => $timeline[$i]['created_at']
            ));
        }
    }

    public function optimal_tweet_time()
    {
        $tweets_time_frequency = [];
        $tweets = $this->tweets();
        for ($i = 0; $i < $this->number_of_tweets(); $i++) {
            $tweet_attributes = $this->tweets[$i]->attributes;
            $time = $this->parse_time($tweet_attributes['datetime']);
            $tweet_value = $tweet_attributes['retweet_count'] + $tweet_attributes['favorite_count'];

            if(isset($tweets_time_frequency[$time]))
            {
                $tweets_time_frequency[$time] += $tweet_value;
            }
            else
            {
                $tweets_time_frequency[$time] = $tweet_value;
            }
        }
        $max = max($tweets_time_frequency);
        return array_search($max, $tweets_time_frequency);
    }

    public function parse_time($datetime)
    {
        $datetime_array = explode(' ', $datetime);
        $time = $datetime_array[3];
        return substr($time, 0, 4) . "0";
    }
}
























