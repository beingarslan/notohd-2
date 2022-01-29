<?php

namespace App\Http\Controllers\UploadFile;

use App\Http\Controllers\Controller;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Image;

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

        $thumbnail = Image::make($image->getRealPath())->resize(300, 200);
        $thumbnail_path = Storage::disk('Wasabi')->putFileAs('uploads', $thumbnail, 'thumbnail_'.$imageName, 'public');

        putenv("GOOGLE_APPLICATION_CREDENTIALS=challengestreamer-a6101121eefc.json");
        $client = new ImageAnnotatorClient();
        $annotation = $client->annotateImage(
            Storage::disk('Wasabi')->url($path),
            [Type::LABEL_DETECTION]
        );
        $tags = [];
        foreach ($annotation->getLabelAnnotations() as $faceAnnotation) {
            $tags[] = $faceAnnotation->getDescription();
        }

        $imageUpload = new UploadFile();
        $imageUpload->filename = $path;
        $imageUpload->thumbnail = $thumbnail_path;
        $imageUpload->tags = json_encode($tags);
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
