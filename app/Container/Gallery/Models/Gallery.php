<?php

namespace App\Container\Gallery\Models;

use App\Container\Traits\Size;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    use Size;

    protected $fillable = [
        'user_id',
        'size',
        'name',
        'original_name',
        'mimes',
        'mime_type'
    ];

    protected $visible = [
        'id',
        'size',
        'name',
        'original_name',
        'mimes',
        'mime_type'
    ];

    public function getImageName()
    {
        return $this->name.'.'.$this->mimes;
    }

}
