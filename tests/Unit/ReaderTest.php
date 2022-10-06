<?php

namespace Tests\Unit;

use App\Exceptions\CustomException;
use App\Services\FileServices;
use App\Services\PaginatorService;
use Tests\TestCase;

class ReaderTestTest extends TestCase
{

    public function test_check_file_works_when_file_name_is_wrong()
    {
        $this->expectException(CustomException::class);
        $this->expectExceptionMessage('unable to find this file');
        $fileService = new FileServices();
        $fileService->checkFile(public_path('wrong_index.php'));
        throw $this->response->exception;
    }

    public function test_check_file_works_when_file_name_is_directory()
    {
        $this->expectException(CustomException::class);
        $this->expectExceptionMessage('unable to handle directory path');
        $fileService = new FileServices();
        $fileService->checkFile(public_path());
        throw $this->response->exception;
    }

    public function test_check_file_works_when_file_name_is_success()
    {
        $this->expectNotToPerformAssertions(); // If this throws an exception, the test will fail.
        $fileService = new FileServices();
        $fileService->checkFile(public_path('index.php'));
    }

    public function test_read_file_works_on_first_page()
    {
        $fileService = new FileServices();
        $response = $fileService->readFile(public_path('index.php'));
        $this->assertInstanceOf(PaginatorService::class, $response);
        $this->assertCount(10, $response->items());
        $this->assertTrue($response->hasMorePages());
        $this->assertTrue($response->onFirstPage());
    }

    public function test_read_file_works_on_middle_page()
    {
        $fileService = new FileServices();
        $response = $fileService->readFile(public_path('index.php'), 10, 2);
        $this->assertInstanceOf(PaginatorService::class, $response);
        $this->assertCount(10, $response->items());
        $this->assertTrue($response->hasMorePages());
        $this->assertFalse($response->onFirstPage());
    }

    public function test_read_file_works_on_last_page()
    {
        $fileService = new FileServices();
        $response = $fileService->readFile(public_path('index.php'), 10, 5);
        $this->assertInstanceOf(PaginatorService::class, $response);
        $this->assertCount(5, $response->items());
        $this->assertFalse($response->hasMorePages());
        $this->assertFalse($response->onFirstPage());
    }

    public function test_memory_limit_on_large_file()
    {
        #test file with 100M size
        $fileService = new FileServices();
        $memory_before = (memory_get_usage() / 1024 / 1024);
        $response = $fileService->readFile(public_path('test_big_laravel.log'), 10, 5);
        $memory_after = (memory_get_usage() / 1024 / 1024);
        $memory_used = $memory_after - $memory_before;
        $this->assertLessThan(3, $memory_used);
    }
}
