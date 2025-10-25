<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Telescope hanya di local
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set locale dan timezone
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Makassar');

        // View Composer untuk notifikasi
        View::composer('*', function ($view) {
            $user = Auth::user();

            if ($user && $user->hasAnyRole(['administrator', 'kepsek'])) {
                // Ambil 5 notifikasi terbaru
                $notifications = DB::table('notifications')
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();

                // Hitung jumlah yang belum dibaca
                $unreadCount = $notifications->where('is_read', false)->count();

                // Kirim ke semua view
                $view->with(compact('notifications', 'unreadCount'));
            }
        });
    }
}
