<?php

if (!function_exists('day_format')) {

    function day_format($day) {
        switch ($day) {
            case 0 : $day = "Minggu";
                return $day;
                break;
            case 1 : $day = "Senin";
                return $day;
                break;
            case 2 : $day = "Selasa";
                return $day;
                break;
            case 3 : $day = "Rabu";
                return $day;
                break;
            case 4 : $day = "Kamis";
                return $day;
                break;
            case 5 : $day = "Jum'at";
                return $day;
                break;
            case 6 : $day = "Sabtu";
                return $day;
                break;
        }
    }

}
if (!function_exists('month_format')) {

    function month_format($month_format) {
        switch ($month_format) :
            case 1 : $month_format = " Januari";
                return $month_format;
                break;
            case 2 : $month_format = " Februari";
                return $month_format;
                break;
            case 3 : $month_format = " Maret";
                return $month_format;
                break;
            case 4 : $month_format = " April";
                return $month_format;
                break;
            case 5 : $month_format = " Mei";
                return $month_format;
                break;
            case 6 : $month_format = " Juni";
                return $month_format;
                break;
            case 7 : $month_format = " Juli";
                return $month_format;
                break;
            case 8 : $month_format = " Agustus";
                return $month_format;
                break;
            case 9 : $month_format = " September";
                return $month_format;
                break;
            case 01 : $month_format = " Januari";
                return $month_format;
                break;
            case 02 : $month_format = " Februari";
                return $month_format;
                break;
            case 03 : $month_format = " Maret";
                return $month_format;
                break;
            case 04 : $month_format = " April";
                return $month_format;
                break;
            case 05 : $month_format = " Mei";
                return $month_format;
                break;
            case 06 : $month_format = " Juni";
                return $month_format;
                break;
            case 07 : $month_format = " Juli";
                return $month_format;
                break;
            case 08 : $month_format = " Agustus";
                return $month_format;
                break;
            case 09 : $month_format = " September";
                return $month_format;
                break;
            case 10 : $month_format = " Oktober";
                return $month_format;
                break;
            case 11 : $month_format = " November";
                return $month_format;
                break;
            case 12 : $month_format = " Desember";
                return $month_format;
                break;
        endswitch;
    }

}
if (!function_exists('date_now_format')) {

    function date_now_format() {
        $day_sekarang = day_format(date("w"));
        $bln_sekarang = month_format(date("m"));
        return $day_sekarang . ", " . date("d") . $bln_sekarang . date(" Y");
    }

}

if (!function_exists('date_format_indo_tgl')) {

    function date_format_indo_tgl($tanggal) {
        $day = date("d", strtotime($tanggal));
        $month_format = date("m", strtotime($tanggal));
        $year_format = date("Y", strtotime($tanggal));
        return $day . " " . month_format($month_format) . " $year_format";
    }

}

if (!function_exists('date_format_indo')) {

    function date_format_indo($tanggal) {
        $day_sekarang = day_format(date("w", strtotime($tanggal)));
        $day = date("d", strtotime($tanggal));
        $month_format = date("m", strtotime($tanggal));
        $year_format = date("Y", strtotime($tanggal));
        return $day_sekarang . ", " . $day . " " . month_format($month_format) . " $year_format";
    }

}

if (!function_exists('date_format_indo_br')) {

    function date_format_indo_br($tanggal) {
        $day_sekarang = day_format(date("w", strtotime($tanggal)));
        $day = date("d", strtotime($tanggal));
        $month_format = date("m", strtotime($tanggal));
        $year_format = date("Y", strtotime($tanggal));
        return $day_sekarang . "<br/>" . $day . " " . month_format($month_format) . " $year_format";
    }

}
