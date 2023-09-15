<?php

namespace App\Http\traits;

trait UploadFile
{

    private function UploadFile($file ,$path ){
        $file_name = time().'-'.$file->getClientOriginalName();
        $file->move(public_path($path) , $file_name);
        return $file_name ;
    }
    private function DeleteFile($old_file , $path){
        if($old_file){
            if(file_exists(public_path($path.$old_file))){
                unlink(public_path($path.$old_file));
            }
        }
    }
}
