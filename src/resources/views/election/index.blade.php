@extends('template')

@section('head')
    Elections
@endsection

@section('content')
    <div id="election-module">
        <list></list>
    </div>

    <template id="list">
        <div class="elections">
            coucou !
        </div>
    </template>
    <!--        @for($a = $carbon->now()->subYear(5)->year; $a <= $carbon->now()->year; $a++)
    <tr>
        <td class="annéeBold">{{ $a }}</td>
        @for($i = 1; $i <= 12; $i++)
            <td>{{ $electionClass->totalVoteNbPerMonth($i, $a) }}</td>
        @endfor
        <td><b>{{ $electionClass->totalVoteNbPerYear($a) }}</b></td>
    </tr>
    @endfor
    -->
@endsection
