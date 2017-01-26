@extends('template')

@section('head')
    Tableau de bord / Année {{ $year }}
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
	@include('dashboard.menu')
	
	<div class="col-md-10 content">
	    <table class="table table-bordered">
		<tr>
		    <th class="col-md-12">Date</th>
		    <th>1</th>
		    <th>2</th>
		    <th>3</th>
		    <th>4</th>
		    <th>5</th>
		    <th>6</th>
		    <th>7</th>
		    <th>8</th>
		    <th>9</th>
		</tr>
		@foreach($dashboardClass->holidayCalendar($year, 1) as $calendar)
		<tr>
		    <td>{{ $dashboardClass->temps->parseJour($carbon->parse($calendar)->dayOfWeek) }} {{ $carbon->parse($calendar)->day }} {{ $dashboardClass->temps->parseMois($carbon->parse($calendar)->month) }}</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		</tr>
		@endforeach
	    </table>
	</div>
    </div>
@endsection
