<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\Navbar;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Footer;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'hero' => Hero::first(),
            'navbar' => Navbar::first(),
            'features' => Feature::where('status', 'active')->orderBy('id', 'asc')->get(),
            'products' => Product::where('status', 'active')->orderBy('id', 'desc')->get(),
            'testimonials' => Testimonial::where('status', 'active')->orderBy('id', 'desc')->take(3)->get(),
            'footer' => Footer::first()
        ]);
    }
}
