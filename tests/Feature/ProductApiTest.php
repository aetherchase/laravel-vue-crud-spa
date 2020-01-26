<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function seed_categories(int $num)
    {
        factory(Category::class, $num)->create();
    }

    public function make_product($data)
    {
        $this->seed_categories(5);
        $product = Product::create($data);
        $product->categories()->attach(Category::find($data["categories"]));
    }

    public function product_data()
    {
        return[
            'title' => 'Nokia 3310',
            'article' => 'ph0001',
            'description' => 'Some descrition here',
            'categories' => ['2', '4']
        ];
    }

    public function update_product_data()
    {
        return[
            'title' => 'Nokia 3312',
            'article' => 'hz005',//проверяем, что не заменяет на новый
            'description' => 'Other descrition instead',
            'categories' => ['4']
        ];
    }

    /** @test */
    public function creation(){
        $this->make_product($this->product_data());
        $this->assertCount(1, Product::all());

    }

    /** @test */
    public function get_method()
    {
        $this->make_product($this->product_data());
        $response = $this->json('GET', 'api/product')
                ->dump()
                ->assertStatus(200);
    }

    /** @test */
    public function get_category_products_method(){
        $this->make_product($this->product_data());
        $response = $this->json('GET', 'api/category/4/product')
            ->dump()
            ->assertStatus(200);
    }

    /** @test */
    public function post_method(){
        $this->seed_categories(5);
        $this->json('POST', 'api/product', $this->product_data())
            ->dump()
            ->assertStatus(201);
        $this->assertCount(1, Product::all());
        $this->assertCount(2, Product::find(1)->categories);
    }

    /** @test */
    public function put_method(){
        $this->make_product($this->product_data());
        $this->json('PUT', 'api/product/1', $this->update_product_data())
            ->dump()
            ->assertStatus(202);
        $this->assertCount(1, Product::all());
        $this->assertCount(3, Product::find(1)->categories);
        $this->assertNotEquals($this->update_product_data()['article'], Product::find(1)->article);
    }

    /** @test */
    public function delete_method()
    {
        $this->make_product($this->product_data());
        $this->json('DELETE', 'api/product/1')
            ->dump()
            ->assertStatus(200);
        $this->assertCount(0, Product::all());

    }

    /** @test */
    public function delete_products_without_categories(){
        $this->make_product($this->product_data());
        $this->make_product($this->update_product_data());
        $this->json('DELETE', 'api/category/4')
            ->dump()
            ->assertStatus(200);
        $this->assertCount(1,Product::all());
    }
}
