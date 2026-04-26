<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(15);
        $categories = Category::all();
        
        return Inertia::render('Admin/Products/Index', [
            'products' => $products->items(),
            'categories' => $categories->toArray(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
            'filters' => [
                'category_id' => $request->category_id,
            ],
        ]);
    }
    
    public function create()
    {
        $categories = Category::all();
        
        return Inertia::render('Admin/Products/Form', [
            'product' => null,
            'categories' => $categories->toArray(),
            'isEdit' => false,
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        
        $product = Product::create($validated);
        
        return redirect()->route('admin.products');
    }
    
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        return Inertia::render('Admin/Products/Form', [
            'product' => $product->toArray(),
            'categories' => $categories->toArray(),
            'isEdit' => true,
        ]);
    }
    
    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('admin.products');
    }
    
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('admin.products');
    }
}