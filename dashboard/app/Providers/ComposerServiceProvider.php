<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->view->composers([
            'App\Http\ViewComposers\YourComposer' => 'your.view',
        ]);
    }

}
