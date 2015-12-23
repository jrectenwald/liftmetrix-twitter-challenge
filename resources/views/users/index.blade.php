@extends('layouts.master')

@section('content')

  <h3>Enter a Twitter Handle</h3>

  {!! Form::open() !!}

    <div class="form-group">
      {!! Form::label('name') !!}
      {!! Form::text('name', null, ['class' => 'form-control select-user']) !!}
    </div>

    <div class="form-group">
      {!! Form::submit('Analyze Tweets', ['class' => 'btn btn-primary form-control']) !!}
    </div>

  {!! Form::close() !!}


@stop