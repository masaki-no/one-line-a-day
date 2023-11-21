<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diary = new Diary;
        $list = $diary->orderBy('date', 'desc')->paginate(5);
        $count = $diary->count();
        return view('diary.index', [
            'list' => $list,
            'count' => $count,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $diary = new Diary;
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|max:50',
            'content' => 'required|max:255',
            'realize' => 'max:255',
            'file' => 'image',
        ]);

        $diary->date = $request->date;
        $diary->title = $request->title;
        $diary->content = $request->content;
        $diary->realize = $request->realize;

        $file = $request->file('file');
        $diary->save();
        if (isset($file)) {
            $file_name = $file->getClientOriginalExtension();
            $request->file('file')->storeAs('public/img/', $diary->id . '/' . $diary->id . '.' . $file_name);
        }
        $list = $diary->orderBy('date', 'desc')->paginate(5);
        $count = $diary->count();

        return view('diary.index', [
            'list' => $list,
            'count' => $count,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Diary $diary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diary $diary)
    {
        return view('diary.edit', [
            'id' => $diary->id,
            'date' => $diary->date,
            'title' => $diary->title,
            'content' => $diary->content,
            'realize' => $diary->realize,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diary $diary)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|max:50',
            'content' => 'required|max:255',
            'realize' => 'max:255',
            'file' => 'image',
        ]);
        $diary->date = $request->date;
        $diary->title = $request->title;
        $diary->content = $request->content;
        $diary->realize = $request->realize;

        $diary->save();
        $file = $request->file('file');
        if (isset($file)) {
            $file_name = $file->getClientOriginalExtension();
            $path = storage_path('app/public/img/' . $diary->id . '/' . $diary->id . '.*');
            $files = glob($path);
            $file_str = array_shift($files);
            $img_src = 'storage/' . substr($file_str, strpos($file_str, 'img'));

            Storage::disk('public')->delete(substr($file_str, strpos($file_str, 'img')));

            $request->file('file')->storeAs('public/img/', $diary->id . '/' . $diary->id . '.' . $file_name);
        }

        $list = $diary->orderBy('date', 'desc')->paginate(5);
        $count = $diary->count();

        return view('diary.index', [
            'list' => $list,
            'count' => $count,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diary $diary)
    {
        $id = $diary->id;
        $path = 'img/' . $diary->id;
        Storage::disk('public')->deleteDirectory($path);
        $diary->where('id', $id)->delete();
        return redirect('/diary');
    }
}
