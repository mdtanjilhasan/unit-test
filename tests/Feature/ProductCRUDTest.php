<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login()
    {
        $user = User::factory()->create();
        $response = $this->json('post', '/api/login', ['email' => $user->email, 'password' => 'password']);
        $result = $response->assertStatus(200)->json('data');
        $this->assertArrayHasKey('token', $result, 'User Authentication Failed');
    }

    public function test_products_list()
    {
        $user = User::factory()->create();
        // for auth route
        Sanctum::actingAs($user);

        $products = Product::factory(10)->create();
        $productIds = $products->map(fn ($product) => $product->id);

        $response = $this->json('get', '/api/products');
        $response->assertOk();

        $data = $response->json('data.data');

        collect($data)->map(fn ($product) => $this->assertTrue( in_array( $product['id'], $productIds->toArray() ) ) );
    }

    public function test_products_store()
    {
        $user = User::factory()->create();
        // for auth route
        Sanctum::actingAs($user);

        $product = Product::factory()->make();

        $response = $this->json('post', '/api/products', $product->toArray());
        $data = $response->assertStatus(200)->json('data');
        $result = collect($data)->only(array_keys($product->getAttributes()));

        $result->each(function ($value, $field) use ($product) {
            $this->assertSame(data_get($product, $field), $value, 'Fillable is not same.');
        });
    }

    public function test_product_show()
    {
        $user = User::factory()->create();
        // for auth route
        Sanctum::actingAs($user);

        $product = Product::factory()->create();
        $response = $this->json('get', '/api/products/' . $product->id);
        $data = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($data, 'id'), $product->id, 'Response ID for Product Show is not same');
    }


    public function test_products_update()
    {
        $user = User::factory()->create();
        // for auth route
        Sanctum::actingAs($user);

        $product = Product::factory()->create();
        $productObj = Product::factory()->make();

        $fillables = collect( ( new Product() )->getFillable() );
        $fillables[] = 'product_id';
//
//        $response = $this->json('put', '/api/products', $product->toArray());
//        $data = $response->assertStatus(200)->json('data');
//        $result = collect($data)->only(array_keys($product->getAttributes()));

        $fillables->each(function ($toUpdate) use ($product, $productObj) {
            $response = $this->json('put', '/api/products/update', [
                $toUpdate => data_get('')
            ]);
        });
    }
}
