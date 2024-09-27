<?php

/**
 * Dump and die function for debugging.
 *
 * @param mixed $data The data to be dumped.
 * @param bool $exit Whether to exit after dumping the data.
 * @return void
 */
function dd($data, $exit = true)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}
