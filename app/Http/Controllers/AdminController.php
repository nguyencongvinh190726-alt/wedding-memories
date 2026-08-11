<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $wedding = Wedding::first();

        $photos = Photo::orderBy('sort_order')
            ->latest()
            ->get();

        return view('admin', compact('wedding', 'photos'));
    }

    public function updateWedding(Request $request)
    {
        $validated = $request->validate([
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_name' => ['required', 'string', 'max:255'],
            'wedding_date' => ['required', 'date'],
        ]);

        $wedding = Wedding::first();

        if (!$wedding) {
            Wedding::create($validated);
        } else {
            $wedding->update($validated);
        }

        return back()->with(
            'success',
            'Thông tin đám cưới đã được lưu.'
        );
    }

    public function uploadPhotos(Request $request)
    {
        $request->validate([
            'photos' => [
                'required',
                'array',
                'min:1',
                'max:100',
            ],

            'photos.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:20480',
            ],
        ]);

        $photos = $request->file('photos');

        $lastSortOrder = Photo::max('sort_order');

        $sortOrder = $lastSortOrder === null
            ? 1
            : $lastSortOrder + 1;

        $uploadedCount = 0;

        foreach ($photos as $image) {
            $path = $image->store('wedding', 'public');

            Photo::create([
                'image' => $path,
                'title' => null,
                'sort_order' => $sortOrder,
            ]);

            $sortOrder++;
            $uploadedCount++;
        }

        return back()->with(
            'success',
            "{$uploadedCount} ảnh cưới đã được tải lên thành công."
        );
    }

    public function setCover(Photo $photo)
    {
        $wedding = Wedding::first();

        if (!$wedding) {
            $wedding = Wedding::create([
                'bride_name' => 'Bride',
                'groom_name' => 'Groom',
                'wedding_date' => now()->toDateString(),
            ]);
        }

        $wedding->update([
            'cover_image' => $photo->image,
        ]);

        return back()->with(
            'success',
            'Đã chọn ảnh làm ảnh Cover.'
        );
    }

    public function deletePhoto(Photo $photo)
    {
        $wedding = Wedding::first();

        if (
            $wedding &&
            $wedding->cover_image === $photo->image
        ) {
            $wedding->update([
                'cover_image' => null,
            ]);
        }

        if (
            $photo->image &&
            Storage::disk('public')->exists($photo->image)
        ) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return back()->with(
            'success',
            'Ảnh đã được xóa.'
        );
    }
}
