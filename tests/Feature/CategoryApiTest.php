<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;


    public function seed_categories(int $num)
    {
        factory(Category::class, $num)->create();
    }

    public function make_category($data)
    {
        Category::create($data);
    }

    public function category_data()
    {
        return[
            'name' => 'Смартфоны'
        ];
    }

    public function update_category_data()
    {
        return[
            'name' => 'Смартфоны'
        ];
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->seed_categories(3);
        $response = $this->json('GET','api/category')
            ->dump()
            ->assertStatus(200);
    }

    /** @test */
    public function post_method(){
        $this->seed_categories(5);
        $this->json('POST', 'api/category', $this->category_data())
            ->dump()
            ->assertStatus(201);
        $this->assertCount(6, Category::all());
        //$this->assertCount(2, Product::find(1)->categories);
    }

    /** @test */
    public function update_method(){
        $this->seed_categories(5);
        $this->json('PUT', 'api/category/3', $this->update_category_data())
            ->dump()
            ->assertStatus(202);
        $this->assertCount(5, Category::all());
        //$this->assertCount(3, Category::find(1)->categories);
        //$this->assertNotEquals($this->update_category_data()['article'], Category::find(1)->article);
    }

    /** @test */
    public function update_unique_exception(){
        Category::create(['name'=> 'Сотовый']);
        $this->json('PUT', 'api/category/1', ['name'=>'Сотовый'])
            ->dump()
            ->assertStatus(202);
    }

    /** @test */
    public function delete_method()
    {

        $this->make_category($this->category_data());
        $this->json('DELETE', 'api/category/1')
            ->dump()
            ->assertStatus(200);
        $this->assertCount(0, Category::all());

    }


}
