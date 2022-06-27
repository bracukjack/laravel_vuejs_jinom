<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllProducts() 
    {
        return Product::all();
    }

    public function getProductById($id) 
    {
        return Product::findOrFail($id);
    }

    public function deleteProduct($id) 
    {
        Product::destroy($id);
    }

    public function createProduct(array $productDetails) 
    {
        return Product::create($productDetails);
    }

    public function updateProduct($id, array $newDetails) 
    {
        return Product::whereId($id)->update($newDetails);
    }

    public function getFulfilledProducts() 
    {
        return Product::where('is_fulfilled', true);
    }
}