<?php

namespace App\Providers;

use App\Attivita;
use App\Cliente;
use App\Dipendente;
use App\Prenotazione;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->post_register_policies();
        $this->date_greater_than();
        $this->current_date_greater_than();
        $this->current_date_greater_than_equals();
        $this->unique_ditta_data_ora();
        $this->unique_camera_datain_dataout();
    }

    private function date_greater_than()
    {
        Validator::extend('date_greater_than', function ($attribute, $value, $parameters, $validator) {
            $first = Carbon::parse($value);
            $second = Carbon::parse($parameters[0]);
            return $first->greaterThan($second);
        }, "La data di fine deve essere maggiore della data di inizio");
    }

    private function current_date_greater_than()
    {
        Validator::extend('current_date_greater_than', function ($attribute, $value, $parameters, $validator) {
            $first = Carbon::parse($value);
            $second = Carbon::now();
            return $first->greaterThan($second);
        }, "La data inserita non è valida. Inserire una data maggiore rispetto alla data odierna");
    }

    private function current_date_greater_than_equals()
    {
        Validator::extend('current_date_greater_than_equals', function ($attribute, $value, $parameters, $validator) {
            $first = Carbon::parse($value);
            $second = Carbon::now();
            return $first->diffinDays($second, false) <= 0;
        }, "La data inserita non è valida. Inserire una data maggiore o uguale rispetto alla data odierna");
    }

    private function unique_ditta_data_ora()
    {
        Validator::extend('unique_ditta_data_ora', function ($attribute, $value, $parameters, $validator) {
            $count = Attivita::where('ditta_esterna_partita_iva', $value)
                ->where('data', $parameters[0])
                ->where('ora', $parameters[1])
                ->where('id', '!=', $parameters[2])
                ->count();
            return $count === 0;
        }, "La combinazione di attributi 'Ditta esterna, data, ora' esiste già");
    }

    private function unique_camera_datain_dataout()
    {
        Validator::extend('unique_camera_datain_dataout', function ($attribute, $value, $parameters, $validator) {
            $count = Prenotazione::where('camera_numero', $value)
                ->where('data_checkin', $parameters[0])
                ->where('data_checkout', $parameters[1])
                ->where('id', '!=', $parameters[2])
                ->count();
            return $count === 0;
        }, "La combinazione di attributi 'Camera, data checkin, data checkout' esiste già");
    }

    public function post_register_policies()
    {
        Gate::define('non_loggato', function (?User $user) {
            return Auth::guest();
        });
        Gate::define('dipendenti', function (?User $user) {
            if (auth()->user() == null) return false;
            $dipendente = Dipendente::where('user_id', auth()->user()->id)->first();
            return $dipendente == null ? false : true;
        });
        Gate::define('clienti', function (?User $user) {
            if (auth()->user() == null) return false;
            $cliente = Cliente::where('user_id', auth()->user()->id)->first();
            return $cliente == null ? false : true;
        });
    }
}
