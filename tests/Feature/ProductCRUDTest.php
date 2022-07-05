<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $data = [
            'name' => 'New product name',
            'code' => $product->code,
            'price' => 125.55
        ];

        $response = $this->json('PUT','/api/products/update/' . $product->id, $data);

        $result = $response->assertStatus(200)->json('data');

        $product = $product->refresh();
        collect($data)->each(function ($item, $index) use ($product, $result) {
            $this->assertSame($result[$index], $product->$index, 'Product Fields are not same');
        });
    }

    public function test_product_soft_delete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $product->delete();

        $this->assertSoftDeleted($product);
    }

    public function test_product_delete()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $product->forceDelete();

        $this->assertModelMissing($product);
    }
}
