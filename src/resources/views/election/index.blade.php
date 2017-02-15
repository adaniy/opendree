@extends('template')

@section('head')
    Elections
@endsection

@section('content')
    <div id="election-module">
        <list></list>
    </div>

    <template id="list">
        <div class="elections col-md-12">
            {{-- Listes électorales --}}
            {{------------------------}}
            <div class="col-md-12">
                <div class="pull-right">
                    <button class="btn btn-xs btn-primary live no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></button> <button class="btn btn-xs btn-success live no-print" v-on:click="addData('vote')"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
                <h4>Inscriptions aux listes électorales par mois et année</h4>
                <div class="inner-table">
                    <table class="table table-hover table-striped">
                        <tr class="header">
                            <th>Année</th>
                            <th v-for="x in 12">@{{ x | month }}</th>
                            <th>Total</th>
                        </tr>

                        <tr v-for="year in years">
                            <td class="header">@{{ year.date | year }}</td>
                            <td v-for="x in 12"><nb-year-electoral v-bind:year="year.date | year" v-bind:month="x"></nb-year-electoral></td>
                            <td><total-year-electoral v-bind:year="year.date | year"></total-year-electoral></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-12">
                <h4>Mois de novembre</h4>
                <div class="inner-table">
                    <table class="table table-hover table-striped">
                        <tr class="header">
                            <th>Année</th>
                            <th v-for="x in 30">@{{ x }}</th>
                        </tr>

                        <tr v-for="year in years">
                            <td class="header">@{{ year.date | year }}</td>
                            <td v-for="x in 30"><nb-spec-electoral v-bind:year="year.date | year" v-bind:month="11" v-bind:day="x"></nb-spec-electoral></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-12">
                <h4>Mois de décembre</h4>
                <div class="inner-table">
                    <table class="table table-hover table-striped">
                        <tr class="header">
                            <th>Année</th>
                            <th v-for="x in 31">@{{ x }}</th>
                        </tr>

                        <tr v-for="year in years">
                            <td class="header">@{{ year.date | year }}</td>
                            <td v-for="x in 31"><nb-spec-electoral v-bind:year="year.date | year" v-bind:month="12" v-bind:day="x"></nb-spec-electoral></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Recensements --}}
            {{------------------}}
            <div class="col-md-12">
                <hr />
                <div class="pull-right">
                    <button class="btn btn-xs btn-success live no-print" v-on:click="addData('recensement')"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
                <h4>Inscriptions aux recensements par mois et année</h4>
                <div class="inner-table">
                    <table class="table table-hover table-striped">
                        <tr class="header">
                            <th>Année</th>
                            <th v-for="x in 12">@{{ x | month }}</th>
                            <th>Total</th>
                        </tr>

                        <tr v-for="year in years">
                            <td class="header">@{{ year.date | year }}</td>
                            <td v-for="x in 12"><nb-year-recensement v-bind:year="year.date | year" v-bind:month="x"></nb-year-recensement></td>
                            <td><total-year-recensement v-bind:year="year.date | year"></total-year-recensement></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </template>

    {{-- sous-components des données --}}
    <template id="total-year-electoral">
        <div>
            @{{ nb }}
        </div>
    </template>

    <template id="nb-year-electoral">
        <div>
            @{{ nb }}
        </div>
    </template>

    <template id="nb-spec-electoral">
        <div>
            @{{ nb }}
        </div>
    </template>

    <template id="total-year-recensement">
        <div>
            @{{ nb }}
        </div>
    </template>

    <template id="nb-year-recensement">
        <div>
            @{{ nb }}
        </div>
    </template>
@endsection
