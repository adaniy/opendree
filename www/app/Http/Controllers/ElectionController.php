<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ElectionRequest;

use App\Election;

use Carbon\Carbon;
use DB;

class ElectionController extends Controller
{
    public function index()
    {
        return view('election.index');
    }

    public function printable($id)
    {
        return view('election.printable');
    }

    public function add(ElectionRequest $request)
    {
        $type = $request->get("type");
        $date = $request->get("date");
        $nb = $request->get("nb");
        $election = new Election;

        $election->type = $type;
        $election->date = $date;
        $election->nb = $nb;

        $election->save();
    }

    public function getYears()
    {
        return Election::groupBy(DB::raw('date(date, "start of year")'))->get();
    }

    public function getTotalElectoralYear($year)
    {
        $resultat = 0;

        foreach(Election::whereYear('date', $year)->where('type', 'vote')->get() as $totals) {
            $resultat += $totals->nb;
        }

        return $resultat;
    }

    public function getNbElectoralYearMonth($year, $month)
    {
        $resultat = 0;

        foreach(Election::whereYear('date', $year)->whereMonth('date', Carbon::parse(Carbon::create($year, $month, 1))->format("m"))->where('type', 'vote')->get() as $totals) {
            $resultat += $totals->nb;
        }

        return $resultat;
    }

    public function getNbSpec($year, $month, $day)
    {
        $resultat = 0;
        $date = $year.'-'.$month.'-'.$day;
        foreach(Election::whereDate('date', $date)->where('type', 'vote')->get() as $totals) {
            $resultat += $totals->nb;
        }

        return $resultat;
    }

    public function getTotalRecensementYear($year)
    {
        $resultat = 0;

        foreach(Election::whereYear('date', $year)->where('type', 'recensement')->get() as $totals) {
            $resultat += $totals->nb;
        }

        return $resultat;
    }

    public function getNbRecensementYearMonth($year, $month)
    {
        $resultat = 0;

        foreach(Election::whereYear('date', $year)->whereMonth('date', Carbon::parse(Carbon::create($year, $month, 1))->format("m"))->where('type', 'recensement')->get() as $totals) {
            $resultat += $totals->nb;
        }

        return $resultat;
    }
}