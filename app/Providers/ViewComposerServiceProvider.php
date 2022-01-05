<?php

namespace App\Providers;

use App\Backup\BackupStatusReader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.backup-link', function ($view) {
            $view->with('backup', app(BackupStatusReader::class));
        });

        Blade::directive('sprites', function () {
            return '<?php echo str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?><!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">", "", file_get_contents(base_path("resources/svg/sprites.svg"))); ?>';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
