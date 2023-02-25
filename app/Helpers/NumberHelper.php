<?php

function rp($number, $decimals = 0)
{
    return number_format($number, $decimals, ',', '.');
}

function dollar($number, $decimals = 0)
{
    return number_format($number, $decimals, '.', ',');
}

function idr($number, $decimals = 0)
{
    return rp($number, $decimals);
}
