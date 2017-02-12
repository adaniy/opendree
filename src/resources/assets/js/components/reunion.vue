<template>
    <div class="module-reunion">
        <div class="col-md-12 header">
            <div class="col-md-10 search">
                <div class="search-result vcenter">
                    64 résultat(s)
                </div>

                <div class="search-form">
                    <form class="form form-inline">

                        <div class="form-group form-search">
                            <input type="text" name="nom" class="form-control" placeholder="Sujet à rechercher..." />
                        </div>

                        <div class="form-group form-search">
                            <input type="text" name="date" class="form-control" placeholder="Date à rechercher..." />
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-2 options text-right">
                <div class="pagination">
                    <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-chevron-left"></span></button>
                    <div class="number"><strong>1</strong> sur 10</div>
                    <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-chevron-right"></span></button>
                </div>
            </div>
        </div>

        <div class="col-md-12 container">
            <!-- beginning of the reunion for loop -->
            <div class="col-md-4" v-for="(reunion, key) in reunions">
                <table class="block col-md-12">
                    <tbody>
                        <tr>
                            <td class="block-date">
                                <div class="pull-right">
                                    <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-print"></span></button>
                                    <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                </div>

                                <div class="editable">lundi 15 février 2016 à 18h16 - {{ test + 2 }}</div>
                            </td>
                        </tr>

                        <tr v-on:click="deployParticipant = !deployParticipant">
                            <td class="block-deployable">
                                <div class="category-title">
                                    <div class="pull-right">
                                        <div v-if="!deployParticipant">
                                            <span class="glyphicon glyphicon-chevron-down"></span>
                                        </div>
                                        <div v-else>
                                            <span class="glyphicon glyphicon-chevron-up"></span>
                                        </div>
                                    </div>

                                    Liste des participants
                                </div>
                            </td>
                        </tr>

                        <transition name="fade">
                            <tr v-if="deployParticipant">
                                <td class="block-deployed">
                                    <div class="col-md-6">
                                        <div class="category-participant">Présents</div>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="category-participant">Absents excusés</div>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                    </div>
                                    <div class="col-md-12">
                                        <br />

                                        <div class="category-participant">Secrétaires de séance</div>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                        <li><span class="glyphicon glyphicon-remove editable"></span> Lui ?!</li>
                                    </div>
                                    <div class="col-md-12">
                                        <br />
                                        <div class="category-participant">Ajouter un participant</div>
                                        <br />
                                        <form class="form">
                                            <div class="form-group col-md-6 nopadding">
                                                <input type="text" name="nom" class="form-control" placeholder="Nom du participant" />
                                            </div>

                                            <div class="form-group col-md-4 nopadding">
                                                <select name="type" class="form-control">
                                                    <option value="">Test</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 padding">
                                                <input type="submit" class="btn btn-md btn-success" value="Insérer" />
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </transition>

                        <tr v-bind:class="{ id: reunion.id, deployDetails: false }" v-on:click="">

                            <td class="block-deployable">
                                <div class="category-title">
                                    <div class="pull-right">
                                        <div v-if="!deployDetails">
                                            <span class="glyphicon glyphicon-chevron-down"></span>
                                        </div>
                                        <div v-else>
                                            <span class="glyphicon glyphicon-chevron-up"></span>
                                        </div>
                                    </div>

                                    Sujet de la réunion {{ id }}
                                </div>
                            </td>
                        </tr>

                        <transition name="fade">
                            <tr v-if="deployDetails">
                                <td class="block-deployed">
                                    <div class="pull-right">
                                        <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-edit"></span></button>
                                        <button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                    <div class="category">
                                        <div class="category-title"><span class="glyphicon glyphicon-chevron-right"></span> Observations</div>
                                        <div class="editable">Il faudrait faire ci et cela :)</div>
                                    </div>

                                    <div class="category">
                                        <br />
                                        <div class="category-title"><span class="glyphicon glyphicon-chevron-right"></span> Actions à entreprendre</div>
                                        <div class="editable">Il faudrait faire ci et cela :)</div>
                                    </div>
                                </td>
                            </tr>
                        </transition>

                        <tr>
                            <td class="block-add">
                                <div class="col-md-12 text-center">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="block-prochain editable">Pas de réunion prochaine prévue</td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="key % 2 == 0" class="clearfix visible-md visible-lg visible-sm"></div>
            </div>
            <!-- end of the reunion for loop -->
        </div>
    </div>
    </div>
    <!--
         <button class="btn btn-md btn-primary" v-on:click="modalEditSubjectShow = !modalEditSubjectShow">Show modal !</button>
         <transition name="modal">
         <modalEditSubject v-if="modalEditSubjectShow" @close="modalEditSubjectShow = false"></modalEditSubject>
         </transition>
       -->
  </template>

<script>
    import ModalEditSubject from './modal/reunion/edit/subject.vue';
import Axios from 'axios';

export default {
    data () {
        return {
            modalEditSubjectShow: false,
            deployParticipant: false,
            reunions: [],
        }
    },
    components: {
        modalEditSubject: ModalEditSubject
    },
    created: function () {
        this.getReunions();
    },
    methods: {
        getReunions: function () {
            Axios.get('/axios/reunion/get/1')
                .then(function (response) {
                    this.reunions = response.data.reunions;
                    console.log(this.reunions);
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
                                                                                                                                              </script>
