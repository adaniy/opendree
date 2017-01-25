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
	    <div role="budget" class="tab-pane fade in active" id="gestion">
		@include('budget.gestion')
	    </div>

	    <div role="budget" class="tab-pane fade" id="board">
		@include('budget.board')
	    </div>
	</div>
    </div>
@endsection
