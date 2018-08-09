<?php
namespace App\Services;

class SampleService
{
    public function sample()
    {
        app('log')->debug('This is the SampleService.');
    }
}
