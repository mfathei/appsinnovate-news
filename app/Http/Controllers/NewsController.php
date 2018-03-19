<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $news = News::latest()->get();
// dd($news);
        return view('home', compact('news'));
    }

    public function list() {
        $news = News::latest()->get();
// dd($news);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'title' => ['required', 'min:5', 'max:255'],
            'body' => ['required', 'max:3000']
        ]);

        $post = new News();
        $post->title = request('title');
        $post->body = request('body');
        $post->photo = 'blue-jacket.jpg';

        $post->save();


        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $news = News::find($id);
        return view('news.edit', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $news = News::find($id);
//        dd($news);
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => ['required', 'min:5', 'max:255'],
            'body' => ['required', 'max:3000']
        ]);

        $news = News::find($id);
        $news->title = request('title');
        $news->body = request('body');
//        $news->photo = 'blue-jacket.jpg';

        $news->save();

        return redirect('home');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table('news')->where('id', $id)->delete();
        return redirect('/home');
    }

    public function delete(Request $request) {
        $id = request('doctor-delete-id');
        DB::table('news')->where('id', $id)->delete();
        return redirect('/home');
    }

}
