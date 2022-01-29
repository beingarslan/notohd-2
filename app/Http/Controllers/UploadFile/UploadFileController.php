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
        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];
        // paginatation
        $images = UploadFile::paginate(12);
        foreach ($images as $image) {
            $image->tags = str_replace(array('[', ']', '"'), '', $image->tags);
        }
        return view('uploadfiles.manage', [
            'images' => $images,
            'pageConfigs' => $pageConfigs,
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

        // get file url
        $fileUrl = Storage::disk('Wasabi')->url($path);

        putenv("GOOGLE_APPLICATION_CREDENTIALS=challengestreamer-a6101121eefc.json");
        $client = new ImageAnnotatorClient();
        $annotation = $client->annotateImage(
            $fileUrl,
            [Type::LABEL_DETECTION]
        );
        $tags = [];
        foreach ($annotation->getLabelAnnotations() as $faceAnnotation) {
            $tags[] = $faceAnnotation->getDescription();
        }

        $imageUpload = new UploadFile();
        $imageUpload->filename = $path;
        $imageUpload->thumbnail =  \Thumbnail::src($fileUrl)->smartcrop(350, 250)->url(true);
        $imageUpload->tags = json_encode($tags);
        $imageUpload->save();

        return response()->json(['success' => $imageName]);
    }

    public function remove(Request $request)
    {
        $filename =  $request->get('filename');
        UploadFile::where('filename', $filename)->delete();
        // remove file
        Storage::disk('Wasabi')->delete('uploads/' . $filename);

        return $filename;
    }

    public function removefile(Request $request)
    {
        try {
            $id =  $request->get('id');
            $uploadFile = UploadFile::where('id', $id)->first();
            // remove file
            Storage::disk('Wasabi')->delete($uploadFile->filename);
            $uploadFile->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'File removed successfully',
                'id' => $request->input('id'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }

        // $filename =  $request->get('filename');
        // UploadFile::where('filename',$filename)->delete();
        // // remove file
        // Storage::disk('Wasabi')->delete('uploads/' . $filename);

        // return $filename;
    }
}
