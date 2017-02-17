<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use File;
use Carbon\Carbon;

use App\Action;
use App\Reunion;
use App\Election;

class NotifyController extends Controller
{
    /** interval pour le lancement des notifications, doit être synchronisé avec la recoloration des actions dans la liste des actions */
    protected $rate = 120;
    protected $days = 31;

    public function ajax()
    {
        // conversion
        foreach(Election::get() as $elections) {
            /*            $date = Carbon::createFromFormat('d/m/Y', $elections->created_at);

                          $dateNew = $date->format('Y').'-'.$date->format('m').'-'.$date->format('d').' 00:00:00';

            Election::where('id', $elections->id)->update([
                "created_at" => Carbon::now()
                ]);*/
        }

        /** Si une action planifiée a l'alerte enclenchée et qu'elle arrive à date butoir */
        if(Action::where([
            ['alert', 1],
            ['date_butoir', '<=', Carbon::now()->addDays($this->days)]
        ])->count() > 0) {
            if(File::exists(storage_path("app/notify.txt"))) {
                /** Si le fichier des notifications existe ... */
                $date = Carbon::parse(Storage::get("notify.txt"));

                if($date->diffInMinutes(Carbon::now()) >= $this->rate) {
                    /** Si ça fait plus de x minutes, on modifie le fichier, et on envoie une notification */
                    Storage::disk("local")->put("notify.txt", Carbon::now());

                    return [
                        "nb" => $date->diffInSeconds(Carbon::now()),
                        "notify" => "notify"
                    ];
                } else {
                    /** Sinon */
                    return [
                        "nb" => $date->diffInSeconds(Carbon::now()),
                        "notify" => "nope"
                    ];
                }
            } else {
                /** Sinon... */
                Storage::disk("local")->put("notify.txt", Carbon::now());

                return [
                    "nb" => 0,
                    "notify" => "nope"
                ];
            }
        } else {
            return [
                "nb" => 0,
                "notify" => "nope"
            ];
        }
    }
}
