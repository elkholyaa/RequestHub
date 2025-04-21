<?php
/**
 * Sort Helper
 * 
 * This file contains helper functions for sorting requests and generating
 * sort links with the appropriate CSS classes and attributes.
 */

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SortHelper
{
    /**
     * Generate a sort URL for a table column
     *
     * @param string $column The database column to sort by
     * @param Request $request The current request
     * @param array $additionalParams Any additional query parameters to include
     * @return string The sort URL
     */
    public static function sortUrl(string $column, Request $request, array $additionalParams = []): string
    {
        // Determine the current sort direction
        $currentSort = $request->get('sort');
        $currentDirection = $request->get('direction');
        
        // Calculate the new direction
        $newDirection = 'asc';
        if ($currentSort === $column && $currentDirection === 'asc') {
            $newDirection = 'desc';
        }
        
        // Merge parameters
        $params = array_merge(
            $request->except(['sort', 'direction']), 
            ['sort' => $column, 'direction' => $newDirection],
            $additionalParams
        );
        
        // Generate the URL
        return route(Route::currentRouteName(), $params);
    }
    
    /**
     * Generate CSS classes for a sort indicator
     *
     * @param string $column The database column to check
     * @param Request $request The current request
     * @return string The CSS classes
     */
    public static function sortClass(string $column, Request $request): string
    {
        $currentSort = $request->get('sort');
        $currentDirection = $request->get('direction');
        
        $classes = 'sort-indicator';
        
        if ($currentSort === $column) {
            $classes .= ' ' . ($currentDirection === 'asc' ? 'asc' : 'desc');
        }
        
        return $classes;
    }
} 