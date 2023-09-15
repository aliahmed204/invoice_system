<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        $sections = Section::get();
        return view('products.products',compact('products', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduct $request)
    {
        $section = DB::table('sections')->where('id',$request->section_id)->value('section_name');
        Product::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,
            'section_name'=> $section,
        ]);
        return back()->with('success','Section Added To The System');
    }

    public function update(UpdateProduct $request)
    {
        // get section id throw section_name
        $section_id = DB::table('sections')
                            ->where('section_name',$request->section_name)
                            ->value('id');

        $product = Product::findOrFail($request->id);
        $product->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$section_id,
            'section_name'=> $request->section_name,
        ]);
        return back()->with('updated', 'Editing Done');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/products')->with('delete','Deleted Done');
    }
}
