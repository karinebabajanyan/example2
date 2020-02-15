<?php

namespace App\Http\Services;

use App\File;

class FileService {


    public static function makeDirectory($type){
        $directoryPathFiles=public_path('files');
        $directoryPath=$directoryPathFiles.'/'.$type;
        if (!file_exists($directoryPathFiles) || !file_exists($directoryPath)){
            mkdir($directoryPath,0777, true);
        }
        return $directoryPath;
    }

    public static function saveFile($image,$id, $type ,$directoryPath, $category){
        $new_name = mt_rand().'.'.$image->getClientOriginalExtension();
        File::create([
            'fileable_id'=>$id,
            'fileable_type'=>$type,
            'original_name'=>$image->getClientOriginalName(),
            'category'=>$category,
            'path'=>'/files/'.$type.'/'.$new_name,
        ]);
        $image->move($directoryPath, $new_name);
    }

    public static function updateImage($file, $image,$directoryPath, $type){
        $new_name = mt_rand().'.'.$image->getClientOriginalExtension();
        $file->update([
            'original_name'=>$image->getClientOriginalName(),
            'path'=>'/files/'.$type.'/'.$new_name,
        ]);
        $image->move($directoryPath, $new_name);
    }
}