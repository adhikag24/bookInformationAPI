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
        $data = BookModel::with('writer')->where('book_id',$id)->get()->toArray();

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

    public function filter(Request $request){


        Validator::make($request->all(), [
            'whatToFilter' => 'required|string',
            'filter' => 'required|string',
        ])->validate();

        $requestData = $request->all();


        if($requestData['whatToFilter'] == 'title'){
            $data = BookModel::where('book_title','like', '%'.$requestData['filter'].'%')->get()->toArray();
        }else if($requestData['whatToFilter'] == 'writer'){

            $writerId = WriterModel::select('writer_id')->where('writer_name', $requestData['filter'])->first()['writer_id'];

            $data = BookModel::where('writer_id', $writerId)->get()->toArray();
        }else{
            $data = [];
        }

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
