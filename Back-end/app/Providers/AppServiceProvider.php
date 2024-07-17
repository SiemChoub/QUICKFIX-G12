<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Mailsetting;
use Config;
use App\Models\Booking;
use App\Models\FixingProgress;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Service;
use App\Models\User;

use Schema;

class AppServiceProvider extends ServiceProvider
{
    /*
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /*
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('mailsettings')) {
            $mailsetting = Mailsetting::first();
            if($mailsetting){
                $data = [
                    'driver'            => $mailsetting->mail_transport,
                    'host'              => $mailsetting->mail_host,
                    'port'              => $mailsetting->mail_port,
                    'encryption'        => $mailsetting->mail_encryption,
                    'username'          => $mailsetting->mail_username,
                    'password'          => $mailsetting->mail_password,
                    'from'              => [
                        'address' => $mailsetting->mail_from,
                        'name'    => 'LaravelStarter'
                    ]
                ];
                Config::set('mail', $data);
            }
        }

        if (Schema::hasTable('bookings') && Schema::hasTable('fixing_progress') && Schema::hasTable('categories') && Schema::hasTable('services') && Schema::hasTable('users') && Schema::hasTable('feedback')){
            view()->share(['bookings' => Booking::all(), 'FixingProgress' => FixingProgress::all(),'Categories'=>Category::all(),'Service'=> Service::all(),'users'=> User::all(), 'feedbacks'=>Feedback::all()]);
        }

    }
}
