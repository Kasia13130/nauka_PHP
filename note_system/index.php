<?php

declare(strict_types=1); 

namespace Note;                          // przestrzen (pudelko) dla nazw

// include - inkluduje plik ktory chcemy uzyc, czyli wczytanie pliku do kodu ponizej; przy probie 
//ponownego zainkludowania tego samego pliku zostanie wyswietlony fatalny blad o uniemozliwieniu redeklaracji funkcji debuging; jesli wywolany 
//zostanie dla pliku ktory nie istnieje to zostanie wyswietlony warning ale nie przerywa wykonania skryptu

// include_once - plik zostaniezaimportowany tylko raz; przy próbie ponownego inkludowania pliku, zawartosc tylko raz sie wyswietli/wykona

// require - jesli plik nie istnieje to otrzymamy fatal error i skrypt przestaje dzialac 

// require_once - przy ponownym uzyciu funkcji plik zostanie tylko raz zaimportowany
// require wymaga by plik istnial; natomiast include tego nie wymaga (nie przerwie dzialania skryptu, tylko zglosi warning)

require_once("src/Utils/debug.php");
require_once("src/View.php");


// zdefiniowanie stalej by moc zaladowac odpowiednie szablony stron
const DEFAULT_ACTION = 'noteList';

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$arrayViewParameters = [];

switch ($action)
{
    case 'createNote':
        $page = 'createNote';
        $noteCreated = false;

        if (!empty($_POST))
        {   
            $noteCreated = true;
            $arrayViewParameters = [
                'title' => $_POST['title'],
                'description' => $_POST['description']
            ];
        }
        $arrayViewParameters['created'] = $noteCreated;
        break;

    case 'showNote':
        $arrayViewParameters = [
            'title' => 'Utworzona notatka',
            'description' => 'Treść notatki'
        ];
        break;
        
    default:
        $page = 'noteList';
        $arrayViewParameters['resultListNotes'] = "wyświetlona lista notatek";
        break;
}   

$view->render($page, $arrayViewParameters);


// debuging($view);                                    // odwolanie sie do funkcji debugujacej pliku debug.php


    