@extends('layouts.app')

@section('content')
    <h2 class="bg-warning text-white bolder text-center mb-3">日記 一覧</h2>
    <div class="text-center">
        <a href="{{ route('diary.create') }}">
            <button type="button" class="btn btn-light border rounded mb-3 px-5"><i class="fas fa-pen-nib"
                    style="color: #ff8040; font-size:3rem"></i><span class="">日記を書く</span></button>
        </a>
    </div>

    @foreach ($list as $diary)
        <div class="card mb-3 col-md-8 offset-md-2 col-10 offset-1 px-0">
            <div class="row g-0">
                <div class="col-md-4 col-12">
                    @php
                        $path = storage_path('app/public/img/' . $diary->id . '/' . $diary->id . '.*');
                        $files = glob($path);
                        $file_str = array_shift($files);
                        $img_src = 'storage/' . substr($file_str, strpos($file_str, 'img'));
                    @endphp
                    <img src="{{ asset($img_src) }}" class="h-100 w-100 rounded" alt=""
                        onerror="this.src='/storage/img/noimage.jpg';" style="object-fit: cover; max-height: 16rem;">
                </div>
                <div class="col-md-6 col-9">
                    <div class="card-body">
                        <p class="h4 mt-0 text-secondary"><small class="text-body-secondary">{{ $diary->date }}</small></p>
                        <p class="small mb-0 text-info border-bottom">タイトル</p>
                        <h3 class="card-title bolder">{{ $diary->title }}</h3>
                        <p class="small mb-0 text-info border-bottom">本文</p>
                        <p class="h4">{{ $diary->content }}</p>
                        <p class="small mb-0 text-info border-bottom">気づき</p>
                        <p class="">{{ $diary->realize ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-2 col-3">
                    <div class="h-50 bg-light border-start border-bottom">
                        <form class="h-100" action="{{ route('diary.edit', $diary->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn w-100 h-100"><i class="far fa-edit"
                                    style="color: #ff8040; font-size:3rem"></i></button>
                        </form>
                    </div>
                    <div class="h-50 bg-light border-start">
                        <form class="h-100" action="{{ route('diary.destroy', $diary->id) }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn w-100 h-100"
                                onclick="return confirm('「{{ $diary->title }}」を削除してよろしいですか?')"><i class="fas fa-trash-alt"
                                    style="color: #ff8040; font-size:3rem"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <p class="text-center">投稿件数:{{ @$count }}件</p>
    <div class="d-flex justify-content-center">{{ $list->links() }}</div>
@endsection
