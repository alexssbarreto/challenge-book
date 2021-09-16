@extends('layouts.app')

@section('content')
    <router-view></router-view>
    <div>
        <snack-bar />
    </div>
    <div>
        <dialog-confirm />
    </div>
@endsection
