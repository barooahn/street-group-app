@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ucwords($title)}}</div>

                    <div class="panel-body">
                    @foreach ($homeowners as $homeowner)
                        <p>Title:  {{ $homeowner->title }}</p>
                        <p>First Name:  {{ $homeowner->first_name }}</p>
                        <p>Initial:  {{ $homeowner->initial }}</p>
                        <p>Last Name:  {{ $homeowner->last_name }}</p>
                        <br/>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
