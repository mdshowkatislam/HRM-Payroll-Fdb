<?php

namespace App\Helper;

use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


trait Helper
{
    public static function deleteFile($path)
    {
//        $path = explode("public/",$path);
        File::delete($path);
//        unlink($path[1]);
    }


    public static function changeStatus($status, $model, $id):bool
    {
        ( $status == "Active" ) ? $status = "Inactive" : $status = "Active";

        return ( $model::where('id', $id)->update([
            'status' => $status
        ]) ) ;
    }


    public static function uploadImage($files,$path)
    {
        $fileName = $files->getClientOriginalName();
        $fileName = Str::random(6) . time() . Str::random(4).$fileName;
        $dbName = $path . '' . $fileName;
        $files->move($path, $fileName);
        $image = $dbName;

        return $image;
    }

}
