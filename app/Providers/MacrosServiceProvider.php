<?php

namespace App\Providers;

use Arr;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->array_recursive_combine();
    }

    public function array_recursive_combine()
    {
        Arr::macro('recursive_combine', function ($data, $over) {
            $combined = [];

            foreach ($data as $key => $element) {
                if (is_array($element)) {
                    $differentKeys = array_diff_key($over, $data);
                    if (isset($over[$key])) {
                        $combined[$key] = Arr::recursive_combine($element, $over[$key]);
                    } else {
                        $combined[$key] = $element;
                    }

                    foreach ($differentKeys as $keys => $elements) {
                        $combined[$keys] = $elements;
                    }
                } else {
                    $differentKeys = array_diff_key($over, $data);
                    if (isset($over[$key])) {
                        $combined[$key] = $over[$key];
                    } else {
                        $combined[$key] = $element;
                    }

                    if (! empty($differentKeys)) {
                        foreach ($differentKeys as $keys => $elements) {
                            $combined[$keys] = $elements;
                        }
                    }
                }
            }

            return $combined;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
