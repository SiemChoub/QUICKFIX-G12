<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Mailsetting;
use Config;
use App\Models\Booking;
use App\Models\FixingProgress;
<<<<<<< HEAD
use App\Models\Chat;
use App\Models\Category;
use App\Models\Feedback;
=======
use App\Models\Category;
>>>>>>> b19eb38ff361c44e7f5883fd6b8534771c1c8c0f
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

<<<<<<< HEAD
            
        if (Schema::hasTable('bookings') && Schema::hasTable('fixing_progress') && Schema::hasTable('categories') && Schema::hasTable('services') && Schema::hasTable('users')&& Schema::hasTable('Chats')&& Schema::hasTable('feedback')){
            view()->share(['bookings' => Booking::all(), 'FixingProgress' => FixingProgress::all(),'Categories'=>Category::all(),'Service'=> Service::all(),'users'=> User::all() ,'messages' => Chat::all(), 'feedbacks'=>Feedback::all()]);
=======
        if (Schema::hasTable('bookings') && Schema::hasTable('fixing_progress') && Schema::hasTable('categories') && Schema::hasTable('services') && Schema::hasTable('users')){
            view()->share(['bookings' => Booking::all(), 'FixingProgress' => FixingProgress::all(),'Categories'=>Category::all(),'Service'=> Service::all(),'User'=> User::all() ]);
>>>>>>> b19eb38ff361c44e7f5883fd6b8534771c1c8c0f

        }

    }
}
