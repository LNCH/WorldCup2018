@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <h2>Group Tables</h2>
            </div>

            @foreach($groups as $group => $teams)
                <div class="col-md-6">

                    <h4>Group {{ $group }}</h4>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Team</th>
                                <th>P</th>
                                <th>W</th>
                                <th>D</th>
                                <th>L</th>
                                <th>F</th>
                                <th>A</th>
                                <th>GD</th>
                                <th>Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teams as $team)
                            <tr>
                                <td><span style="margin-right: 0.5rem;">{!! $team->flag !!}</span>{{ $team->name }}</td>
                                <td class="text-center">{{ $team->played }}</td>
                                <td class="text-center">{{ $team->won }}</td>
                                <td class="text-center">{{ $team->drawn }}</td>
                                <td class="text-center">{{ $team->lost }}</td>
                                <td class="text-center">{{ $team->goalsFor }}</td>
                                <td class="text-center">{{ $team->goalsAgainst }}</td>
                                <td class="text-center">{{ $team->goalDifference }}</td>
                                <td class="text-center">{{ $team->points }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            @endforeach

        </div>
    </div>
@endsection
