@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        @foreach($teams as $team) 
            <div class="col-md-3 text-center">
                <h4>{{ $team->name }}</h4>
                
                <span class="flag-icon flag-icon-{{ strtolower(substr($team->code, 0, 2)) }}"></span>
            </div>
        @endforeach
        
    </div>
</div>
@endsection
