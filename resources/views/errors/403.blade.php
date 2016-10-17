@extends('layouts.error')

@section('title', 'Forbidden')

@section('message_title', 'We can\'t grant you access here')

@section('message_content')
    <p> If you were trying to download a file make sure that is shared with you <br> If you were trying to enter a configuration make sure that your user is set as root <br> If you were trying to delete a file please keep in mind that it can ony be done by the owner of it  <br> If you think you found a bug please report it on github. </p>
@endsection
