!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css }}" rel="stylesheet">
        <title>OpenDREE</title>
    </head>
    <body>
        <nav class="header col-md-12 col-xs-12">
            <div class="title">
                <div class="name">OpenDREE</div><div class="separation"> <span class="glyphicon glyphicon-menu-right"></span> </div>
		<div class="module">module</div>
            </div>

            <div class="menu">
                <a href="dashboard">
                    <div class="modules">

                        <div class="top">
                            <span class="glyphicon glyphicon-dashboard"></span>
                        </div>
                        <div class="bottom">
                            tableau de bord
                        </div>

                    </div>
                </a>
                <a href="budget">
                    <div class="modules">

                        <div class="top">
                            <span class="glyphicon glyphicon-credit-card"></span>
                        </div>
                        <div class="bottom">
                            budget
                        </div>
                    </div>
                </a>
                <a href="action">
                    <div class="modules">

                        <div class="top">
                            <span class="glyphicon glyphicon-list-alt"></span>
                        </div>
                        <div class="bottom">
                            actions
                        </div>
                    </div>
                </a>
                <a href="reunion">
                    <div class="modules">

                        <div class="top">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                        <div class="bottom">
                            réunions
                        </div>

                    </div>
                </a>
                <a href="election">
                    <div class="modules">
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
                <reunion></reunion>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
    </html>
