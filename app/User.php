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
}


