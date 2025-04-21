<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        // Register a simple Blade directive for sorting
        Blade::directive('sortLink', function ($expression) {
            // Parse the expression string
            $args = explode(',', str_replace(['(', ')', ' ', "'", '"'], '', $expression));
            $column = $args[0] ?? 'id';
            $label = $args[1] ?? ucfirst($column);
            
            return "<?php
                \$currentSort = request('sort');
                \$currentDirection = request('direction');
                \$newDirection = 'asc';
                
                if (\$currentSort === '{$column}' && \$currentDirection === 'asc') {
                    \$newDirection = 'desc';
                }
                
                \$sortUrl = route(request()->route()->getName(), array_merge(
                    request()->except(['sort', 'direction']),
                    ['sort' => '{$column}', 'direction' => \$newDirection]
                ));
                
                \$sortClass = 'sort-indicator';
                if (\$currentSort === '{$column}') {
                    \$sortClass .= ' ' . (\$currentDirection === 'asc' ? 'asc' : 'desc');
                }
                
                echo '<a href=\"' . \$sortUrl . '\" class=\"' . \$sortClass . '\" data-sort=\"{$column}\">
                    {$label}
                    <svg class=\"sort-indicator-icon\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\">
                        <path fill-rule=\"evenodd\" d=\"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z\" clip-rule=\"evenodd\" />
                    </svg>
                </a>';
            ?>";
        });
    }
}
