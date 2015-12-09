<?php

class Engine_Utilities_Functions {

    private static $_instance = null;

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Engine_Utilities_Functions();
        return self::$_instance;
    }

    public function filterArray($searchKey, $searchValue, $array) {
        if ($searchValue != "" && $searchKey != "") {
            $filter = function($array) use($searchValue, $searchKey) {
                if ($array[$searchKey]) {
                    return $array[$searchKey] == $searchValue;
                }
            };
            $filtered = array_filter($array, $filter);
            return $filtered;
        }
    }
    
     public function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

}

?>
