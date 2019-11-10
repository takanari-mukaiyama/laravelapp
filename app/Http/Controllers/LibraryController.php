<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\News;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $news = News::sortNewest()->limit(3)->get();
        return view("library.index", ["news_list" => $news]);
    }

    public function registerComplete(){
        return view("library.registercomplete");
    }
}
