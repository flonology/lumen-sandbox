<?php
namespace App\Services;

class ExampleService
{
    private $sampleService;

    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    public function example()
    {
        app('log')->debug('This is the ExampleService calling SampleService.');
        $this->sampleService->sample();
    }
}
