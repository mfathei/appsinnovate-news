<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

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
                    $files[] = $uploaddir . $file->getClientOriginalName();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
