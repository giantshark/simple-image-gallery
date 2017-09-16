<?php

namespace App\Container\Traits;

use Illuminate\Support\Facades\DB;

trait Size {

    public function getTotalSize()
    {
        return $this->select('size')->sum('size');
    }

    public function getTotalFile()
    {
        return $this->select('id')->count('id');
    }

    public function getFiles()
    {
        return $this->select('mime_type', DB::raw('sum(size) as size'), DB::raw('count(mime_type) as total'))->groupBy('mime_type')->get();
    }

}