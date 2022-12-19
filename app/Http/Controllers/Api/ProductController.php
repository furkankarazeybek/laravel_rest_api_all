<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends ApiController
{
  
    public function index(Request $request)
    {

      //Get etme 3 şekilde yapılabilir
        /*
        //return Product::all();
        //return response()->json(Product::all(), 200);
        //return response(Product::all(), 200);
        */

        //SAYFALANDIRMA 

      //  return response(Product::paginate(10),200);

        //Limitlendirme ve Offset

        $offset = $request->has('offset') ? $request->query('offset'):0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $queryBuilder = Product::query()->with('categories');

        //filteleme
        if ($request->has('q')) {
            $queryBuilder->where('name', 'like', '%' . $request->query('q') . '%');
        }

        //sıralama
        if ($request->has('q')) {
            $queryBuilder->orderBy($request->query('sortBy'), $request->query('sort', 'DESC')); //defaul sort DESC olarak belirlendi
        }

        $data = $queryBuilder->offset($offset)->limit($limit)->get();

        $data = $data->makeHidden('slug');
        
        return response($data,200);

        



        
    }


     //POST ETME APİ
    public function store(Request $request)
    {

        //doğrudan kontrolsüz post  
        /*
        $post_input = $request->all();  //postmanda body' girilen input

        $product = Product::create($post_et);
        */


        //kontrollü post
        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return response([
            'data' => $product,
            'message' => 'Product created.'

        ], 201);

       
    }

   
    public function show($id)  //Product model
    {
        //belirtilen id ye göre veriyi get etme 
        try 
        { 
            $product = Product::findOrFail($id);
            return $this->apiResponse(ResultType::Success, $product, 'Product found!', 200);
        }

        //o veri olmadığındaki hata mesajı
        catch(ModelNotFoundException $exception) 
        {
            return $this->apiResponse(ResultType::Error, null, 'Product Not Found!', 404);
        }

       

    }

    //PUT VERİ GÜNCELLEME
    public function update($id,Request $request)
    {

        $product = Product::find($id);
        //kontrolsüz update
        /*
     
        $update_input = $request->all();
        $product->update($update_input);  
         */


        //kontrollü update
       
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();
        

        return response([
            'data' => $product,
            'message' => 'Product updated.'

        ], 200);
    }

    //DELETE VERİ SİLME
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return response([
            'message' => 'Product deleted' 
        ],200);
    }


    public function custom1() {
      //  return Product::select('id','name')->orderBy('created_at','desc')->take(10)->get();

        return Product::selectRaw('id as product_id, name as product_name')->orderBy('created_at','desc')->take(10)->get();
    }

    public function custom2() {
        //  return Product::select('id','name')->orderBy('created_at','desc')->take(10)->get();
  
          $products = Product::orderBy('created_at','desc')->take(10)->get();

        $mapped = $products->map(function ($product) {
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'] * 1.03

            ];
        });

        return $mapped->all();


      }

      public function custom3() {
        $products = Product::paginate(10);

        return ProductResource::collection($products);
      }

      public function listWithCategories() {


        //iliskisel_relational_data_resource_GET

       /*  $products = Product::paginate(10);

        return ProductWithCategoriesResource::collection($products); */
        //


        //Koşullu_Conditinoal_GET
        $products = Product::with('categories')->paginate(10);

        return ProductWithCategoriesResource::collection($products);
      }
}
