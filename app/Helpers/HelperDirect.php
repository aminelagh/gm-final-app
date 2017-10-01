<?php
/*
Helper pour le adminController
*/


//pour les pop over
if (!function_exists('setPopOver')) {
    function setPopOver($title, $content)
    {
        return 'data-toggle="popover" data-placement="top" data-trigger="hover" title="' . $title . '" data-content="' . $content . '"';
    }
}

//pour les pop over
if (!function_exists('setPopOverDown')) {
    function setPopOverDown($title, $content)
    {
        return 'data-toggle="popover" data-placement="bottom" data-trigger="hover" title="' . $title . '" data-content="' . $content . '"';
    }
}


//navigation
if (!function_exists('setNavigation')) {
    function setNavigation($espace,$table,$id)
    {
        return '<nav aria-label="">
                <ul class="pager">
                    <li class="previous"><a
                                href="/'.$espace.'/'.$table.'/'.($id-1).'"><span
                                    aria-hidden="true">&larr;</span> précédent</a></li>
                    <li class="next"><a
                                href="/'.$espace.'/'.$table.'/'.($id+1).'"><span
                                    aria-hidden="true">&rarr;</span> suivant</a></li>

                </ul>
            </nav>';
    }
}


