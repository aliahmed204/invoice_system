<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
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

         /*$section = Section::find($request->section_id);
         $section_name = $section->section_name;*/

         $request->validated();
         $section = DB::table('sections') // to get section_name and store ir in DB
                         ->where('id',$request->section_id)
                         ->value('section_name');

        Product::create([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$request->section_id,
            'section_name'=> $section,
        ]);

        return redirect('/products')->with('success','Add Done');


    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'product_name'=>'required|string|min:6|max:255',
            'description'=>'required|min:6',
        ]);

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

        return redirect('/products')->with('updated', 'Editing Done');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $id = $product->id;
        $products = Product::find($id)
            ->delete();
        return redirect('/products')->with('delete','Deleted Done');
    }
}
