@extends('template')

@section('contenu')
    <div class="pull-left"><div id="decal"><a class="btn btn-sm btn-danger" href="{{ url('election/brut') }}">Données brutes</a></div></div>

    <div class="pull-right"><div id="decal"><a class="btn btn-sm btn-info" href="{{ url('election/printable') }}">Version imprimable</a></div></div>
    
    <br /><br /><hr />
    <h3><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Insérer des inscriptions</h3>
    <hr />
        <form class="form-inline" action="{{ url('election') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="date" class="form-control" id="id" placeholder="Date de l'inscription">
                </div>

                <div class="form-group">
                    <input type="text" name="nb" class="form-control" id="id" placeholder="Nombre d'inscription">
                </div>
                <br /><br />
            </div>

            <div class="col-md-12">
                <div class="radio">
                    <label>
                        <input type="radio" name="type" value="vote" checked>
                        Électorales
                    </label>
                </div>
                &nbsp;
                <div class="radio">
                    <label>
                        <input type="radio" name="type" value="recensement">
                        Recensements
                    </label>
                </div>
            </div>
            <br />
            <br /><br /><br /><br />
            
            <div class="col-md-12">
                <input type="submit" class="btn btn-sm btn-info" value="Insérer">
            </div>
        </form>
    <br /><br />
    <hr />
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

    <div class="bs-voteNov">
        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementNov" aria-expanded="false" aria-controls="collapseRecensementNov"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de novembre</h4></a>
        </p>
        <div class="collapse" id="collapseRecensementNov">
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
        </div>
    </div>

    <div class="bs-voteNov">
        <p>
            <a id="deroule" role="button" data-toggle="collapse" href="#collapseRecensementDec" aria-expanded="false" aria-controls="collapseRecensementDec"><h4><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> Mois de décembre</h4></a>
        </p>
        <div class="collapse" id="collapseRecensementDec">
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
        </div>
    </div>
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
@endsection