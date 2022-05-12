<?php

if (!function_exists('isRole')) {
    /**
     * @param $role
     * @return bool
     */
    function isRole($role): bool
    {
        return auth()->user()->role === $role;
    }
}

if (!function_exists('arrat_to_object')){
    /**
     * @param $items
     * @return mixed|string
     */
    function arrat_to_object($items): mixed
    {
        $elem = "";
        foreach($items as $item){
            $elem = $item;
        }

        return $elem;
    }
}
