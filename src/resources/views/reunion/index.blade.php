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
                    <div class="buttons pull-right"><button class="btn btn-xs btn-success btn-tree" v-on:click="addReunion()">Ajouter une réunion</button></div>
                    <div class="display pull-right"><button class="btn btn-xs btn-default live"><span class="glyphicon glyphicon-th-large"></span></button> <button class="btn btn-xs btn-default live"><span class="glyphicon glyphicon-th-list"></span></button></div>
                    <div class="amount"><amount></amount></div>
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
                                        <div class="name editable" v-on:click="editReunion(reunion)">@{{ reunion.sujet }}</div>
                                        <div class="subjects">
                                            <div class="col-md-6">
                                                <div class="text-left">
                                                    <div class="date">Date de la réunion</div>
                                                    <div class="date editable">@{{ reunion.date | moment }}</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="text-right">
                                                    <div class="date">Date de la prochaine réunion</div>
                                                    <div class="date editable">Aucune</div>
                                                </div>
                                            </div>
                                            <br />
                                            <hr />
                                            <subjects v-bind:parent="reunion.id"></subjects>
                                            <hr />
                                            <div class="text-center"><button v-on:click="addSubject(reunion)" class="btn btn-xs btn-warning live"><span class="glyphicon glyphicon-plus-sign"></span></button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </template>

    <template id="subject-template">
        <div>
            <div v-for="subject in subjects">
                <div class="pull-right">
                    <button class="btn btn-xs btn-default live-medium" type="button" data-toggle="collapse" v-bind:data-target="'#collapse'+subject.id" aria-expanded="false" v-bind:aria-controls="'collapse'+subject.id"><span class="glyphicon glyphicon-chevron-down"></span></button>
                </div>

                <div class="pull-left">
                    <button v-on:click="deleteReunionSubject(subject)" class="btn btn-xs btn-danger live-medium"><span class="glyphicon glyphicon-remove"></span></button>&nbsp;
                </div>
                <li class="sujets editable" v-on:click="editReunionSubject(subject)">@{{ subject.sujet }}</li>

                <div class="collapse" v-bind:id="'collapse'+subject.id">
                    <div class="details">
                        <div class="title"><span class="glyphicon glyphicon-chevron-right"></span> Observations</div>
                        <div class="content editable" v-on:click="editReunionObservation(subject)" v-html="nl2br(escapeHtml(subject.observation))"></div>
                    </div>

                    <div class="details">
                        <div class="title"><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div>
                        <div class="content editable" v-on:click="editReunionAction(subject)" v-html="nl2br(escapeHtml(subject.action))"></div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection
