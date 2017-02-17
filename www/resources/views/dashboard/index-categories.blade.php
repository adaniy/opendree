@extends('template')

@section('head')
    Tableau de bord / Gestion des catégories
@endsection

@section('meta')

@endsection

@section('content')
    <div class="dashboard">
        @include('dashboard.menu')
        <div class="col-md-10 content">
            @foreach($service->get() as $services)
                <div class="col-md-12">
                    <h4>{{ $services->name }}</h4>
                    <div class="inner">
                        <table class="table table-hover table-striped table-bordered" data-attribute="{{ $services->id }}">
                            @foreach($services->categories as $categories)
                                <tr data-attribute="{{ $categories->id }}">
                                    <th class="col-md-10">{{ $categories->name }} ( @if($categories->type == "money") monétaire @else nombre @endif )</th>
                                    <td class="col-md-2">
                                        <button class="btn btn-xs btn-danger btn-tree" id="delete-category" data-attribute="{{ $categories->id }}" data-name="{{ $categories->name }}">supprimer</button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="text-center"><button class="btn btn-xs btn-warning btn-tree" id="add-category" data-service-name="{{ $services->name }}" data-service="{{ $services->id }}"><span class="glyphicon glyphicon-plus-sign"></span></button></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-10 content">
            <hr />
            <div class="text-muted">
                <span class="glyphicon glyphicon-exclamation-sign"></span> Attention : supprimer un service aura pour conséquence de supprimer toute ses données associées et ce définitivement (sauf sauvegardes).
            </div>
        </div>
    </div>
@endsection
