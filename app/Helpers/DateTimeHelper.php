<?php

function time_since($waktu)
{
    $original = strtotime($waktu);
    $chunks = array(
        array(60 * 60 * 24 * 365, 'tahun'),
        array(60 * 60 * 24 * 30, 'bulan'),
        array(60 * 60 * 24 * 7, 'minggu'),
        array(60 * 60 * 24, 'hari'),
        array(60 * 60, 'jam'),
        array(60, 'menit'),
    );

    $today = time();
    $since = $today - $original;

    if ($since > 604800) {
        $print = date("M j", $original);
        if ($since > 31536000) {
            $print .= ", " . date("Y", $original);
        }
        return $print;
    }

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];

        if (($count = floor($since / $seconds)) != 0) {
            break;
        }
    }

    $print = ($count == 1) ? '1 ' . $name : "$count {$name}";

    if ($count <= 10) {
        return 'baru saja';
    } else if ($count <= 60) {
        return $since . ' detik yang lalu';
    }

    return $print . ' yang lalu';
}

function namaBulan($b)
{
    $b = (int) $b;
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    return $bulan[$b];
}

function array_bulan()
{
    return ['1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
}

function array_year($start, $end)
{
    $years = [];
    foreach (range($start, $end) as $thn) {
        $years[$thn] = $thn;
    }
    return $years;
}
