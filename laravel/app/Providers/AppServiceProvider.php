<?php

namespace App\Providers;

use App\Repositories\CadastroRepository;
use App\Models\Cadastro;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CadastroRepository::class, function ($app) {
            return new CadastroRepository(new Cadastro());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
