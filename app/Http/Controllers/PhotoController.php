<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::orderBy('sort_order')
            ->latest()
            ->get();

        return view('home', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $path = $request->file('image')->store(
            'wedding',
            'public'
        );

        $lastSortOrder = Photo::max('sort_order');

        $sortOrder = $lastSortOrder === null
            ? 1
            : $lastSortOrder + 1;

        Photo::create([
            'image' => $path,
            'title' => $request->title,
            'sort_order' => $sortOrder,
        ]);

        return back()->with(
            'success',
            'Ảnh cưới đã được tải lên thành công.'
        );
    }

    public function destroy(Photo $photo)
    {
        if (
            $photo->image &&
            Storage::disk('public')->exists($photo->image)
        ) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return back()->with(
            'success',
            'Ảnh cưới đã được xóa thành công.'
        );
    }
}
