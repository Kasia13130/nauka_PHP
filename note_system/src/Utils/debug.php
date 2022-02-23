<?php

declare(strict_types=1);                // wlaczenie scislego typowania

error_reporting(E_ALL);                 // wyswietlenie wszystkich bledow ktore wystapia w kodzie
ini_set('display_errors', '1');           // wlaczenie wyswietlania bledow; ta i powyzsza funkcja musza byc zawsze razem

// metoda debugujaca, potrzebna do dewelopowania

function debuging($data)
{
    echo '<br/><div 
        style="
            display: inline-block;
            padding: 0 10px;
            border: 1px dotted gray;
            background: lightgrey
            "
    >
    <pre>';
    print_r($data);
    echo '</pre>
    </div>
    <br/>';
}