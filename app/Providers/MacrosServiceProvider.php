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

    /**
     * Recursively combines A and B into one array
     * If key exists in A & B, B over writes A
     */
    public function array_recursive_combine()
    {
        Arr::macro('recursive_combine', function ($arrayA, $arrayB) {
            $combined = [];

            if (empty($arrayA) && ! empty($arrayB)) {
                $arrayA = $arrayB;
                $arrayB = [];
            }

            foreach ($arrayA as $key => $element) {
                if (is_array($element)) {
                    $differentKeys = array_diff_key($arrayB, $arrayA);
                    if (isset($arrayB[$key])) {
                        $combined[$key] = Arr::recursive_combine($element, $arrayB[$key]);
                    } else {
                        $combined[$key] = $element;
                    }

                    foreach ($differentKeys as $diffKey => $diffElement) {
                        $combined[$diffKey] = $diffElement;
                    }
                } else {
                    $differentKeys = array_diff_key($arrayB, $arrayA);
                    if (isset($arrayB[$key])) {
                        $combined[$key] = $arrayB[$key];
                    } else {
                        $combined[$key] = $element;
                    }

                    if (! empty($differentKeys)) {
                        foreach ($differentKeys as $diffKey => $diffElement) {
                            $combined[$diffKey] = $diffElement;
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
