<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Buyer\Properties;
use App\Livewire\Properties\Index;
use App\Livewire\Home\PropertyList;
use App\Livewire\Agent\PropertyCrud;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\PropertyDetails;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\PropertyApproval;


/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| Main Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if (! $user) {
            return redirect('/login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            'buyer' => redirect()->route('buyer.dashboard'),
            default => redirect('/'),
        };
    })->middleware(['auth', 'verified'])->name('dashboard');
}); 



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:agent'])
    ->prefix('agent')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('agent.dashboard');
        })->name('agent.dashboard');
    });

/*
|--------------------------------------------------------------------------
| Buyer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:buyer'])
    ->prefix('buyer')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('buyer.dashboard');
        })->name('buyer.dashboard');
    });


/*
|--------------------------------------------------------------------------
| Property Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/properties', PropertyList::class)->name('properties.index');

Route::get('/property/{id}', PropertyDetails::class)->name('property.details'); 

Route::get('/properties', Index::class)
    ->name('properties.index'); 


/*
|--------------------------------------------------------------------------
| Agent Property CRUD Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/properties', PropertyCrud::class)->name('agent.properties');
});





// Buyer
Route::middleware(['auth', 'verified', 'role:buyer'])->group(function () {
    Route::get('/properties', Properties::class)->name('buyer.properties');
});


// Admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard-panel', Dashboard::class)->name('admin.dashboard-panel');

    // Property Approval Page 
    Route::get('/admin/properties/pending', PropertyApproval::class)->name('admin.properties.pending');
});
