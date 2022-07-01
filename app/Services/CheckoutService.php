<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    private $pricingRules;
    private $prices = ['FR1' => 3.11, 'SR1' => 5.00, 'CF1' => 11.23];
    public $total = 0;

    public function __construct($pricingRules)
    {
        $this->pricingRules = $pricingRules;
    }

    public function scan(string $item)
    {
        $product = Product::where('code', $item)->first();
        if (!empty($product)) {
            $cart = Cart::where('product_id', $product->id)->firstOrNew();
            $cart->product_id = $product->id;
            $cart->qty = ($cart->qty ?? 0) + 1;
            $cart->unit_price = $this->prices[$item];
            $cart->sub_total = $cart->qty * $cart->unit_price;
            $cart->total_price = $cart->sub_total;
            $cart->save();

            if ( ( $item === 'FR1' ) && ( $cart->qty > 1 ) ) {
                $this->buy_one_get_one_free($cart);
            }

            if ( ( $item === 'SR1' ) && array_key_exists( $item, $this->pricingRules ) && !empty ( $this->pricingRules[$item][1] ) && ( $cart->qty >= $this->pricingRules[$item][1] ) ) {
                $this->bulk_discount($cart);
            }

            $this->total = Cart::select(DB::raw('SUM(total_price) as total'))->value('total');
        }
    }

    private function buy_one_get_one_free($cart)
    {
        $discount = ( $cart->qty - floor(( $cart->qty / 2 ) + ( $cart->qty % 2 ) ) ) * $cart->unit_price;
        $cart->total_price = $cart->sub_total - $discount;
        $cart->discount_price = $discount;
        $cart->save();
    }

    private function bulk_discount($cart)
    {
        $cart->unit_price = $this->pricingRules['SR1'][2];
        $cart->sub_total = $cart->qty * $cart->unit_price;
        $cart->total_price = $cart->sub_total;
        $cart->save();
    }
}
