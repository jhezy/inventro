<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Kirim data notifikasi ke semua view
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user) {
                $notifications = DB::table('notifications')
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();

                $notifOn = $notifications->contains('is_read', 0);

                $view->with(compact('notifications', 'notifOn'));
            }
        });
    }
}
