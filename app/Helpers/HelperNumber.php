<?php
/*
Helper pour le Vendeur
*/


// convert HT to TTC
if (!function_exists('getTTC')) {
    function getTTC($prix_HT)
    {
        return number_format( ($prix_HT + $prix_HT * 0.2),2);
    }
}

// apply promotion
if (!function_exists('getPrixTaux')) {
    function getPrixTaux($prix, $taux)
    {
        return number_format( ($prix - $prix * $taux / 100),2);
    }
}

// apply promotion
if (!function_exists('getPrixTauxTTC')) {
    function getPrixTauxTTC($prix_HT, $taux)
    {
        $prix = ($prix_HT + $prix_HT * 0.2);
        return number_format( ($prix - $prix * $taux / 100),2);
    }
}


