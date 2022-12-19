<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{

    public function index()
    {
        return $this->apiResponse(ResultType::Success, Category::all(), 'Categories fetched', 200);
    }

    
    public function store(Request $request)
    {
        
        


        //kontrollü post
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();

        return $this->apiResponse(ResultType::Success,$category,'Category created.',201);
    }

   
    public function show($id)  //Product model
    {
        //belirtilen id ye göre veriyi get etme 
        
        $category = Category::find($id);
      


        if($category) {  //eğer id varsa
            return $this->apiResponse(ResultType::Success,$category, 'Category fetched',200);
        }
        else{
            return $this->apiResponse(['message'=> "category not found"],404);
        }
    }
  

    public function update($id,Request $request)
    {
        $category = Category::find($id);
        //kontrolsüz update
        /*
     
        $update_input = $request->all();
        $product->update($update_input);  
         */


        //kontrollü update
       
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->save();
        

        return $this->apiResponse(ResultType::Success,$category,'category updated.',200);
    }

 
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        return $this->apiResponse(ResultType::Success,null,'category deleted',200);
    }


    public function custom1() {
        //return Category::pluck('id');
        return Category::pluck('name','id');  //(value, key)
        
    }

    public function report1() {

        return DB::table('product_categories as pc')
        ->selectRaw('c.name,COUNT(*) as total')
        ->join('categories as c', 'c.id','=','pc.category_id')
        ->join('products as p', 'p.id','=','pc.product_id')
        ->groupBy('c.name')
        ->orderByRaw('COUNT(*) DESC')
        ->get();
        
    }
}


    