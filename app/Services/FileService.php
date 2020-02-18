<?php

namespace App\Http\Services;

use App\File;

class FileService {

    /**
     * Files directory maker.
     *
     * @param  string $type
     * @return string
     */
    private function makeDirectory($type){
        $directoryPathFiles=public_path('files');
        $directoryPath=$directoryPathFiles.'/'.$type;
        if (!file_exists($directoryPathFiles) || !file_exists($directoryPath)){
            mkdir($directoryPath,0777, true);
        }
        return $directoryPath;
    }


    /**
     * Save post or user files in database.
     *
     * @params $image $model $category
     */
    public function saveFile($image, $model, $category){
        $newName = mt_rand().'.'.$image->getClientOriginalExtension();

        File::create([
            'fileable_id' => $model->id,
            'fileable_type' => $model->getMorphClass(),
            'original_name'=>$image->getClientOriginalName(),
            'category'=>$category,
            'path' => '/files/' . $model->getMorphClass() . '/' . $newName,
        ]);

        $directoryPath = $this->makeDirectory($model->getMorphClass());
        $image->move($directoryPath, $newName);
    }
}