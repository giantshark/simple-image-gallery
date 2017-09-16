<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }
    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }

}
