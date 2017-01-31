@extends('template')

@section('head')
    Réunions
@endsection

@section('content')
    <div class="reunions">
        <div class="col-md-12">
            <div class="top">
                <div class="buttons pull-right"><button class="btn btn-xs btn-success btn-tree" id="add-reunion">Ajouter une réunion</button></div>
                <div class="display pull-right"><button class="btn btn-xs btn-default live"><span class="glyphicon glyphicon-th-large"></span></button> <button class="btn btn-xs btn-default live"><span class="glyphicon glyphicon-th-list"></span></button></div>
                <div class="amount">29 Réunions</div>
                <div class="search"><span class="glyphicon glyphicon-search"></span> Recherche</div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="bottom">
                @foreach($reunion as $reunions)
                    <div class="col-md-3 block" data-attribute="{{ $reunions->id }}">
                        <div class="head">
                            <div class="pull-right">
                                <button class="btn btn-xs btn-success live" id="edit-reunion" data-toggle="modal" data-target="#edit-reunion-{{ $reunions->id }}"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-xs btn-danger live" id="delete-reunion" data-attribute="{{ $reunions->id }}"><span class="glyphicon glyphicon-remove"></span></button>
                            </div>
                            <div class="modal fade" id="edit-reunion-{{ $reunions->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-reunion-{{ $reunions->id }}-Label">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="edit-reunion-{{ $reunions->id }}-Label">Modification de la réunion #{{ $reunions->id }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form" id="reunion">
                                                <div class="form-group">
                                                    <label for="sujet">Sujet de la réunion</label>
                                                    <input type="text" class="form-control" name="sujet" value="{{ $reunions->sujet }}" />
                                                </div>

                                                <div class="form-group">
                                                    <label for="sujet">Date de la réunion</label>
                                                    <br />
                                                    <div class="col-md-8">
                                                        <input type="date" class="form-control" name="date_date" value="{{ $reunionClass->getDateDate($reunions->id) }}" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control" name="date_time" value="{{ $reunionClass->getDateTime($reunions->id) }}" />
                                                    </div>

                                                </div>
                                                <br /><br />
                                                <div class="form-group">
                                                    <label for="sujet">Date de la prochaine réunion</label>
                                                    <div class="col-md-8">
                                                        <input type="date" class="form-control" name="date_prochain_date" value="{{ $reunionClass->getDateProchainDate($reunions->id) }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <input type="time" class="form-control" name="date_prochain_time" value="{{ $reunionClass->getDateProchainTime($reunions->id) }}" />
                                                    </div>
                                                </div>
                                                <br /><br />
                                                <div class="form-group pull-right">
                                                    <input type="submit" class="btn btn-success" value="Enregistrer" />
                                                </div>
                                            </form>
                                            <br /><br /><hr />
                                            @foreach($reunions->sujets as $sujets)
                                                <div class="wrap-sujets">
                                                    <div class="pull-left buttons"><button class="btn btn-xs btn-danger live" id="delete-sujet" data-attribute="{{ $sujets->id }}"><span class="glyphicon glyphicon-remove"></span></button> <button class="btn btn-xs btn-success live" id="edit-sujet" data-attribute="{{ $sujets->id }}"><span class="glyphicon glyphicon-edit"></span></button></div><li type="button" data-toggle="collapse" data-target="#collapseEdit{{ $sujets->id }}" aria-expanded="false" aria-controls="collapseEdit{{ $sujets->id }}">{{ $sujets->sujet }}</li>
                                                    <div class="collapse details-collapse-edit" id="collapseEdit{{ $sujets->id }}">
                                                        <div class="details">
                                                            <div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live" id="edit-observation" data-attribute="{{ $sujets->id }}""><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Observations</div>
                                                            <div class="content">{!! $sujets->observation !!}</div>
                                                        </div>

                                                        <div class="details">
                                                            <div class="title"><div class="pull-right"><button class="btn btn-xs btn-success live pull-left" id="edit-action" data-attribute="{{ $sujets->id }}"><span class="glyphicon glyphicon-edit"></span></button></div><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div>
                                                            <div class="content">{!! $sujets->action !!}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="text-center"><button class="btn btn-xs btn-warning btn-tree" id="add-sujet" data-attribute="{{ $reunions->id }}"><span class="glyphicon glyphicon-plus"></span></button></div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-xs btn-warning live" type="button" data-toggle="tooltip" data-placement="bottom" title="Version imprimable"><span class="glyphicon glyphicon-print"></span></button>
                        </div>

                        <div class="body">
                            <div class="name">{{ $reunions->sujet }}</div>
                            <div class="subjects">
                                <div class="text-center">
                                    <div class="date">Mercredi 10 Janvier 2016 à 12h00</div>
                                </div>

                                <li type="button" data-toggle="collapse" data-target="#collapseID" aria-expanded="false" aria-controls="collapseID">Sujet abordé</li>
                                <div class="collapse details-collapse" id="collapseID">
                                    <div class="details">
                                        <div class="title"><span class="glyphicon glyphicon-chevron-right"></span> Observations</div>
                                        <div class="content">
                                            Lorem ipsum dolor sit amet
                                        </div>
                                    </div>

                                    <div class="details">
                                        <div class="title"><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div>
                                        <div class="content">
                                            Lorem ipsum dolor sit amet
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="foot">
                            <button class="btn btn-xs btn-success live" data-attribute="1" id="participants" type="button" data-toggle="popover" title="Liste des participants" data-html="true"><span class="glyphicon glyphicon-user"></span></button>
                        </div>
                    </div>
            </div>
                @endforeach
        </div>
    </div>
@endsection
