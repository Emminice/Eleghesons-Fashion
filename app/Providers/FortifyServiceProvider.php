<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate limiting for login
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate limiting for two-factor
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });

        // Role-based login redirection
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $role = auth()->user()->role;

                    return match ($role) {
                        'admin' => redirect()->route('admin.dashboard'),
                        'agent' => redirect()->route('agent.dashboard'),
                        'buyer' => redirect()->route('buyer.dashboard'),
                        default => redirect('/'),
                    };
                }
            };
        });
    }
}


        // ✅ ROLE-BASED LOGIN REDIRECTION (CORRECT WAY)
        // $this->app->singleton(LoginResponse::class, function () {
        //     return new class implements LoginResponse {
        //         public function toResponse($request)
        //         {
        //             $user = auth()->user();

        //             return match ($user->role) {
        //                 'admin' => redirect()->route('admin.dashboard'),
        //                 'agent' => redirect()->route('agent.dashboard'),
        //                 'buyer' => redirect()->route('buyer.dashboard'),
        //                 default => redirect('/'),
        //             };
        //         }
        //     };
        // });

