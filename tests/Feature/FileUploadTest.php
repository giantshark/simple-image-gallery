<?php

namespace App\Tests;

use Tests\TestCase;
use App\Container\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadTest extends TestCase
{

    use RefreshDatabase;

    public function testMustListIamges()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('GET', 'api/galleries');
        $data = $this->parseJson($response);
        $this->assertEquals(200, $data->code);
    }

    public function testUploadImageMustSuccess()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('POST', 'api/galleries', [
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);
        $data = $this->parseJson($response);
        $this->assertEquals(200, $data->code);
        $this->assertEquals('avatar.jpg', $data->response[0]->original_name);
    }

    public function testUploadImageMustNotSuccess()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('POST', 'api/galleries', [
            'file' => UploadedFile::fake()->image('avatar.svg')
        ]);
        $data = $this->parseJson($response);
        $this->assertEquals(400, $data->code);
        $this->assertEquals('The file must be a file of type: image/jpeg, image/png.', $data->message[0]);
    }

    public function testDeleteImageMustSuccess()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $uploadResponse = $this->actingAs($user)->call('POST', 'api/galleries', [
            'file' => UploadedFile::fake()->image('avatar.png')
        ]);
        $uploadResponseData = $this->parseJson($uploadResponse);
        $response = $this->actingAs($user)->call('DELETE', 'api/galleries/'.$uploadResponseData->response[0]->id);
        $data = $this->parseJson($response);
        $this->assertEquals(200, $data->code);
    }

    public function testDeleteImageMustNotSuccess()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('DELETE', 'api/galleries/200');
        $data = $this->parseJson($response);
        $this->assertEquals(400, $data->code);
        $this->assertEquals('image not found', $data->message[0]);
    }

}
