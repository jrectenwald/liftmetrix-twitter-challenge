<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Tweet extends Eloquent {

    protected $collection = 'tweets';

}