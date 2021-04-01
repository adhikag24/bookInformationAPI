<?php

namespace App\Http\Controllers;
use App\BookModel;
use App\WriterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BookModel::select('book_title','book_page','book_release')->get()->toArray();

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


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_title' => 'required|string',
            'book_page' => 'required|integer',
            'book_release' => 'required|string',
            'book_contents' => 'required|string',
            'writers' => 'required'
        ])->validate();

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $requestData = $request->all();

        print_r($requestData);
        die;
    
        if($data){
            $status = 200;
            $response['error'] = false;
            $response['data'] = $data->books;
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Daftar buku tidak ditemukan';
        }

        // return response()->json($response,$status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = BookModel::find($id);

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

    public function filter(Request $request, $whatToFilter){


        Validator::make($request->all(), [
            'filter' => 'required|string',
        ])->validate();

        $requestData = $request->all();

        if($whatToFilter == 'title'){
            $data = BookModel::where('book_title','like', '%'.$requestData['filter'].'%')->get()->toArray();
        }else if($whatToFilter == 'writer'){
            $data = WriterModel::with('books')->where('writer_name', $requestData['filter'])->first();
        }else{
            $data = [];
        }

        if($data){
            $status = 200;
            $response['error'] = false;
            $response['data'] = $data->books;
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
