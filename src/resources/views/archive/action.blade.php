@extends('template')

@section('head')
    Archive <span class="glyphicon glyphicon-chevron-right"></span> Action
@endsection

@section('content')
    @include('archive.menu')

    <div class="archive">
        <div class="col-md-10 content">
	    <div class="text-right">{{ $action->links() }}</div>
            <div class="inner-table">
                <table class="table table-striped table-hover">
                    <tr class="header">
                        <th class="col-md-6">Titre</th>
                        <th class="col-md-2">Date création</th>
                        <th class="col-md-2">Date butoir</th>
                        <th class="col-md-2">Date réalisation</th>
                    </tr>
                    @foreach($action as $actions)
                        <tr>
                            <td>{{ $actions->nom }}</td>
                            <td>{{ $actions->date_creation }}</td>
                            <td>{{ $actions->date_butoir }}</td>
                            <td>{{ $actions->date_realisation }}</td>
                        </tr>
                        @if(!empty($actions->description))
                            <tr class="header">
                                <td colspan="4" class="description"><span class="glyphicon glyphicon-chevron-right"></span> {{ $actions->description }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
