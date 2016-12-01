<?php
namespace App\Classes;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Reunion;
use App\ReunionParticipant;
use App\ReunionSujet;

class ReunionClass
{
	public function nbParticipant($id)
	{
		$reunionParticipant = new ReunionParticipant();

		return $reunionParticipant->where('reunion_id', $id)->count();
	}

	public function insert($request)
	{
		$sujet = $request->input('sujet');
		$date = $request->input('date');
		$date_prochain = $request->input('date_prochain');

		$reunion = new Reunion();
		$reunion->sujet = $sujet;
		$reunion->date = $date;
		$reunion->date_prochain = $date_prochain;
		if($reunion->save()) {
			return redirect('reunion')->with('valide', "La réunion a bien été créée.");
		} else {
			return redirect('reunion')->with('erreur', "La réunion n'a pas pu être créée.");
		}
	}

	public function edit($request, $id)
	{
		$sujet = $request->input('sujet');
		$date = $request->input('date');
		$date_prochain = $request->input('date_prochain');

		$reunion = new Reunion();

		if($reunion->where('id', $id)->update([
			'sujet' => $sujet,
			'date' => $date,
			'date_prochain' => $date_prochain
		])) {
			return redirect('reunion')->with('valide', "La réunion a bien été modifiée.");
		} else {
			return redirect('reunion')->with('erreur', "La réunion n'a pas pu être modifiée.");
		}
	}

	public function delete($id)
	{
		$reunion= new Reunion();
		$reunion->find($id)->delete();

		return back()->with('valide', "La participant a bien été supprimée.");
	}

	public function deleteParticipant($id)
	{
		$reunionParticipant = new ReunionParticipant();
		$reunionParticipant->find($id)->delete();

		return back()->with('valide', "Le participant a bien été supprimé.");
	}

	public function deleteSujet($id)
	{
		$reunionSujet = new ReunionSujet();
		$reunionSujet->find($id)->delete();

		return back()->with('valide', "Le sujet a bien été supprimé.");
	}

	public function insertSujet($request)
	{
		$sujet = $request->input('sujet');
		$observation = $request->input('observation');
		$action = $request->input('action');

		$reunionSujet = new ReunionSujet();
		$reunionSujet->reunion_id = $request->id;
		$reunionSujet->sujet = $sujet;
		$reunionSujet->observation = $observation;
		$reunionSujet->action = $action;
		if($reunionSujet->save()) {
			return redirect('reunion/'.$request->id)->with('valide', "Le sujet de réunion a bien été créé.");
		} else {
			return redirect('reunion/'.$request->id)->with('erreur', "Le sujet de réunion n'a pas pu être créé.");
		}
	}

	public function editSujet($request, $id)
	{
		$sujet = $request->input('sujet');
		$observation = $request->input('observation');
		$action = $request->input('action');

		$reunionSujet = new ReunionSujet();

		if($reunionSujet->where('id', $id)->update([
			'sujet' => $sujet,
			'observation' => $observation,
			'action' => $action
		])) {
			return redirect('reunion/'.$reunionSujet->find($id)->reunion_id)->with('valide', "Le sujet de réunion a bien été modifié.");
		} else {
			return redirect('reunion/'.$reunionSujet->find($id)->reunion_id)->with('erreur', "Le sujet de réunion n'a pas pu être modifié.");
		}
	}

	public function insertParticipant($request)
	{
		$nom = $request->input('nom');
		$type = $request->input('type');

		$reunionParticipant = new ReunionParticipant();
		$reunionParticipant->reunion_id = $request->id;
		$reunionParticipant->nom = $nom;
		$reunionParticipant->type = $type;
		if($reunionParticipant->save()) {
			return redirect('reunion/'.$request->id)->with('valide', "Le participant a bien été ajouté.");
		} else {
			return redirect('reunion/'.$request->id)->with('erreur', "Le participant n'a pas pu être ajouté.");
		}
	}
}