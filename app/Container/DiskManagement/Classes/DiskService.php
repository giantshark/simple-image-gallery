<?php

namespace App\Container\DiskManagement\Classes;

use App\Container\Gallery\Models\Gallery;

class Disk {

    protected $totalSize;

    protected $totalFile;

    protected $files = [];

    public function __construct(Gallery $gallery)
    {
        $this->totalSize = $gallery->getTotalSize();
        $this->totalFile = $gallery->getTotalFile();
        $this->files[] = $gallery->getFiles();
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getToTalFile()
    {
        return $this->totalFile;
    }

    public function getSizeMb()
    {
        return $this->totalSize/1024;
    }

    public function getSizeKb()
    {
        return $this->totalSize;
    }

}