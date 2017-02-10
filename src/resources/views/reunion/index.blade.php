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
            <div class="col-md-12">
                <div class="top">
                    <div class="buttons pull-right"><button class="btn btn-xs btn-success btn-tree" v-on:click="addReunion()">Ajouter une réunion</button></div>
                    <div class="display pull-right"><div class="pagination-number text-muted"><i v-if="this.loading" class="fa fa-spinner fa-spin fa-6x fa-fw"></i> <button class="btn btn-xs btn-primary btn-page" v-if="this.page.actual - 2 >= 1" v-on:click="firstPage()"><span class="glyphicon glyphicon-step-backward"></span></button> <button class="btn btn-xs btn-primary btn-page" v-if="this.page.actual - 1 >= 1" v-on:click="previousPage()"><span class="glyphicon glyphicon-chevron-left"></span></button> <strong>@{{ this.page.actual }}</strong> sur @{{ this.page.max }} <button class="btn btn-xs btn-primary btn-page" v-if="this.page.actual + 1 <= this.page.max" v-on:click="nextPage()"><span class="glyphicon glyphicon-chevron-right"></span></button> <button class="btn btn-xs btn-primary btn-page" v-if="this.page.actual + 2 <= this.page.max" v-on:click="lastPage()"><span class="glyphicon glyphicon-step-forward"></span></button></div></div>
                    <div class="amount"><amount></amount></div>
                    <div class="search">
                        <button v-if="!search" class="btn btn-xs btn-primary btn-tree" v-on:click="getReunions()" @click="search = !search"><span class="glyphicon glyphicon-search"></span> recherche</button>
                        <button v-else class="btn btn-xs btn-warning btn-tree" v-on:click="getReunions()" @click="search = !search"><span class="glyphicon glyphicon-search"></span> recherche</button>
                        <form class="form-search form-inline" v-if="search">
                            <div class="form-group">
                                <input type="text" name="nom" class="form-control" placeholder="Nom de la réunion" v-on:keydown="getReunions()" v-model="regexp.nom" />
                            </div>

                            <div class="form-group">
                                <input type="text" name="date" class="form-control" placeholder="Date de la réunion" v-on:keydown="getReunions()" v-model="regexp.date" />
                                @{{ regexp.date }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="bottom">
                    <div>
                        <div v-for="reunion in reunions">
                            <div class="col-md-4">
                                <div class="col-md-12 block">
                                    <div class="head">
                                        <div class="pull-right">
                                            <button v-on:click="deleteReunion(reunion)" class="btn btn-xs btn-danger live" id="delete-reunion"><span class="glyphicon glyphicon-remove"></span></button>
                                        </div>

                                        <button class="btn btn-xs btn-warning live" type="button" data-toggle="tooltip" data-placement="bottom" title="Version imprimable"><span class="glyphicon glyphicon-print"></span></button>
                                    </div>
                                    <div class="body">
                                        <div class="name editable" v-on:click="editReunion(reunion)">#@{{ reunion.id }} - @{{ reunion.sujet }}</div>
                                        <div class="subjects">
                                            <div class="col-md-6">
                                                <div class="text-left">
                                                    <div class="date">Date de la réunion</div>
                                                    <div class="date editable" v-on:click="editDateReunion(reunion)">@{{ reunion.date | moment }}</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="text-right">
                                                    <div class="date">Date de la prochaine réunion</div>
                                                    <div class="date"><span v-if="reunion.date_prochain"><span class="glyphicon glyphicon-remove editable" v-on:click="nullifyDateProchain(reunion)"></span> <span class="editable" v-on:click="editDateProchainReunion(reunion)">@{{ reunion.date_prochain | moment }}</span></span><span class="editable" v-on:click="editDateProchainReunion(reunion)" v-else>aucune</span></div>
                                                </div>
                                            </div>
                                            <br />
                                            <hr />

                                            <participants v-bind:parent="reunion.id"></participants>


                                            <div class="col-md-12">
                                                <hr />
                                                <subjects v-bind:parent="reunion.id"></subjects>
                                                <hr />
                                            </div>
                                            <div class="col-md-12">

                                                <br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </template>

    <template id="participant-template">
        <div>
            <div class="col-md-6">
                <div class="participant-title">Présent(s)</div>
                <div v-if="presents.length == 0">
                    <strong>Aucune donnée.</strong>
                </div>
                <div v-for="present in presents">
                    <li class="participant"><span class="glyphicon glyphicon-remove editable" v-on:click="deleteParticipant(present)"></span> @{{ present.nom }}</li>
                </div>
            </div>

            <div class="col-md-6">
                <div class="participant-title">Absent(s) excusé(s)</div>
                <div v-if="absents.length == 0">
                    <strong>Aucune donnée.</strong>
                </div>
                <div v-for="absent in absents">
                    <li class="participant"><span class="glyphicon glyphicon-remove editable" v-on:click="deleteParticipant(absent)"></span> @{{ absent.nom }}</li>
                </div>
            </div>

            <div class="col-md-12">
                <br />
                <div class="participant-title">Secrétaire(s)</div>
                <div v-if="secretaires.length == 0">
                    <strong>Aucune donnée.</strong>
                </div>
                <div v-for="secretaire in secretaires">
                    <li class="participant"><span class="glyphicon glyphicon-remove editable" v-on:click="deleteParticipant(secretaire)"></span> @{{ secretaire.nom }}</li>
                </div>
            </div>

            <div class="col-md-12">
                <hr />
                <form class="form" v-on:submit.prevent="addParticipant">
                    <input type="hidden" name="id" v-bind:value="parent" />
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control" v-model="nom" name="nom" placeholder="Nom du participant" />
                    </div>

                    <div class="form-group col-md-5">
                        <select name="type" class="form-control" v-model="type">
                            <option value="present">Présent</option>
                            <option value="absent">Absent</option>
                            <option value="secretaire">Secrétaire</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12 text-right">
                        <input type="submit" class="btn btn-xs btn-success" value="Insérer" />
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template id="subject-template">
        <div>
            <div v-if="subjects.length == 0">
                <strong>Il n'y a aucun sujet débattu dans cette réunion, pour l'instant.</strong>
            </div>
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
            <div class="text-center"><button v-on:click="addSubject(subjects)" class="btn btn-xs btn-warning live"><span class="glyphicon glyphicon-plus-sign"></span></button></div>
        </div>
    </template>
@endsection
