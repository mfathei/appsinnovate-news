<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsApiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::latest()->get();
        // dd($news);
        return $news;
    }

    // upload post photo
    public function uploadFile(Request $request)
    {
        // dd($request->files);

        // You need to add server side validation and better error handling here

        $data = array();

        if ($request->files) {
            $error = false;
            $files = array();

            $uploaddir = './uploads/';
            for ($i = 0;$i < count($request->files); $i++) {
                $file = $request->file("$i");
                // var_dump($file); die();
                if (move_uploaded_file($file->getRealPath(), $uploaddir . basename($file->getClientOriginalName()))) {
                    $files[] = $file->getClientOriginalName();
                } else {
                    $error = true;
                }
            }
            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        } else {
            $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }

        echo json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'min:5', 'max:255'],
            'body' => ['required', 'max:3000']
        ]);

        $post = new News();
        $post->title = request('title');
        $post->body = request('body');
        $post->photo = request("filenames")[0];

        $post->save();

        $data = array('success' => 'Post was created', 'data' => $post);
        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => ['required', 'min:5', 'max:255'],
            'body' => ['required', 'max:3000']
        ]);

        $news = News::find($id);
        $news->title = request('title');
        $news->body = request('body');
        //$news->photo = 'blue-jacket.jpg';

        $news->save();

        $data = array("success" => "Post updated", "data" => $news);
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('news')->where('id', $id)->delete();
        $data = array("success" => "Post deleted successfully", "data" => []);
        return json_encode($data);
    }

}
