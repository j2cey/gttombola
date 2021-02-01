<?php


namespace App\Traits\Data;


trait HasData
{
    function convert_bytes($val , $type_val , $type_wanted){
        $tab_val = array("o", "ko", "Mo", "Go", "To", "Po", "Eo");
        if (!(in_array($type_val, $tab_val) && in_array($type_wanted, $tab_val)))
            return 0;
        $tab = array_flip($tab_val);
        $diff = $tab[$type_val] - $tab[$type_wanted];
        if ($diff > 0)
            return ($val * pow(1024, $diff));
        if ($diff < 0)
            return ($val / pow(1024, -$diff));
        return ($val);
    }
}
