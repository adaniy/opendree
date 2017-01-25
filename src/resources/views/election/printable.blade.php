<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/override.css') }}" rel="stylesheet">

        <title>GDMC</title>
    </head>
    <body class="printable">
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Inscriptions aux listes électorales par mois et années</h3>
    <hr />
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Année</th>
            @for($i = 1; $i <= 12; $i++)
                <th>{{ $tempsClass->parseMois($i) }}</th>
            @endfor
            <th>Total année</th>
        </tr>
        @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
            <tr>
                <td class="annéeBold">{{ $a }}</td>
                @for($i = 1; $i <= 12; $i++)
                    <td>{{ $electionClass->totalVoteNbPerMonth($i, $a) }}</td>
                @endfor
                <td><b>{{ $electionClass->totalVoteNbPerYear($a) }}</b></td>
            </tr>
        @endfor
    </table>
        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementNov" aria-expanded="false" aria-controls="collapseRecensementNov"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de novembre</h4></a>
        </p>
            <hr />
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Jour</th>
                    @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
                        <th class="annéeBold">{{ $a }}</th>
                    @endfor
                    <th>Total</th>
                </tr>
                @for($i = 1; $i <= 30; $i++)
                <tr>
                    <td><b>{{ $i }}</b></td>
                    @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
                        <td>{{ $electionClass->totalVoteNbPerDay($i, 11, $a) }}</td>
                    @endfor
                    <td><b>{{ $electionClass->totalVoteNbPerSpecial($i, 11) }}</b></td>
                </tr>
                @endfor
            </table>


        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementDec" aria-expanded="false" aria-controls="collapseRecensementDec"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de décembre</h4></a>
        </p>
            <hr />
            <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>Jour</th>
                    @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
                        <th class="annéeBold">{{ $a }}</th>
                    @endfor
                    <th>Total </th>
                </tr>
                @for($i = 1; $i <= 31; $i++)
                <tr>
                    <td><b>{{ $i }}</b></td>
                    @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
                        <td>{{ $electionClass->totalVoteNbPerDay($i, 12, $a) }}</td>
                    @endfor
                    <td><b>{{ $electionClass->totalVoteNbPerSpecial($i, 12) }}</b></td>
                </tr>
                @endfor
            </table>

    <hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Inscriptions aux recensements par mois et années</h3>
    <hr />
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Année</th>
            @for($i = 1; $i <= 12; $i++)
                <th>{{ $tempsClass->parseMois($i) }}</th>
            @endfor
            <th>Total année</th>
        </tr>
        @for($a = $carbon->now()->subYear(4)->year; $a <= $carbon->now()->year; $a++)
            <tr>
                <td class="annéeBold">{{ $a }}</td>
                @for($i = 1; $i <= 12; $i++)
                    <td>{{ $electionClass->totalRecensementNbPerMonth($i, $a) }}</td>
                @endfor
                <td><b>{{ $electionClass->totalRecensementNbPerYear($a) }}</b></td>
            </tr>
        @endfor
    </table>
</body>
</html>