<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Utilisation dans les vues : @fcfa($produit->price)
        Blade::directive('fcfa', function ($expression) {
            return "<?php echo number_format((float) ($expression), 0, ',', ' ') . ' FCFA'; ?>";
        });
    }
}