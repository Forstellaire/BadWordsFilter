<?php
require "../vendor/autoload.php";

use BadWords\BadWordsFilter;

$filter = new BadWordsFilter();

//By default all the dictionnaries are selected (fr-FR / en-EN / es-ES etc...)
$string = "Je suis trop putain";
echo $filter->censureWords($string);

//You can select just one dictionnary
$string = "Je suis trop putain";
echo $filter->censureWords($string, 'fr-FR');
