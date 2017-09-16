<?php

namespace Tests\Feature;

use App\Container\DiskManagement\Classes\Disk;
use App\Container\Gallery\Models\Gallery;
use Tests\TestCase;
use App\Container\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DiskUsageTest extends TestCase
{

    use RefreshDatabase;

    public function testDiskUsageMustIncreaseByImageSize()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $uploadResponse = $this->actingAs($user)->call('POST', 'api/galleries', [
            'file' => UploadedFile::fake()->image('avatar.png')
        ]);
        $uploadResponseData = $this->parseJson($uploadResponse);
        $disk = new Disk(new Gallery());
        $this->assertEquals($uploadResponseData->response[0]->size, $disk->getSizeKb());
        $this->assertEquals(1, $disk->getToTalFile());
    }

    public function testTotalDiskUsageMustCorrect()
    {
        Storage::fake('public');
        $totalSize = 0;
        for ($i = 0; $i < 4; $i++) {
            $user = factory(User::class)->create();
            $uploadResponse = $this->actingAs($user)->call('POST', 'api/galleries', [
                'file' => UploadedFile::fake()->image('avatar.png')
            ]);
            $uploadResponseData = $this->parseJson($uploadResponse);
            $totalSize += $uploadResponseData->response[0]->size;
        }
        $disk = new Disk(new Gallery());
        $this->assertEquals($totalSize, $disk->getSizeKb());
        $this->assertEquals(4, $disk->getToTalFile());
    }

}
