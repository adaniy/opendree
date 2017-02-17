@extends('template')

@section('head')
    Archive <span class="glyphicon glyphicon-chevron-right"></span> Réunion
@endsection

@section('content')
    @include('archive.menu')

    <div class="archive">
        <div class="col-md-10 content">
            <div class="text-right">{{ $reunion->links() }}</div>
            <div class="inner-table">
                <table class="table table-striped table-hover">
                    <tr class="header">
                        <th class="col-md-8">Sujet</th>
                        <th class="col-md-2">Date</th>
                        <th class="col-md-2">Date prochain</th>
                    </tr>

                    @foreach($reunion as $reunions)
                        <tr>
                            <td>{{ $reunions->sujet }}</td>
                            <td>{{ $reunions->date }}</td>
                            <td>{{ $reunions->date_prochain }}</td>
                        </tr>

                        @foreach($reunions->subjects as $subjects)
                            <tr class="header">
				<td>{{ $subjects->sujet }}</td>
				<td>{{ $subjects->observation }}</td>
				<td>{{ $subjects->action }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
