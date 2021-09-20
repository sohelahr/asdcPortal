@extends('layouts.admin.app')

@section('content')
    <h1>Hello World</h1>
    @foreach ($courses as $course)
        {{$course->name }}
    @endforeach
    <p>
        This view is loaded from module: {!! config('course.name') !!}
    </p>
@endsection
