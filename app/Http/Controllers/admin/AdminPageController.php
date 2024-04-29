<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPageController extends Controller
{
    public function index(Request $request){
        $pages = Page::orderBy('id', 'desc');
        if($request->keyword){
            $keyword = $request->keyword;
            $pages = $pages->where('title', 'like', "%$keyword%");
        }

        $pages = $pages->paginate(25);
        return view('admin.page.index', compact('pages'));
    }

    public function create(){
        return view('admin.page.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:pages,title',
            'slug' => 'required|unique:pages,slug',
            'content' => 'required',
            'status' => 'required',
        ]);
        Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'status' => $request->status,
        ]);
        Alert::success('Notification', 'Create page successful!');
        return redirect()->route('pages.index');
    }
    public function edit(Page $page){
        return view('admin.page.edit', compact('page'));
    }
    public function update(Page $page, Request $request){
        $request->validate([
            'title' => 'required|unique:pages,title,'. $page->id,
            'slug' => 'required|unique:pages,slug,'. $page->id,
            'content' => 'required',
            'status' => 'required',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'status' => $request->status,
        ]);
        Alert::success('Notification', 'Update page successful!');
        return redirect()->route('pages.index');
    }

    public function delete(Page $page){
        if(!empty($page)){
            $page->delete();
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);

    }
}
