<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Category;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection(Product::with('categories')->get());
    }

    public function category_products(Category $category)
    {
        return ProductResource::collection(Product::whereHas('categories', function($q) use ($category) {
            $q->where('category_id', $category->id);
        })->with('categories')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        $product->categories()->attach(Category::find($request->input('categories')));

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if($request->input('categories')){
            $product->categories()->detach();
            $product->categories()->attach(Category::find($request->input('categories')));
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()
            ->json(['message'=>'Удалено!'] )
            ->setStatusCode(Response::HTTP_OK);
    }
}
