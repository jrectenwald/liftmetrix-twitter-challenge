<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use App\Tweet;

class User extends Eloquent {

    protected $collection = 'users';

    protected $fillable = ['name', 'handle'];
    
    public function tweets()
    {
        return $this->embedsMany('Tweet');
    }

    public function tweets_with_link()
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
            $total_retweet_count += $this->tweets[0]['favorite_count'];
        }
        return $total_retweet_count;
    }
}
























