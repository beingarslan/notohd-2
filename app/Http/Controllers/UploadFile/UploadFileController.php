<?php

namespace App\Http\Controllers\UploadFile;

use App\Http\Controllers\Controller;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function manage(Request $request)
    {
        // paginatation
        return view('uploadfiles.manage', [
            'images' => UploadFile::paginate(12)
        ]);
    }

    public function upload(Request $request)
    {
        return view('uploadfiles.upload');
    }

    public function show(Request $request)
    {
    }

    public function store(Request $request)
    {
        // validate file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar,7z,jpg,jpeg,png,gif,bmp,svg|max:2048',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Error');
            }
            return response()->json(['error' => 'Error']);
        }

        $image = $request->file('file');
        // get file extension
        $extension = $image->getClientOriginalExtension();
        $imageName = 'file_' . time() . '.' . $extension;
        // store file
        $path = Storage::disk('Wasabi')->putFileAs('uploads', $image, $imageName, 'public');

        $imageUpload = new UploadFile();
        $imageUpload->filename = $path;
        $imageUpload->save();
        return response()->json(['success' => $imageName]);
    }

    public function remove(Request $request)
    {
        $filename =  $request->get('filename');
        UploadFile::where('filename',$filename)->delete();
        // remove file
        Storage::disk('Wasabi')->delete('uploads/' . $filename);

        return $filename;
    }

}
