<?php

namespace App\Classes;

use Carbon\Carbon;

class TempsClass
{

	public function parseDate($date)
	{
		Carbon::setLocale('fr');
		$init = Carbon::createFromFormat('d/m/Y', $date);

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
}
