<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::namespace("App\Http\Livewire")->group(function () {
    Route::get('/', Home::class)->name("home");
    Route::get('/home', Home::class);


});

Route::middleware(['guest'])->namespace("App\Http\Livewire")->group(function () {
    Route::get('/login', Login::class)->name("login");


});

Route::middleware(['auth'])->namespace("App\Http\Livewire\Admin")->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/menus', Menus::class)->name('menus');
    Route::get('/menus/create', CreateUpdateMenu::class)->name('menus-create');
    Route::get('/menus/edit/{menu_id}', CreateUpdateMenu::class)->name('menus-edit');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/categories/create', CreateUpdateCategory::class)->name('categories-create');
    Route::get('/categories/edit/{category_id}', CreateUpdateCategory::class)->name('categories-edit');
    Route::get('/foods', Foods::class)->name('foods');
    Route::get('/foods/create', CreateUpateFood::class)->name('foods-create');
    Route::get('/foods/edit/{food_id}', CreateUpateFood::class)->name('foods-edit');
    Route::get('/slides', Slides::class)->name('slides');
    Route::get('/slides/create', Slides::class)->name('slides-create');
    Route::get('/slides/edit', Slides::class)->name('slides-edit');

    Route::get('/foods/popular', PopularFoods::class)->name('popular-foods');
    Route::get('/foods/popular/create', PopularFoods::class)->name('popular-foods-create');
    Route::get('/foods/popular/edit/{item_id}', PopularFoods::class)->name('popular-foods-edit');
    Route::get('/sms/send', Sms::class)->name('sms-send');
    Route::get('/sms/template', Sms::class)->name('sms-template');
    Route::get('/sms', Sms::class)->name('sms');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/users', Users::class)->name('users');
    Route::get('/users/create', Users::class)->name('users-create');
    Route::get('/users/edit/{user_id}', Users::class)->name('users-edit');
    Route::get('/logout', function (\Illuminate\Http\Request $request){
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/login');
    })->name('logout');


});
