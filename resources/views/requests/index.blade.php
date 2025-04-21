@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header Area with Title + Action Button -->
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-semibold text-gray-800">
            {{ Auth::user()->hasRole('administrator') ? 'All Requests' : 'My Requests' }}
            @if(isset($stats))
            <span class="text-sm text-gray-500 ml-2">({{ $stats['total'] ?? 0 }} total)</span>
            @endif
        </h1>
        <a href="{{ route('requests.create') }}"
           class="bg-red-600 text-white px-5 py-2 rounded-md shadow-sm hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 text-sm font-medium">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Request
            </span>
        </a>
    </div>

    <!-- Status Summary Cards -->
    @if(isset($stats))
    <div class="grid grid-cols-3 gap-4 mb-5">
        <a href="{{ route('requests.index', array_merge(request()->except('status'), ['status' => 'pending', 'page' => 1])) }}" 
           class="stats-card stats-card-pending group">
            <div class="flex-1">
                <div class="text-xs uppercase text-gray-500 font-medium">Pending</div>
                <div class="text-lg font-bold text-gray-800">{{ $stats['pending'] }}</div>
            </div>
            <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-medium">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </a>
        <a href="{{ route('requests.index', array_merge(request()->except('status'), ['status' => 'in_progress', 'page' => 1])) }}"
           class="stats-card stats-card-in-progress group">
            <div class="flex-1">
                <div class="text-xs uppercase text-gray-500 font-medium">In Progress</div>
                <div class="text-lg font-bold text-gray-800">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition-medium">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
        </a>
        <a href="{{ route('requests.index', array_merge(request()->except('status'), ['status' => 'completed', 'page' => 1])) }}"
           class="stats-card stats-card-completed group">
            <div class="flex-1">
                <div class="text-xs uppercase text-gray-500 font-medium">Completed</div>
                <div class="text-lg font-bold text-gray-800">{{ $stats['completed'] }}</div>
            </div>
            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition-medium">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </a>
    </div>
    @endif

    <!-- Filters Area - Compact Version -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-5 border border-gray-100">
        <form method="GET" action="{{ route('requests.index') }}" class="space-y-3">
            <!-- Hidden sort params -->
            @if(request()->filled('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if(request()->filled('direction'))
                <input type="hidden" name="direction" value="{{ request('direction') }}">
            @endif
            
            <div class="flex flex-col md:flex-row md:space-x-4">
                <!-- Search -->
                <div class="md:w-1/3 mb-3 md:mb-0">
                    <label for="search" class="filter-label">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search title or description..."
                            class="filter-input pl-10"
                        >
                    </div>
                </div>
                
                <div class="flex md:w-2/3 flex-wrap gap-2">
                    <!-- Status Filter -->
                    <div class="w-full sm:w-auto flex-1 min-w-[120px]">
                        <label for="status" class="filter-label">Status</label>
                        <select 
                            name="status" 
                            id="status" 
                            class="filter-input"
                        >
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <!-- Priority Filter -->
                    <div class="w-full sm:w-auto flex-1 min-w-[120px]">
                        <label for="priority" class="filter-label">Priority</label>
                        <select 
                            name="priority" 
                            id="priority" 
                            class="filter-input"
                        >
                            <option value="">All Priorities</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    
                    <!-- Type Filter -->
                    <div class="w-full sm:w-auto flex-1 min-w-[120px]">
                        <label for="type" class="filter-label">Type</label>
                        <select 
                            name="type" 
                            id="type" 
                            class="filter-input"
                        >
                            <option value="">All Types</option>
                            <option value="service" {{ request('type') === 'service' ? 'selected' : '' }}>Service</option>
                            <option value="maintenance" {{ request('type') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    
                    <!-- Filter Button -->
                    <div class="w-full sm:w-auto flex items-end">
                        <button 
                            type="submit" 
                            class="w-full bg-indigo-600 text-white py-2 px-4 text-sm rounded-md hover:bg-indigo-700 transition-colors flex items-center justify-center"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Active Filters Tags -->
            @if(request('search') || request('status') || request('priority') || request('type'))
            <div class="flex flex-wrap gap-2 pt-3 mt-3 border-t border-gray-100">
                <span class="text-xs text-gray-500">Active filters:</span>
                
                @if(request('search'))
                <span class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-full text-xs">
                    Search: "{{ request('search') }}"
                    <a href="{{ route('requests.index', array_merge(request()->except('search'), ['page' => 1])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </span>
                @endif
                
                @if(request('status'))
                <span class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-full text-xs">
                    Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                    <a href="{{ route('requests.index', array_merge(request()->except('status'), ['page' => 1])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </span>
                @endif
                
                @if(request('priority'))
                <span class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-full text-xs">
                    Priority: {{ ucfirst(request('priority')) }}
                    <a href="{{ route('requests.index', array_merge(request()->except('priority'), ['page' => 1])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </span>
                @endif
                
                @if(request('type'))
                <span class="inline-flex items-center bg-gray-100 px-2 py-1 rounded-full text-xs">
                    Type: {{ ucfirst(request('type')) }}
                    <a href="{{ route('requests.index', array_merge(request()->except('type'), ['page' => 1])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </span>
                @endif
                
                <a href="{{ route('requests.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 ml-1 font-medium">Clear all</a>
            </div>
            @endif
        </form>
    </div>

    <!-- Table of Requests -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-100">
        @if(count($requests) > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('requests.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'id', 'direction' => (request('sort') === 'id' && request('direction') === 'asc') ? 'desc' : 'asc'])) }}" class="group flex items-center space-x-1">
                            <span>#</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('requests.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'title', 'direction' => (request('sort') === 'title' && request('direction') === 'asc') ? 'desc' : 'asc'])) }}" class="group flex items-center space-x-1">
                            <span>Title</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('requests.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'type', 'direction' => (request('sort') === 'type' && request('direction') === 'asc') ? 'desc' : 'asc'])) }}" class="group flex items-center space-x-1">
                            <span>Type</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('requests.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'status', 'direction' => (request('sort') === 'status' && request('direction') === 'asc') ? 'desc' : 'asc'])) }}" class="group flex items-center space-x-1">
                            <span>Status</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <a href="{{ route('requests.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'priority', 'direction' => (request('sort') === 'priority' && request('direction') === 'asc') ? 'desc' : 'asc'])) }}" class="group flex items-center space-x-1">
                            <span>Priority</span>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($requests as $item)
                <tr class="transition-colors hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">#{{ $item->id }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->title }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($item->type) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <span class="status-badge status-badge-{{ $item->status }}">
                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                        <span class="priority-badge priority-badge-{{ $item->priority }}">
                            {{ ucfirst($item->priority) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-medium">
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('requests.show', $item) }}"
                               class="action-button action-button-primary">
                               <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                               </svg>
                               View
                            </a>
                            <a href="{{ route('requests.edit', $item) }}" 
                               class="action-button action-button-secondary">
                               <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                               </svg>
                               Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No requests found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(request('search') || request('status') || request('priority') || request('type'))
                    Try adjusting your search or filter criteria.
                @else
                    Get started by creating a new request.
                @endif
            </p>
            <div class="mt-6">
                <a href="{{ route('requests.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Request
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Pagination with improved styling -->
    @if($requests->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-lg mt-3 shadow-sm">
        <div class="flex-1 flex justify-between sm:hidden">
            @if($requests->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                    Previous
                </span>
            @else
                <a href="{{ $requests->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
            @endif
            
            @if($requests->hasMorePages())
                <a href="{{ $requests->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                    Next
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing 
                    <span class="font-medium">{{ $requests->firstItem() ?: 0 }}</span>
                    to 
                    <span class="font-medium">{{ $requests->lastItem() ?: 0 }}</span>
                    of 
                    <span class="font-medium">{{ $requests->total() }}</span>
                    results
                </p>
            </div>
            <div>
                {{ $requests->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

<style>
/* Add custom styles for status badges and priority badges */
.status-badge {
    @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
}
.status-badge-pending {
    @apply bg-amber-100 text-amber-800;
}
.status-badge-in_progress {
    @apply bg-indigo-100 text-indigo-800;
}
.status-badge-completed {
    @apply bg-emerald-100 text-emerald-800;
}

.priority-badge {
    @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
}
.priority-badge-low {
    @apply bg-emerald-100 text-emerald-800;
}
.priority-badge-medium {
    @apply bg-amber-100 text-amber-800;
}
.priority-badge-high {
    @apply bg-red-100 text-red-800;
}

.action-button {
    @apply inline-flex items-center px-2 py-1 text-xs font-medium rounded transition-colors;
}
.action-button-primary {
    @apply bg-indigo-100 text-indigo-700 hover:bg-indigo-200;
}
.action-button-secondary {
    @apply bg-red-100 text-red-700 hover:bg-red-200;
}

/* Status cards styling */
.stats-card {
    @apply flex items-center p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow transition-shadow;
}
.stats-card-pending {
    @apply border-l-4 border-amber-400;
}
.stats-card-in-progress {
    @apply border-l-4 border-indigo-400;
}
.stats-card-completed {
    @apply border-l-4 border-emerald-400;
}

/* Form styles */
.filter-label {
    @apply block text-xs font-medium text-gray-700 mb-1;
}
.filter-input {
    @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm;
}
</style>
