<?php

use App\Repository\CartRepository;

if (! function_exists('responseCustom')) {
    function responseCustom($message = '', $data = [], $status = false, $code = 500)
    {
        return collect(['status' => $status, 'message' => $message, 'data' => $data, 'code' => $code]);
    }
}

if(!function_exists("nominalFormat")) {
    function nominalFormat($nominal = 0) {
        if($nominal > 0) {
            return number_format(round($nominal, 0), 0, ',', '.');
        }

        return $nominal;
    }
}

if(! function_exists('cartTotal')) {
    function cartTotal() {
        $total = 0;
        if(\Auth::check()) {
            $total = CartRepository::totalCarts();
        }
        return $total;
    }
}

if(! function_exists('alertNotify')){
    function alertNotify($isSuccess  = true, $message = ''){
        if($isSuccess){
            request()->session()->flash('alert-class','success');
            request()->session()->flash('status', $message);
        }else{
            request()->session()->flash('alert-class','error');
            request()->session()->flash('status', $message);
        }
    }
}
