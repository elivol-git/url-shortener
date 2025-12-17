<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $links = Link::slugSearch($request->slug)
            ->withCount('hits')
            ->paginate(10)
            ->withQueryString();
        return view('admin.links.index', compact('links'));
    }
}
