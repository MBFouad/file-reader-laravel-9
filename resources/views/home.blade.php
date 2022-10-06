@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">File Reader</div>

                    <div class="card-body">
                        <form action="{{route('file.reader')}}" method="get" id="file-reader-form">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="file" class="col-form-label">File</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" required value="{{ old('file') }}" name="file" id="file"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="/path/to/file">
                                    @error('file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-auto ">
                                    <button type="submit" class="btn btn-primary">Load</button>
                                </div>
                            </div>
                        </form>
                        @include('reader')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
