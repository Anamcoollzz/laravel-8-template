<?php

function get_options($length = 10)
{
    $options = [];
    foreach (range(1, $length) as $number) {
        $options['Option ' . $number] = 'Option ' . $number;
    }
    return $options;
}
