@extends('template')

@section('head')
    Budget
@endsection

@section('meta')

@endsection

@section('content')
    <div class="budget">
	@include('budget.menu')
    
	<div class="tab-content">
	    <div role="budget" class="tab-pane fade in active" id="tableau">
		@include('budget.tableau')
	    </div>

	    <div role="budget" class="tab-pane fade" id="statistics">
		@include('budget.statistics')
	    </div>
	</div>
    </div>
@endsection
