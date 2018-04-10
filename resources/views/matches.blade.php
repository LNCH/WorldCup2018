@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <h2>Scheduled Matches</h2>
            </div>

            @foreach($matches as $match)
                <div class="col-md-6">
                    <div class="match-card text-center">

                        <div class="match-meta">
                            <span class="group">Group {{ $match->homeTeam->group }}</span>
                            <span class="date">{{ $match->match_date->format("jS F Y") }} -
                                {{ $match->match_date->format("H:i") }}</span>
                            <span class="channel">{{ $match->channel }}</span>
                        </div>

                        <div class="score-container">
                            <div class="team home">{{ $match->homeTeam->name }} {!! $match->homeTeam->flag !!}</div>
                            <span class="score home">{{ $match->home_score !== null ? $match->home_score : '-' }}</span>
                            <span class="vs">vs</span>
                            <span class="score away">{{ $match->away_score !== null ? $match->away_score : '-' }}</span>
                            <div class="team away">{!! $match->awayTeam->flag !!} {{ $match->awayTeam->name }}</div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
