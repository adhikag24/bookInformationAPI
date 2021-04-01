<?php

namespace App\Http\Controllers;
use App\WriterModel;

use Illuminate\Http\Request;

class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WriterModel::with('books')->get()->toArray();

        if($data){
            $status = 200;
            $response['error'] = false;
            $response['data'] = $data;
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Daftar buku tidak ditemukan';
        }

        return response()->json($response,$status);
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
        $data = WriterModel::with('books')->find($id);

        if($data){
            $status = 200;
            $response['error'] = false;
            $response['data'] = $data;
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Daftar buku tidak ditemukan';
        }

        return response()->json($response,$status);
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
