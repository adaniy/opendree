@extends('template')

@section('head')
    Archive
@endsection

@section('content')
    @include('archive.menu')

    <div class="archive">
        <div class="col-md-10 content no-print">
            <h4><div class="pull-right no-print"><button class="btn btn-xs btn-primary live" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></button></div>Archive de la base de donnée</h4>
            <p class="text-muted">L'archive de la base de donnée permet de consulter les données supprimées uniquement, et ces données ne peuvent pas être supprimés à leur tour.</p>
            <div class="inner-table">
                <table class="table table-striped table-hover">
                    <tr class="header">
                        <th class="col-md-2">Module</th>
                        <th class="col-md-5">Nombre de données</th>
                        <th class="col-md-5">Nombre de données supprimés</th>
                    </tr>

                    <tr>
                        <td class="header">Action</td>
                        <td>{{ $nbAction }}</td>
                        <td>{{ $nbActionDeleted }}</td>
                    </tr>

                    <tr>
                        <td class="header">Réunion</td>
                        <td>{{ $nbReunion }}</td>
                        <td>{{ $nbReunionDeleted }}</td>
                    </tr>

                    <tr>
                        <td class="header">Election</td>
                        <td>{{ $nbElection }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-12 visible-print">
            <h1 class="text-center">Archive de la base de donnée</h1>
            <div class="inner-table">
                <table class="table table-striped table-hover">
                    <tr class="header">
                        <th class="col-md-2">Module</th>
                        <th class="col-md-5">Nombre de données</th>
                        <th class="col-md-5">Nombre de données supprimés</th>
                    </tr>

                    <tr>
                        <td class="header">Action</td>
                        <td>{{ $nbAction }}</td>
                        <td>{{ $nbActionDeleted }}</td>
                    </tr>

                    <tr>
                        <td class="header">Réunion</td>
                        <td>{{ $nbReunion }}</td>
                        <td>{{ $nbReunionDeleted }}</td>
                    </tr>

                    <tr>
                        <td class="header">Election</td>
                        <td>{{ $nbElection }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
