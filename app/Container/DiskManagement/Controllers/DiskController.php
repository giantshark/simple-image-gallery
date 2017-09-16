<?php

namespace App\Container\DiskManagement\Controllers;

use App\Container\DiskManagement\Classes\Disk;
use App\Http\Controllers\Controller;

class DiskController extends Controller
{

    protected $disk;

    public function __construct(Disk $disk)
    {
        $this->disk = $disk;
    }

    public function index()
    {
        $data['diskUsageOverviewKb'] = $this->disk->getSizeKb();
        $data['diskUsageOverviewMb'] = $this->disk->getSizeMb();
        $data['totalFile'] = $this->disk->getToTalFile();
        $data['totalFiles'] = $this->disk->getFiles();
        return view('disk.index', $data);
    }
}
