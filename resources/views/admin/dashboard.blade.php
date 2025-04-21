@extends('layouts.app')

@section('content')
<div class="container mx-auto py-5">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <div class="mb-4 md:mb-0">
            <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-sm text-gray-600">Welcome to the administration area</p>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('requests.create') }}" class="inline-flex items-center bg-red-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-red-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                New Request
            </a>
            <a href="{{ route('requests.index') }}?priority=high" class="inline-flex items-center bg-red-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-red-700 transition-colors text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                High Priority
            </a>
        </div>
    </div>

    <!-- Quick Stats Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-xs uppercase text-gray-500 font-medium">Users</div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-amber-500 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-xs uppercase text-gray-500 font-medium">Pending</div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Request::where('status', 'pending')->count() }}</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-violet-500 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-xs uppercase text-gray-500 font-medium">In Progress</div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Request::where('status', 'in_progress')->count() }}</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-emerald-500 hover:shadow transition-shadow">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-xs uppercase text-gray-500 font-medium">Completed</div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Request::where('status', 'completed')->count() }}</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Request Status Chart -->
            <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">Request Status Distribution</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ \App\Models\Request::count() }} Total
                    </span>
                </div>
                
                <div class="relative">
                    @php
                        $pending = \App\Models\Request::where('status', 'pending')->count();
                        $inProgress = \App\Models\Request::where('status', 'in_progress')->count();
                        $completed = \App\Models\Request::where('status', 'completed')->count();
                        $total = max(1, $pending + $inProgress + $completed); // Avoid division by zero
                        
                        $pendingWidth = ($pending / $total) * 100;
                        $inProgressWidth = ($inProgress / $total) * 100;
                        $completedWidth = ($completed / $total) * 100;
                    @endphp
                    
                    <!-- Chart bars with improved styling -->
                    <div class="flex h-7 mb-5 w-full rounded-lg overflow-hidden shadow-inner bg-gray-100">
                        <div class="bg-amber-500 h-full" style="width: {{ $pendingWidth }}%"></div>
                        <div class="bg-violet-500 h-full" style="width: {{ $inProgressWidth }}%"></div>
                        <div class="bg-emerald-500 h-full" style="width: {{ $completedWidth }}%"></div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-amber-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Pending ({{ $pending }})</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-violet-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">In Progress ({{ $inProgress }})</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-700">Completed ({{ $completed }})</span>
                        </div>
                    </div>
                </div>
                
                <!-- Priority distribution -->
                <h3 class="text-md font-medium mt-7 mb-4 text-gray-800">Priority Distribution</h3>
                <div class="space-y-4">
                    @php
                        $highCount = \App\Models\Request::where('priority', 'high')->count();
                        $mediumCount = \App\Models\Request::where('priority', 'medium')->count();
                        $lowCount = \App\Models\Request::where('priority', 'low')->count();
                        $priorityTotal = max(1, $highCount + $mediumCount + $lowCount);
                        
                        $highPercent = ($highCount / $priorityTotal) * 100;
                        $mediumPercent = ($mediumCount / $priorityTotal) * 100;
                        $lowPercent = ($lowCount / $priorityTotal) * 100;
                    @endphp
                    
                    <div class="flex items-center">
                        <span class="text-xs w-14 font-medium text-gray-700">High</span>
                        <div class="flex-1 mx-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $highPercent }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs w-6 text-right font-medium text-gray-700">{{ $highCount }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-xs w-14 font-medium text-gray-700">Medium</span>
                        <div class="flex-1 mx-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $mediumPercent }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs w-6 text-right font-medium text-gray-700">{{ $mediumCount }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-xs w-14 font-medium text-gray-700">Low</span>
                        <div class="flex-1 mx-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 shadow-inner">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: {{ $lowPercent }}%"></div>
                            </div>
                        </div>
                        <span class="text-xs w-6 text-right font-medium text-gray-700">{{ $lowCount }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm p-5 border border-gray-100">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
                    <a href="{{ route('requests.index') }}" class="text-sm text-red-600 hover:text-red-800 hover:underline font-medium">View all</a>
                </div>
                
                <div class="space-y-4">
                    @foreach(\App\Models\Request::with(['requester'])->latest()->take(5)->get() as $request)
                    <div class="border-b border-gray-100 pb-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('requests.show', $request) }}" class="font-medium text-red-600 hover:text-red-800 hover:underline">
                                    {{ $request->title }}
                                </a>
                                <p class="text-xs text-gray-600 mt-0.5">Requested by {{ $request->requester->name }}</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full 
                                    {{ $request->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 
                                       ($request->status === 'in_progress' ? 'bg-violet-100 text-violet-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                                <span class="text-xs text-gray-500 mt-1">
                                    {{ $request->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex mt-2 text-xs">
                            <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-800 mr-2">{{ ucfirst($request->type) }}</span>
                            <span class="px-2 py-0.5 rounded-full 
                                {{ $request->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                  ($request->priority === 'medium' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                {{ ucfirst($request->priority) }} Priority
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Right Column: Actions and System Info -->
        <div class="space-y-6">
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white">
                    <h2 class="text-lg font-semibold">Quick Actions</h2>
                </div>
                <div class="p-4 grid grid-cols-1 gap-2">
                    <a href="{{ route('requests.index') }}" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View All Requests
                    </a>
                    
                    <a href="{{ route('requests.create') }}" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Create New Request
                    </a>
                    
                    <a href="{{ route('requests.index') }}?status=pending" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        View Pending Requests
                    </a>
                    
                    <a href="{{ route('requests.index') }}?priority=high" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        High Priority Requests
                    </a>
                    
                    <a href="{{ route('requests.index') }}?status=in_progress" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        In Progress Requests
                    </a>
                    
                    <a href="{{ route('requests.index') }}?type=maintenance" class="flex items-center p-3 bg-red-50 text-red-700 hover:bg-red-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Maintenance Requests
                    </a>
                </div>
            </div>
            
            <!-- System Info Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                <div class="px-4 py-3 bg-gradient-to-r from-red-700 to-red-800 text-white">
                    <h2 class="text-lg font-semibold">System Information</h2>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between items-center p-2 rounded-md hover:bg-gray-50 transition-colors">
                        <span class="text-gray-700 text-sm font-medium">Laravel Version</span>
                        <span class="px-2.5 py-1 bg-red-100 rounded-md text-sm font-medium text-red-800">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-2 rounded-md hover:bg-gray-50 transition-colors">
                        <span class="text-gray-700 text-sm font-medium">PHP Version</span>
                        <span class="px-2.5 py-1 bg-red-100 rounded-md text-sm font-medium text-red-800">{{ phpversion() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-2 rounded-md hover:bg-gray-50 transition-colors">
                        <span class="text-gray-700 text-sm font-medium">Environment</span>
                        <span class="px-2.5 py-1 bg-red-100 rounded-md text-sm font-medium text-red-800">{{ app()->environment() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-2 rounded-md hover:bg-gray-50 transition-colors">
                        <span class="text-gray-700 text-sm font-medium">Current Time</span>
                        <span class="px-2.5 py-1 bg-red-100 rounded-md text-sm font-medium text-red-800">{{ now()->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 