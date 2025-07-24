<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::model('book', Book::class, function ($value) {
            throw (new ModelNotFoundException)->setModel(Book::class, $value);
        });
        
        // Or alternatively for explicit binding:
        Route::bind('bookToUpdate', function ($value) {
            return Book::findOrFail($value);
        });
    }
}