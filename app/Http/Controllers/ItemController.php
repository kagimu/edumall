<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index() {
    return Item::with(['category','supplier','location'])->get();
    }

    public function store(Request $request) {
        return Item::create($request->all());
    }

    public function lowStock() {
        return Item::whereColumn('quantity','<=','min_quantity')->get();
    }
}
