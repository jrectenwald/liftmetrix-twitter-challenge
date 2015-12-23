@extends('layouts.master')

@section('content')

  <h3>User: {{ $user->name }}</h3>
  <ul>
    <li>Number of Tweets Stored: {{ $user->number_of_tweets() }}</li>
    <li>Number of Tweets With Link: {{ $user->number_of_tweets_with_link() }}</li>
    <li>Number of Retweets: {{ $user->number_of_retweets() }}</li>
    <li>Average Tweet Length: {{ $user->average_tweet_length() }}</li>
  </ul>


@stop