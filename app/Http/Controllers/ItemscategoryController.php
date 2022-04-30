<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Itemscategory;

class ItemscategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /itemscategory
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /itemscategory/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('itemscategory.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /itemscategory
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Request::all();
		$category = new Itemscategory;


		$category->name = Request::get('name');
		$category->save();

		return back();
	}

	/**
	 * Display the specified resource.
	 * GET /itemscategory/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */	
	public function show($id)
	{
		$category = Itemscategory::find($id);
		$items = Item::where('category','=',$id)->get();
		return view('itemscategory.show')->with(['category'=>$category, 'items'=>$items]);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /itemscategory/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = Itemscategory::find($id);

		return view('itemscategory.edit')->with('category', $category);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /itemscategory/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//return $data = Input::all();

		$category = Itemscategory::find($id);

		$category->name = Request::get('name');
		$category->update();

		return redirect('items.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /itemscategory/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$category = Itemscategory::destroy($id);

		return redirect('items.index')->with('error', 'Item successfully deleted');
	}

}