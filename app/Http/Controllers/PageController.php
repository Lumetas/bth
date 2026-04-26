<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $categories = Category::all();
        
        $query = Product::with('category');
        
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(15);
        
        return Inertia::render('Products/Index', [
            'products' => $products->items(),
            'categories' => $categories->toArray(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
            'filters' => [
                'category_id' => $request->category_id,
            ],
        ]);
    }
    
    public function product(int $id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        return Inertia::render('Products/Show', [
            'product' => $product->toArray(),
        ]);
    }
    
    public function login()
    {
        return Inertia::render('Auth/Login');
    }
    
    public function authenticate(Request $request)
    {
        $response = Http::post(config('app.url') . '/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);
        
        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'Неверные учетные данные',
            ]);
        }
        
        $data = $response->json();
        
        return redirect()->intended('/admin/products')
            ->withCookie(cookie('auth_token', $data['data']['token'], 60 * 24 * 7, '/', null, false, 'Lax'));
    }
    
    public function logout(Request $request)
    {
        $token = $request->cookie('auth_token');
        
        if ($token) {
            Http::withToken($token)->post(config('app.url') . '/api/logout');
        }
        
        return redirect('/')->withCookie(cookie()->forget('auth_token'));
    }
}