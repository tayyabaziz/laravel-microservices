<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_can_be_listed(): void
    {
        Product::create([
            'name' => 'Laptop',
            'price' => '1299.99',
        ]);

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonFragment(['name' => 'Laptop']);
    }

    public function test_product_can_be_created_with_valid_data(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Laptop',
            'price' => '1299.99',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Laptop')
            ->assertJsonPath('price', '1299.99');

        $this->assertDatabaseHas('products', ['name' => 'Laptop']);
    }

    public function test_product_creation_requires_positive_price(): void
    {
        $this->postJson('/api/products', [
            'name' => 'Laptop',
            'price' => -10,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['price']);
    }
}
