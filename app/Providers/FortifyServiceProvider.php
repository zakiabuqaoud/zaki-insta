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
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        /*Auth::attempt([
                'email' => 'ahmed@example.com',
                'password' => '12345678'
            ]);*/
        //Auth::login($user);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', '=', $request->post('email'))
                //->orWhere('username', '=',  $request->post('email'))
                //->orWhere('mobile', '=',  $request->post('email'))
                ->first();

            $plainPassword = $request->post('password');
            if ($user && Hash::check($plainPassword, $user->password)) {
                return $user;
            }
        });

        Fortify::loginView('auth.login');
        Fortify::registerView('auth.register');
        //Fortify::confirmPasswordView('auth.')

    }
}
