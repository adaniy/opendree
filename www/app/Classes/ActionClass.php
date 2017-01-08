<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Action;

class ActionClass
{
	public function insert(Request $request)
	{
		$nom = $request->input('nom');
		$alert = $request->input('alert');
		$alertStart = $request->input('alertStart');
		$realise = $request->input('realise');
		$date_creation = $request->input('date_creation');
		$date_butoire = $request->input('date_butoire');
		$date_realisation = $request->input('date_realisation');

		// On empêche de décocher "réalisé" tout en laissant une date de réalisation, et inversement
		if($realise == 0 AND !empty($date_realisation)) {
			return back()->with("erreur", "Lorsque l'action n'a pas été réalisée, il ne faut pas remplir de date de réalisation.")->withInput();
		} elseif($realise == 1 AND empty($date_realisation)) {
			return back()->with("erreur", "Lorsque l'action a été réalisée, il faut remplir une date de réalisation.")->withInput();
		} else {
			$action = new Action;
			$action->nom = $nom;
			$action->alert = $alert;
			$action->alertStart = $alertStart;
			$action->realise = $realise;
			$action->date_creation = $date_creation;
			$action->date_butoire = $date_butoire;
			$action->date_realisation = $date_realisation;

			if($action->save()) {
				return redirect('/')->with("valide", "L'action a bien été ajoutée.");
			} else {
				return back()->with("erreur", "L'action n'a pas pu être ajoutée.")->withInput();
			}	
		}
	}

	public function update($id, Request $request)
	{
		$nom = $request->input('nom');
		$alert = $request->input('alert');
		$alertStart = $request->input('alertStart');
		$realise = $request->input('realise');
		$date_creation = $request->input('date_creation');
		$date_butoire = $request->input('date_butoire');
		$date_realisation = $request->input('date_realisation');

		// On empêche de décocher "réalisé" tout en laissant une date de réalisation, et inversement
		if($realise == 0 AND !empty($date_realisation)) {
			return back()->with("erreur", "Lorsque l'action n'a pas été réalisée, il ne faut pas remplir de date de réalisation.")->withInput();
		} elseif($realise == 1 AND empty($date_realisation)) {
			return back()->with("erreur", "Lorsque l'action a été réalisée, il faut remplir une date de réalisation.")->withInput();
		} else {
			$action = new Action;

			if($action->where('id', $id)
				   ->update([
				   	'nom' => $nom,
				   	'alert' => $alert,
				   	'alertStart' => $alertStart,
				   	'realise' => $realise,
				   	'date_creation' => $date_creation,
				   	'date_butoire' => $date_butoire,
				   	'date_realisation' => $date_realisation,
			])) {
				return redirect('/')->with("valide", "L'action a bien été modifiée.");
			} else {
				return back()->with("erreur", "L'action n'a pas pu être modifiée.")->withInput();
			}
		}
	}

	public function delete($id)
	{
		$action = new Action;

		$action->find($id)->delete();
		return back()->with("valide", "L'action a bien été supprimée.");
	}

	// Donne la différence en jour de l'action
	public function diffDays($date)
	{
		$now = Carbon::now();
		$dateDiff = Carbon::createFromFormat("d/m/Y",$date);

		return $dateDiff->diffInDays($now);
	}

	// Donne la différence en jour de l'action
	public function diffMonths($date)
	{
		$now = Carbon::now();
		$dateDiff = Carbon::createFromFormat("d/m/Y",$date);

		return $dateDiff->diffInMonths($now);
	}

	// Donne la différence en jour de l'action
	public function diffYears($date)
	{
		$now = Carbon::now();
		$dateDiff = Carbon::createFromFormat("d/m/Y", $date);

		return $dateDiff->diffInYears($now);
	}

	// Détecte si une action a une alerte enclenchable, si oui, retourne un script Javascript d'alerte basique.
	public function canAlert()
	{
		$action = new Action();
		$now = Carbon::now();
		$nb = 0;

		foreach($action->get() as $actions) {
			if(Carbon::createFromFormat("d/m/Y", $actions->date_butoire)->diffInDays($now) <= $actions->alertStart && $actions->alert == 1) {
				$nb++;
			}
		}

		// Si au moins 1 alerte est enclenchable, alors on peut afficher l'alerte, sinon rien
		if($nb > 0) {
			return "<script>self.alert(\"GDMC : une action ou plus arrive à la date butoire sans avoir été réalisée. Ouvrez le gestionnaire des actions pour voir le ou lesquelles.\")</script>";
		} else {
			return "";
		}
	}

	// Même chose qu'au-dessus, mais ne retourne qu'un 1 ou 0, afin d'effectuer des vérifications
	public function canAlertBoolean($id)
	{
		$action = new Action();
		$now = Carbon::now();

		if(Carbon::createFromFormat("d/m/Y", $action->find($id)->date_butoire)->diffInDays($now) <= $action->find($id)->alertStart && $action->find($id)->alert == 1) {
			return 1;
		} else {
			return 0;
		}
	}
}