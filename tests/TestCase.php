<?php

namespace Tests;

use App\User;
use App\Exceptions\Handler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp():void
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function signIn($user = null){
        $this->actingAs($user ?: create(User::class));
        return $this;
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Throwable $e) {}
            public function render($request, \Throwable $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }
}
