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
    /**
     * Decode image data and return the first item
     * 
     * @param string|array $data The data to decode
     * @return string|null The first image path or null if no images
     */
    function decode_image($data){
        if (empty($data)) {
            return null;
        }

        // Si c'est déjà un tableau, pas besoin de décoder
        $images = is_array($data) ? $data : json_decode($data, true);
        
        if (empty($images)) {
            return null;
        }

        // Retourne le premier élément du tableau
        return is_array($images) ? reset($images) : $images;
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

if (!function_exists('money')) {
    /**
     * Format a number as money
     *
     * @param float|int|string $amount
     * @param string $currency
     * @return string
     */
    function money($amount, $currency = 'EUR'): string
    {
        return number_format(floatval($amount), 2, ',', ' ') . ' ' . $currency;
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
