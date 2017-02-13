@inject("actionClass", "App\Classes\ActionClass")
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/override.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <title>OpenDREE</title>

        @yield('meta')
    </head>
    <body>
        <nav class="header col-md-12 col-xs-12">
            <div class="title">
                <div class="name">OpenDREE</div><div class="separation"> <span class="glyphicon glyphicon-menu-right"></span> </div> <div class="module"> @yield('head') </div>
            </div>

            <div class="menu">
                <a href="{{ url('dashboard') }}">
                    <div class="modules @if(Request::segment(1) == "dashboard") active @endif">

                                <div class="top">
                        <span class="glyphicon glyphicon-dashboard"></span>
                    </div>
                    <div class="bottom">
                        tableau de bord
                    </div>

            </div>
                </a>
                <a href="{{ url('budget') }}">
                    <div class="modules @if(Request::segment(1) == "budget") active @endif">

                                <div class="top">
                        <span class="glyphicon glyphicon-credit-card"></span>
                    </div>
                    <div class="bottom">
                        budget
                    </div>
            </div>
                </a>
                <a href="{{ url('action') }}">
                    <div class="modules @if(Request::segment(1) == "action") active @endif">

                                <div class="top">
                        <span class="glyphicon glyphicon-list-alt"></span>
                    </div>
                    <div class="bottom">
                        actions
                    </div>
            </div>
                </a>
                <a href="{{ url('reunion') }}">
                    <div class="modules @if(Request::segment(1) == "reunion") active @endif">

                                <div class="top">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                    <div class="bottom">
                        réunions
                    </div>

            </div>
                </a>
                <a href="{{ url('election') }}">
                    <div class="modules @if(Request::segment(1) == "election") active @endif">

                                <div class="top">
                        <span class="glyphicon glyphicon-bullhorn"></span>
                    </div>
                    <div class="bottom">
                        élections
                    </div>

            </div>
                </a>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @if(count($errors) > 0)
                    <div class="bs-errors" data-example-id="dismissible-alert-css">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            &                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Attention : </strong><br />
                            @foreach ($errors->all() as $errorsGet)
                                <li>{{ $errorsGet }}</li>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(session('valide'))
                    <div class="bs-errors" data-example-id="dismissible-alert-css">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Succès : </strong><br />
                            {{ session('valide') }}
                        </div>
                    </div>
                @endif

                @if(session('erreur'))
                    <div class="bs-errors" data-example-id="dismissible-alert-css">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Attention : </strong><br />
                            {{ session('erreur') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
        {{-- on charge jquery à l'aide de node.JS --}}
	<script src="{{ asset('js/axios.min.js') }}"></script>
        <script src="{{ asset('js/jquery-1.11.3.min.js') }}" onload="$ = jQuery = module.exports;"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('js/vue.js') }}"></script>
        <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
        <script src="{{ asset('js/repository.js') }}"></script>

        {{-- on ne permet le chargement des fonctions JS des statistiques uniquement dans la page concernée --}}
        @if(Request::segment(1) == "action")
            <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
            <script src="{{ asset("js/chart/utils.js") }}"></script>
            <script src="{{ asset("js/chart/action.js") }}"></script>
        @endif

        {{-- on ne permet le chargement des fonctions JS des budgets uniquement dans la page concernée --}}
        @if(Request::segment(1) == "budget")
            <script src="{{ asset("js/budget/gestion.js") }}"></script>
            <script src="{{ asset("js/budget/board.js") }}"></script>
        @endif

        {{-- on ne permet le chargement des fonctions JS des budgets uniquement dans la page concernée --}}
        @if(Request::segment(1) == "dashboard")
            <script src="{{ asset("js/dashboard/index.js") }}"></script>
            @if(is_numeric(Request::segment(2)) && empty(Request::segment(3)))
                <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
                <script src="{{ asset("js/chart/dashboard-year.js") }}"></script>
            @endif

            @if(empty(Request::segment(2) && empty(Request::segment(3))))
                <script src="{{ asset("js/Chart.bundle.min.js") }}"></script>
                <script src="{{ asset("js/chart/dashboard.js") }}"></script>
            @endif
        @endif

        @if(Request::segment(1) == "reunion")
            <script src="{{ asset("js/reunion.js") }}"></script>
        @endif
    </body>
</html>
