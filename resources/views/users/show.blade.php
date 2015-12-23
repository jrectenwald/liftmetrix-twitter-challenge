@extends('layouts.master')

@section('content')

  <h3>User: {{ $user->name }}</h3>
  <ul>
    <li>Number of Tweets Stored: {{ sizeof($user->tweets) }}</li>

  </ul>


@stop