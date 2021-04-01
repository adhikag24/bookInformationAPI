<?php

namespace App\Http\Controllers;
use App\BookModel;
use Illuminate\Support\Facades\Auth;
use App\WriterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use DB;

class BookController extends Controller
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
            'writers_id' => 'required|array|min:1',
            "writers_id.*"  => "required|integer"
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $requestData = $request->all();

   
        $check = false;
        DB::beginTransaction();
        try {
            $insertBook = new BookModel;
            $insertBook->book_title = $requestData['book_title'];
            $insertBook->book_page = $requestData['book_page'];
            $insertBook->book_release = $requestData['book_release'];
            $insertBook->book_contents = $requestData['book_contents'];
            $insertBook->save();
            
            $insertBookId = $insertBook->id;

            $pivotData = [];

            foreach($requestData['writers_id'] as $index => $val){
                $pivotData[$index] = [
                    'book_id' => $insertBookId,
                    'writer_id' => $val,
                   ];
            }
            
            DB::table('bw_relations')->insert($pivotData);

            DB::commit();

            $check =  true;
        } catch(\Exception $e) {
            echo $e;
            // if error happened, rollback transaction
            DB::rollback();
            $check = false;
        }

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['message'] = 'Data buku berhasil dimasukan';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data buku gagal dimasukan';
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'book_title' => 'string',
            'book_page' => 'integer',
            'book_release' => 'string',
            'book_contents' => 'string',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $bookData = BookModel::firstWhere('id',$id);

        $check = false;
        
        if($bookData){
            try {
                $requestData = $request->all();

                $bookData->fill($requestData);
                $bookData->save();
                
                $check = true;
            } catch(Exception $e) {
                $check = false;
            }
        }else{
            return response()->json(['message'=>'Kode Buku Tidak ditemukan']);
        }
    

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['data'] = 'Data buku berhasil di update.';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data buku gagal di update.';
        }

        return response()->json($response,$status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $bookData = BookModel::firstWhere('id',$id);

        $check = false;
        
        if($bookData){
            try {
                BookModel::destroy($id);
                
                $check = true;
            } catch(Exception $e) {
                $check = false;
            }
        }else{
            return response()->json(['message'=>'Kode Buku Tidak ditemukan']);
        }
    

        if($check){
            $status = 200;
            $response['error'] = false;
            $response['data'] = 'Data buku berhasil di hapus.';
        }else{
            $status = 404;
            $response['error'] = true;
            $response['message'] = 'Data buku gagal di hapus.';
        }

        return response()->json($response,$status);
    }
}
