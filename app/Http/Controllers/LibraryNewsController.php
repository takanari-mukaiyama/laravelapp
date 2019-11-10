<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use App\Http\Requests\LibraryRequest;

class LibraryNewsController extends Controller
{
    public function index(){
        $news_list = News::sortNewest()->paginate(10);
        return view("library.news.list", ["news_list" => $news_list]);
    }

    public function add(){
        return view("library.news.add");
    }

    public function backFromAddConfirm(LibraryRequest $request){
        $data = [
            "back_flag"  => $request->back_flag,
            "news_title" => $request->news_title,
            "section"    => $request->section,
        ];
        return view("library.news.add", $data);
    }
 
    public function addConfirm(LibraryRequest $request){
        $data = [
            "news_title" => $request->news_title,
            "section"    => $request->section,
        ];
        return view("library.news.addconfirm", $data);
    }

    public function addComplete(LibraryRequest $request){
        $data = [
            "news_title" => $request->news_title,
            "section"    => $request->section,
        ];
        $news = new News; 
        $news->fill($data)->save();
        return view("library.news.addcomplete");
    }

    public function detail(Request $request){
        $news = News::getOne($request->id)->first();
        return view("library.news.detail", ["news" => $news]);
    }

    public function edit(Request $request){
        $news = News::getOne($request->id)->first();
        return view("library.news.edit", $news);
    }

    public function backFromEditConfirm(LibraryRequest $request){
        $data = $request->all();
        unset($data["_token"]);
        return view("library.news.edit", $data);
    }

    public function editConfirm(LibraryRequest $request){
        $data = $request->all();
        unset($data["_token"]);
        return view("library.news.editconfirm", $data);
    }

    public function editComplete(LibraryRequest $request){
        //$news = News::find($request->id);
        $data = $request->all();
        unset($data["_token"]);
        //$news->fill($data)->save();
        News::find($request->id)->fill($data)->save();
        return view("library.news.editcomplete", ["id" => $request->id]);
    }

    public function delete(Request $request){
        $news = News::getOne($request->id)->first();
        return view("library.news.delete", $news);
    }

    public function remove(Request $request){
        News::find($request->id)->delete();
        return view("library.news.deletecomplete");
    }
}
