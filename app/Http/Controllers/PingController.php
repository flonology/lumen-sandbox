<?php
namespace App\Http\Controllers;
use App\Services\ExampleService;


class PingController extends Controller
{
    private $exampleService;

    public function __construct(ExampleService $exampleService)
    {
        $this->exampleService = $exampleService;
    }

    public function ping()
    {
        $this->exampleService->example();
        return response()->json('pong');
    }
}
