<?php

namespace App\Container\Gallery\Transformers;

use Illuminate\Database\Eloquent\Model;
use Themsaid\Transformers\AbstractTransformer;

class GalleryTransformer extends AbstractTransformer
{
    public function transformModel(Model $item)
    {
        $output = [
            'id'		=> resolve('Support\Hash')->encode($item->id),
            'size'		=> $item->size,
            'name'		=> $item->name,
            'original_name'		=> $item->original_name,
            'mimes'		=> $item->mimes,
            'mime_type'		=> $item->mime_type,
        ];

        return $output;
    }

}