<?php

use App\Livewire\Academic;
use App\Livewire\Category;
use App\Livewire\Grade;
use App\Livewire\Hostel;
use App\Livewire\Permission;
use App\Livewire\Product;
use App\Livewire\Role;
use App\Livewire\Section;
use App\Livewire\Student;
use App\Livewire\Teacher;
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
    Route::get('academics/{academic}/grades', Grade::class)->name('grades');
    Route::get('grades/{grade}/sections', Section::class)->name('sections');
    Route::get('academic/{academic}/hostels', Hostel::class)->name('hostels');
    Route::get('academic/{academic}/students', Student::class)->name('students');
    Route::get('academic/{academic}/teachers', Teacher::class)->name('teachers');

    Route::get('categories', Category::class)->name('categories');
    Route::get('products', Product::class)->name('products');

    Route::get('permissions', Permission::class)->name('permissions');
    Route::get('roles', Role::class)->name('roles');
    Route::get('users', User::class)->name('users');
});
