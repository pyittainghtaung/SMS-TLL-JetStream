<?php

use App\Livewire\Academic;
use App\Livewire\Category;
use App\Livewire\Grade;
use App\Livewire\Hostel;
use App\Livewire\Permission;
use App\Livewire\Product;
use App\Livewire\Role;
use App\Livewire\Section;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('academics', Academic::class)->name('academics');
    Route::get('grades', Grade::class)->name('grades');
    Route::get('sections', Section::class)->name('sections');
    Route::get('hostels', Hostel::class)->name('hostels');
    Route::get('categories', Category::class)->name('categories');
    Route::get('products', Product::class)->name('products');
    Route::get('permissions', Permission::class)->name('permissions');
    Route::get('roles', Role::class)->name('roles');
    Route::get('users', User::class)->name('users');
});
