@extends('app')

@section('app_content')
    <tombola-show :tombola_prop="{{ $tombola->toJson() }}"></tombola-show>
@endsection
