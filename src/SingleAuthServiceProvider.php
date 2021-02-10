<?php
namespace Julfiker\SingleAuth;

use Illuminate\Support\ServiceProvider;

/**
 * A service provider to integrate with laravel application
 *
 * @author Julfiker <mail.julfiker@gmail.com>
 * Class SingleAuthServiceProvider
 * @package Julfiker\SingleAuth
 */
class SingleAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/routes/route.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Julfiker\SingleAuth\ExternalAuthorizeController');
    }
}
