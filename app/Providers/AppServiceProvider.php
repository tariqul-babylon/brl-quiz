<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Blade::directive('err', function ($field) {
            return "<?php echo \$errors->has($field) ? 'is-invalid' : ''; ?>";
        });

        Blade::directive('errtext', function ($field) {
            return "<?php echo \$errors->has($field) ? '<small class=\"text-danger\">' . \$errors->first($field) . '</small>' : ''; ?>";
        });

        Paginator::useBootstrapFive();
    }
}
