<?php

namespace App\Http\Controllers;
use App\WriterModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['index', 'show']]);
    }

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
        $validator = Validator::make($request->all(), [
            'writer_name' => 'required|string',
            'writer_age' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $requestData = $request->all();

        $check = false;
        try {
            $insertWriter = new WriterModel;
            $insertWriter->writer_name = $requestData['writer_name'];
            $insertWriter->writer_age = $requestData['writer_age'];
            $insertWriter->save();

            $check =  true;
        } catch(\Exception $e) {
            echo $e;
            $check = false;
        }

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['message'] = 'Data penulis berhasil dimasukan';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data penulis gagal dimasukan';
        }

        return response()->json($response,$status);
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
        $validator = Validator::make($request->all(), [
            'writer_name' => 'string',
            'writer_age' => 'integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $writerData = WriterModel::firstWhere('id',$id);

        $check = false;
        
        if($writerData){
            try {
                $requestData = $request->all();

                $writerData->fill($requestData);
                $writerData->save();
                
                $check = true;
            } catch(Exception $e) {
                $check = false;
            }
        }else{
            return response()->json(['message'=>'Kode Penulis Tidak ditemukan']);
        }
    

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['data'] = 'Data penulis berhasil di update.';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data penulis gagal di update.';
        }

        return response()->json($response,$status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $writerData = WriterModel::firstWhere('id',$id);

        $check = false;
        
        if($writerData){
            try {
                WriterModel::destroy($id);
                
                $check = true;
            } catch(Exception $e) {
                $check = false;
            }
        }else{
            return response()->json(['message'=>'Kode Penulis Tidak ditemukan']);
        }
    

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['data'] = 'Data Penulis berhasil di hapus.';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data Penulis gagal di hapus.';
        }

        return response()->json($response,$status);
    }
}
