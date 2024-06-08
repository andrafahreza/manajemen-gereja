<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function formatDate($date)
    {
        $date = date('Y-m-d H:i:s', strtotime($date));
        $month = array(
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        );

        $getDay = Carbon::parse($date)->format('l');

        $day = null;
        if ($getDay == "Sunday") {
            $day = "Minggu";
        } else if ($getDay == "Monday") {
            $day = "Senin";
        } else if ($getDay == "Tuesday") {
            $day = "Selasa";
        } else if ($getDay == "Wednesday") {
            $day = "Rabu";
        } else if ($getDay == "Thursday") {
            $day = "Kamis";
        } else if ($getDay == "Friday") {
            $day = "Jumat";
        } else if ($getDay == "Saturday") {
            $day = "Sabtu";
        }

        $d = date('d', strtotime($date));
        $m = date('m', strtotime($date));
        $y = date('Y', strtotime($date));
        $time = date('H:i', strtotime($date));

        foreach ($month as $kunci => $value) {
            if ($kunci + 1 == (int)$m) {
                return $day.", $d $value $y, $time WIB";
            }
        }

        return false;
    }
}
