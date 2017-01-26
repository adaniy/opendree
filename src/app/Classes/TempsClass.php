<?php

namespace App\Classes;

use Carbon\Carbon;

class TempsClass
{
    public function diff($date)
    {
        $now = Carbon::now();
		$dateDiff = Carbon::createFromFormat("Y-m-d H:i:s", $date);
        $diff = $dateDiff->diffInDays($now);

        if($diff == 0) {
            return $diff;
        } elseif($dateDiff < $now) {
            return '- '.$diff;
        } else {
            return $diff;
        }
    }

    public function convert($date) // convertie une date en format "simple" vers le format base de donnée.
    {
        Carbon::setLocale('fr');
        $init = Carbon::createFromFormat('d/m/Y', $date);

        $d = $init->format('d');
        $m = $init->format('m');
        $Y = $init->format('Y');

        return $Y.'-'.$m.'-'.$d.' 00:00:00';
    }

    public function convert2($date) // convertie une date en format "simple" vers le format base de donnée.
    {
        Carbon::setLocale('fr');
        $init = Carbon::createFromFormat('d/m/Y', $date);

        $d = $init->format('d');
        $m = $init->format('m');
        $Y = $init->format('Y');

        return $Y.'-'.$m.'-'.$d.' 00:00:00';
    }

	public function parseDate($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('Y-m-d H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');


		return $jours.'/'.$mois.'/'.$annee;
	}

	public function parseDateTime($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('d/m/Y H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');

		$heures = $init->format('H');
		$minutes = $init->format('i');
		$secondes = $init->format('s');

		return $jours.'/'.$mois.'/'.$annee.' à '.$heures.':'.$minutes.':'.$secondes;
	}

	public function parseDateTime2($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('d/m/Y H:i:s', $date);

		$jours = $init->format('d');
		$mois = $init->format('m');
		$annee = $init->format('Y');

		$heures = $init->format('H');
		$minutes = $init->format('i');
		$secondes = $init->format('s');

		return $jours.'/'.$mois.'/'.$annee;
	}

	public function parseMois($month)
	{
		switch($month) {
        case 1:
            return "Janvier";
			break;

        case 2:
            return "Février";
			break;

        case 3:
            return "Mars";
			break;

        case 4:
            return "Avril";
			break;

        case 5:
            return "Mai";
			break;

        case 6:
            return "Juin";
			break;

        case 7:
            return "Juillet";
			break;

        case 8:
            return "Août";
			break;

        case 9:
            return "Septembre";
			break;

        case 10:
            return "Octobre";
			break;

        case 11:
            return "Novembre";
			break;

        case 12:
            return "Décembre";
			break;

        default:
            return "???";
			break;
		}
    }

    public function parseJour($dayOfWeek)
    {
        switch($dayOfWeek) {
        case 0:
            return "Dimanche";
			break;

        case 1:
            return "Lundi";
			break;

        case 2:
            return "Mardi";
			break;

        case 3:
            return "Mercredi";
			break;

        case 4:
            return "Jeudi";
			break;

        case 5:
            return "Vendredi";
			break;

        case 6:
            return "Samedi";
			break;

        default:
            return "???";
            break;
        }
	}
}
