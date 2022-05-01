<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Itemscategory;
use DB;


class ItemsController extends Controller
{

    /**
     * Display a listing of items
     *
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $items = Item::all();
        $category = Itemscategory::all();

        return view('items.index', compact('items', 'category'));
    }

    /**
     * Show the form for creating a new item
     *
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $category = Itemscategory::all();
        return view('items.create')->with('category', $category);
    }

    /**
     * Store a newly created item in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = Validator::make($data = Request::all(), Item::$rules, Item::$messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item = new Item;

        $item->name = Request::get('name');
        $item->date = date('Y-m-d');
        $item->description = Request::get('description');
        $item->category = Request::get('category');

        $item->purchase_price = Request::get('pprice');
        $item->selling_price = Request::get('sprice');
        $item->reorder_level = Request::get('reorder');
        // $item->sku= Input::get('sku');
        // $item->tag_id = Input::get('tag');

        $item->type = Request::get('type');

        $item->save();

        return redirect()->route('items.index')->with('flash_message', 'Item successfully created!');
    }

    /**
     * Display the specified item.
     *
     * @param int $id
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified item.
     *
     * @param int $id
     * @return Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $category = Itemscategory::all();
        return view('items.edit', compact('item', 'category'));
    }

    /**
     * Update the specified item in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($data = Request::all(), Item::$rules, Item::$messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item->name = Request::get('name');
        $item->description = Request::get('description');
        $item->purchase_price = Request::get('pprice');
        $item->selling_price = Request::get('sprice');
        $item->category = Request::get('category');
        // $item->sku= Input::get('sku');
        // $item->tag_id = Input::get('tag');
        $item->reorder_level = Request::get('reorder');

        $item->type = Request::get('type');

        $item->update();

        return redirect()->route('items.index')->with('flash_message', 'Item successfully updated!');
    }

    /**
     * Remove the specified item from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Erporderitem::where('item_id', $id)->delete();
        Item::destroy($id);

        return redirect('items.index')->with('error', 'Item successfully deleted!');
    }

}
