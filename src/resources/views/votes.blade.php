@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (is_null($participant))
                    <h2>olcLeaderboard Votes</h2>
                @else
                    <h2>Votes for {{$participant->name}}</h2>
                @endif

                <div id="chart_container" class="mt-5">
                    <canvas id="votes_chart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var chart = $('#votes_chart');
        var labels = JSON.parse('{!! $dates !!}');
        var myChart = new Chart(chart, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: {!! $votes[0] !!},
                    fill: false,
                    label: "Wins",
                    borderColor: '#ec6f13'
                }, {
                    data: {!! $votes[1] !!},
                    fill: false,
                    label: "Fails",
                    borderColor: '#4b0269'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1
                        }
                    }]
                },
                layout: {
                    padding: 40
                }
            }
        });
    </script>
@endpush
