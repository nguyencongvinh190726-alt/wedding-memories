<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\AdminController;

// Trang chủ
Route::get('/', [WeddingController::class, 'index'])
    ->name('home');

// Trang quản trị
Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin');

// Lưu thông tin cô dâu, chú rể, ngày cưới
Route::post('/admin/wedding', [AdminController::class, 'updateWedding'])
    ->name('admin.wedding.update');

// Upload nhiều ảnh
Route::post('/admin/photos', [AdminController::class, 'uploadPhotos'])
    ->name('admin.photos.upload');

// Chọn ảnh làm Cover
Route::post('/admin/photos/{photo}/cover', [AdminController::class, 'setCover'])
    ->name('admin.photos.cover');

// Xóa ảnh
Route::delete('/admin/photos/{photo}', [AdminController::class, 'deletePhoto'])
    ->name('admin.photos.delete');