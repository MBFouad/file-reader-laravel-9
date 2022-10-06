<?php

namespace App\Http\Controllers;

use App\Exceptions\MyCustomException;
use App\Http\Requests\FileReaderRequest;
use App\Services\FileServices;
use App\Services\PaginatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    private $fileService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fileService = new FileServices();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reader(FileReaderRequest $request)
    {
        $this->fileService->checkFile($request->file); #validate file

        /** @var PaginatorService $paginator */
        $paginator = $this->fileService->readFile($request->file, 10, $request->page ?? 1);

        $html = view('file_paginator', compact('paginator'))->render();

        return response()->json(['html' => $html]);
    }
}
