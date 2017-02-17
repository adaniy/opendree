@extends('template')

@section('head')
    Archive <span class="glyphicon glyphicon-chevron-right"></span> Election
@endsection

@section('content')
    @include('archive.menu')

    <div class="archive">
        <div class="col-md-10 content">
            <div class="text-right">{{ $election->links() }}</div>
            <div class="inner-table">
                <table class="table table-striped table-hover">
                    <tr class="header">
                        <th class="col-md-3">Date</th>
                        <th class="col-md-3">Type</th>
                        <th class="col-md-3">Nombre</th>
                        <th class="col-md-3">Action</th>
                    </tr>

                    @foreach($election as $elections)
                        <tr>
			    <td>{{ $elections->date }}</td>
			    <td>{{ $elections->type }}</td>
			    <td>{{ $elections->nb }}</td>
			    <td><button href="/archive/election/delete/{{ $elections->id }}" class="btn btn-xs btn-danger btn-tree">supprimer</button></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
