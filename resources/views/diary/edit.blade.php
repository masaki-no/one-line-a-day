@extends('layouts.app')

@section('content')
<h2 class="bg-warning text-white bolder text-center">日記を編集</h2>

<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
    </div>
</div>

<form action="{{ route('diary.update', $id) }}" method="POST" class="offset-md-1 col-md-10 mb-5" enctype="multipart/form-data">
    @method('PUT')
    @csrf

    <div class="col-md-3 mb-3">
        <label for="date" class="form-label">日付</label>
        <input type="date" name="date" class="form-control" id="date" value = "{{ $date }}">

    </div>
    <div class="col-md-6 col-sm-8 mb-3">
        <label for="content" class="form-label">タイトル</label>
        <input type="text" name="title" class="form-control" id="title" value = "{{ $title }}">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">本文</label>
        <input type="text" name="content" class="form-control" id="content" value = "{{ $content }}">
    </div>
    <div class="mb-3">
        <label for="realize" class="form-label">気づき</label>
        <input type="text" name="realize" class="form-control" id="realize" value = "{{ $realize }}">
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">画像</label>
        <input type="file" id="file" name="file" class="form-control" value = "">
        <p class="mb-0 mt-1 text-info small">登録されている画像</p>
        @php
            $path = storage_path('app/public/img/' . $id . '/' . $id . '.*');
            $files = glob($path);
            $file_str = array_shift($files);
            $img_src = 'storage/' . substr($file_str, strpos($file_str, 'img'));
        @endphp
        <img src="{{ asset($img_src) }}" class="col-md-7 col-sm-8 col-12 border" alt="" onerror="this.src='/storage/img/noimage.jpg';">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary mt-3 px-5">修正する</button>
    </div>
</form>

<hr />
<a class="text-center" href="{{ route('diary.index') }}"><button class="btn btn-warning">日記一覧へ</button></a>

@endsection
