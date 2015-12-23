<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Tweet extends Eloquent {

    protected $collection = 'tweets';

    protected $fillable = array('length', 'retweet_count', 'favorite_count', 'link_count');

}