<?php

namespace App\Providers;

use App\Repositories\Cadastro\CadastroRepository;
use App\Repositories\Assinatura\AssinaturaRepository;
use App\Repositories\Fatura\FaturaRepository;
use App\Models\Cadastro;
use App\Models\Assinatura;
use App\Models\Fatura;
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
        $this->app->bind(FaturaRepository::class, function ($app) {
            return new FaturaRepository(new Fatura());
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
