<?php

namespace Core;

/**
 * Pretty Var dump for development applications only.
 * MAKE SURE YOU COMPLETELY REMOVE THIS CLASS ON PRODUCTION MODE.
 *
 * Class Ip
 * @package Core
 *
 * @author Miranda Meza César
 * DATE November 07, 2018
 */
class StringNormalizer
{

    /**
     * This method is in charge of removing accents and incompatible character symbols either withing
     * some php code processes and/or external sistem's processing (eg. the database).
     *
     * @param $cadena
     * @return string
     *
     * @author Miranda Meza César
     * DATE November 07, 2018
     */
    function normalize ($string){
        $originals = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modified = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($originals), $modified);
        $string = strtolower($string);
        return utf8_encode($string);
    }
}
