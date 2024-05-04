<?php

namespace App\Providers;

use App\Repositories\CadastroRepository;
use App\Repositories\AssinaturaRepository;
use App\Models\Cadastro;
use App\Models\Assinatura;
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
        $this->app->bind(AssinaturaRepository::class, function ($app) {
            return new AssinaturaRepository(new Assinatura());
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
