<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\Photo;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    public function index()
    {
        $wedding = Wedding::first();

        $photos = Photo::orderBy('sort_order')
            ->latest()
            ->get();

        return view('home', compact('wedding', 'photos'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bride_name' => [
                'required',
                'string',
                'max:255',
            ],
            'groom_name' => [
                'required',
                'string',
                'max:255',
            ],
            'wedding_date' => [
                'required',
                'date',
            ],
        ]);

        $wedding = Wedding::first();

        if (!$wedding) {
            Wedding::create($validated);
        } else {
            $wedding->update($validated);
        }

        return back()->with(
            'success',
            'Thông tin đám cưới đã được cập nhật.'
        );
    }
}
