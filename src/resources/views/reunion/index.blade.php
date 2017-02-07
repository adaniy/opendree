

@extends('template')

@section('head')
    Réunions
@endsection

@section('content')
    <div id="reunion-module">
        <list></list>
    </div>

    <template id="reunion-template">
        <div class="reunions">
            <hr />
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
                    <div>
                        <div v-for="reunion in reunions">
                            <div class="col-md-3">
                                <div class="col-md-12 block">
                                    <div class="head">
                                        <div class="pull-right">
                                            <button v-on:click="deleteReunion(reunion)" class="btn btn-xs btn-danger live" id="delete-reunion"><span class="glyphicon glyphicon-remove"></span></button>
                                        </div>

                                        <button class="btn btn-xs btn-warning live" type="button" data-toggle="tooltip" data-placement="bottom" title="Version imprimable"><span class="glyphicon glyphicon-print"></span></button>
                                    </div>
                                    <div class="body">
                                        <div class="name" v-on:click="editReunionSujet(reunion)">@{{ reunion.sujet }}</div>
                                        <div class="subjects">
                                            <div class="text-center">
                                                <div class="date">@{{ reunion.date | moment }}</div>
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
                        </div>
                    </div>
    </template>
@endsection
