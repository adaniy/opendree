<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/printable.css') }}" rel="stylesheet" type="text/css" media="screen, print">

        <title>OpenDREE</title>
    </head>
    <body class="landscape">
        <a href="/budget" class="no-print"><div class="wrap-return">
            retour
        </div></a>
        <div class="wrap budget">
            <h3><p class="text-center"><strong>Budget de l'année {{ $year }}</strong><br /></p></h3>
            <hr />
            <table class="table table-striped table-bordered table-tableau">
                <tr class="header">
                    <th class="col-md-2">Service</th>
                    <th class="col-md-2">Rubrique</th>
                    <th class="col-md-2">Budget voté</th>
                    <th class="col-md-2">Modification DM</th>
                    <th class="col-md-1">Total budget</th>
                    <th class="col-md-1">Utilisé</th>
                    <th class="col-md-1">Reste</th>
                    <th class="col-md-1">% utilisé</th>
                    <th class="col-md-1">Variation</th>
                </tr>

                @foreach($budget->where('date', $year)->orderBy('service_id', 'ASC')->get() as $budgets)
                    <tr>
                        {!! $budgetClass->rowSpan($budgets->id, $budgets->service_id, $year) !!}
                        <td>{{ $budgets->name }}</td>
                        <td>{{ number_format($budgets->vote, 2) }} €</td>
                        <td>{{ number_format($budgets->dm, 2) }} €</td>
                        <td>{{ number_format($budgetClass->getTotalRaw($budgets->id), 2) }} €</td>
                        <td>{{ number_format($budgetClass->getSpent($budgets->id), 2) }} €</td>
                        <td>{{ number_format($budgetClass->getRemaining($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id)), 2) }} €</td>
                        <td>{{ $budgetClass->getSpentPercentage($budgetClass->getTotalRaw($budgets->id), $budgetClass->getSpent($budgets->id)) }} %</td>
                        <td>{{ number_format($budgetClass->getVariation($budgets->dm, $budgets->vote), 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <a href="#" onclick="window.print()" class="no-print"><div class="wrap-print">
            imprimer
        </div></a>
    </body>
</html>
