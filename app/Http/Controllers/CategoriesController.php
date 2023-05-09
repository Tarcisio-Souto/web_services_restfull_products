<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCategoriesFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $categories = $this->category->ListCategories($req->name);
        return response()->json([$categories, 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCategoriesFormRequest $request)
    {
        $category = $this->category->create($request->all());
        return response()->json([$category, 'success' => 'Categoria registrada com sucesso', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoria não encontrada', 404]);
        }

        return response()->json([$category, 200]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCategoriesFormRequest $request, $id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoria não encontrada', 404]);
        }

        $category->update($request->all());
        return response()->json([$category, 'success' => 'Categoria alterada com sucesso', 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoria não encontrada', 404]);
        }

        $category->delete($id);
        return response()->json(['success' => true, 200]);

    }
}
