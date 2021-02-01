@extends('app')

@section('app_content')
    <user-show :user_prop="{{ $user->toJson() }}"></user-show>
@endsection
