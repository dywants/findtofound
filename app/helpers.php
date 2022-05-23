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

if(!function_exists('decode_image')){
    function decode_image($data){

        foreach(json_decode($data,true) as $item){
            return $item;
        }
    }
}

if (!function_exists('order_amount')){
    /**
     * @param $amount
     * @return float|int
     */
    function order_amount($amount): float|int
    {
        $percentage = config('app.percentage');

        $amount += $amount * $percentage / 100;

        return $amount;
    }
}

if (!function_exists('amount_piece')){
    /**
     * @param $id
     * @return float|int
     */
    function amount_piece($id): float|int
    {
        $percentage = config('app.percentage');

       $piece = \App\Models\Piece::where('id' , $id)->get()->toArray();
       $elem_piece = arrat_to_object($piece);
       $amount_piece = $elem_piece['amount'];

       return $amount = $amount_piece * $percentage / 100;
    }
}
