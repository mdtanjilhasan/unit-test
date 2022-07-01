<?php

namespace Tests\Unit;

use App\Services\CheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout1()
    {
        $pricingRules = [
            'FR1' => ['get_one_free', null, null],
            'SR1' => ['bulk_discount', 3, 4.50],
        ];
        Artisan::call('db:seed');
        $co = new CheckoutService($pricingRules);
        $co->scan('FR1');
        $co->scan('SR1');
        $co->scan('FR1');
        $co->scan('FR1');
        $co->scan('CF1');
        $this->assertEquals(22.45, $co->total);
    }
}
