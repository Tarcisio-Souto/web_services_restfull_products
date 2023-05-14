<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProductsFormRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    private $product;
    private $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $products = $this->product->listProducts($req->all());
        return response()->json($products, 200);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductsFormRequest $request)
    {

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = Str::kebab($request->name);

            $extension = $request->image->extension();
            
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $product = $this->product->create($data);
        return response()->json($product, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);
        
        if (!$product) {
            return response()->json(['error' => 'Nenhum produto encontrado!', 404]);
        }

        return response()->json($product, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductsFormRequest $request, $id)
    {

        $data = $request->all();
        $product = $this->product->find($id);

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado.', 404]);
        }

        if ($product->image) {

            if ($request->image) {
                if (Storage::exists("{$this->path}/{$product->image}"))
                    Storage::delete("{$this->path}/{$product->image}");
            }

            if (!$request->image) {

                $old_extension = explode(".", $product->image)[1];
                $new_name_img = Str::kebab($request->name);
                $old_name_img = $product->image;            
                
                $nameFile = "{$new_name_img}.{$old_extension}";
                $data['image'] = $nameFile;

                Storage::move("{$this->path}/{$old_name_img}", "{$this->path}/{$nameFile}");

            }
            
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $name = Str::kebab($request->name);

            $extension = $request->image->extension();
            
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;

            $upload = $request->image->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
        }

        $product->update($data);
        return response()->json([$product, 'success' => 'Produto alterada com sucesso', 200]);        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Nenhum produto encontrado!', 404]);
        }

        if ($product->image) {
            if (Storage::exists("{$this->path}/{$product->image}"))
                Storage::delete("{$this->path}/{$product->image}");
        }

        $product->delete();

        return response()->json(['success' => 'true', 204]);

    }
}
