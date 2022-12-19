<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(UploadRequest $request) 
    {
       

    //storage'de dsosyalar kaydedilir kullanımı public ve localde kaydetme

     if ($request->file('uploadFile')->isValid()) {

        $file = $request->file('uploadFile');
        $path = $request->uploadFile->path();
        $extension = $request->uploadFile->extension();
        $fileNameWithExtension = $file->getClientOriginalName();
        $fileNameWithExtension = $request->userId. '-' . time() . '.' .$extension;

       
        //dosya yoluyla kaydetmek için store
        //$path = $request->uploadFile->store('uploads/images');

        //dosya adı vererek için storeAs
        $path = $request->uploadFile->storeAs('uploads/images', $fileNameWithExtension, 'public');
        //dd($path);


        return response()->json(['url' => asset("storage/$path")]);
    

    }


    //s3 ile cloud sunucuya dosya kaydetme --belirsiz

   /*  if ($request->file('uploadFile')->isValid()) {

        $file = $request->file('uploadFile');
        $path = $request->uploadFile->path();
        $extension = $request->uploadFile->extension();
        $fileNameWithExtension = $file->getClientOriginalName();
        $fileNameWithExtension = $request->userId. '-' . time() . '.' .$extension;

       
        //dosya yoluyla kaydetmek için store
        //$path = $request->uploadFile->store('uploads/images');

        //dosya adı vererek için storeAs
        $path = $request->uploadFile->storeAs('uploads/images', $fileNameWithExtension, 's3');
        //dd($path);


        return response()->json(['url' => Storage::url($path)]);  //localhostsuz link
    

    } */
 
  //BU KISIM PUBLIC KLASÖRÜNE DOSYALARI KAYDEDER
    //isValid ve extension ile dosyayı localde kaydetme
       /*  if ($request->file('uploadFile')->isValid()) {

            $file = $request->file('uploadFile');
            $path = $request->uploadFile->path();
            $extension = $request->uploadFile->extension();
            $fileNameWithExtension = $file->getClientOriginalName();
            $fileNameWithExtension = $request->userId. '-' . time() . '.' .$extension;

            //dd($fileNameWithExtension);  //previewde gözükür

            if ($file->move(public_path('/uploads/'), $fileNameWithExtension)) {

                $fileUrl = url('/uploads/' . $fileNameWithExtension);
                return response()->json(['url' => $fileUrl]);
            }

        }
 */




        //hasFile kullanımı
     /*    if ($request->hasFile('uploadFile')) {

            $file = $request->file('uploadFile');
            $fileNameWithExtension = $file->getClientOriginalName();

            if ($file->move(public_path('/uploads/'), $fileNameWithExtension)) {

                $fileUrl = url('/uploads/' . $fileNameWithExtension);
                return response()->json(['url' => $fileUrl]);
            }

        } */
     
    }
}
