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
        for ($index = 0; $index < $this->number_of_tweets(); $index++) {
            $total_retweet_count += $this->tweets[$index]['favorite_count'];
        }
        return $total_retweet_count;
    }

    public function average_tweet_length()
    {
        $number_of_tweets = $this->number_of_tweets();
        $total_tweet_length = 0;
        for ($index = 0; $index < $this->number_of_tweets(); $index++) {
            $total_tweet_length += $this->tweets[0]['length'];
        }
        return ($total_tweet_length / $number_of_tweets);
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
                'link_count' => $link_count
            ));
        }
    }


}
























