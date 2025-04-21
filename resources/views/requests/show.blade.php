@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Header / Actions Area -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('requests.index') }}" class="text-blue-600 hover:text-blue-700 mb-2 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to requests
            </a>
            <h1 class="text-2xl font-bold text-gray-800">
                Request #{{ $request->id }} — {{ $request->title }}
            </h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('requests.edit', $request) }}" 
               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Request
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Request Details -->
        <div class="md:col-span-2">
            <!-- Request Content -->
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <!-- Status Badge -->
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $request->status === 'completed' ? 'bg-green-100 text-green-800' : 
                           ($request->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                    </span>
                    
                    <!-- Priority Badge -->
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $request->priority === 'high' ? 'bg-red-100 text-red-800' : 
                           ($request->priority === 'medium' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($request->priority) }} Priority
                    </span>
                    
                    <!-- Type Badge -->
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ ucfirst($request->type) }}
                    </span>
                </div>
                
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Description</h2>
                <div class="prose prose-sm max-w-none border rounded-md bg-gray-50 p-4 mb-6">
                    {!! nl2br(e($request->description ?: 'No description provided.')) !!}
                </div>

                <div class="text-sm text-gray-500 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        Requested by <span class="font-medium text-gray-700">{{ $request->requester->name }}</span>
                    </div>
                    <div>
                        Created: {{ $request->created_at->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="md:col-span-1">
            <!-- Request Metadata -->
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Details</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Status</h3>
                        <p class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $request->status) }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Priority</h3>
                        <p class="font-medium text-gray-800 capitalize">{{ $request->priority }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Type</h3>
                        <p class="font-medium text-gray-800 capitalize">{{ $request->type }}</p>
                    </div>
                    
                    @if($request->due_date)
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Due Date</h3>
                        <p class="font-medium text-gray-800">
                            {{ date('M d, Y', strtotime($request->due_date)) }}
                            @php
                                $dueDate = new \DateTime($request->due_date);
                                $now = new \DateTime();
                                $interval = $now->diff($dueDate);
                                $isPast = $dueDate < $now;
                            @endphp
                            
                            @if($isPast && $request->status !== 'completed')
                                <span class="text-red-500 text-xs ml-1">
                                    {{ $interval->days }} {{ Str::plural('day', $interval->days) }} overdue
                                </span>
                            @elseif(!$isPast && $interval->days < 7)
                                <span class="text-yellow-600 text-xs ml-1">
                                    Due in {{ $interval->days }} {{ Str::plural('day', $interval->days) }}
                                </span>
                            @endif
                        </p>
                    </div>
                    @endif
                    
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Requested By</h3>
                        <p class="font-medium text-gray-800">{{ $request->requester->name }}</p>
                    </div>
                    
                    @if($request->assignee)
                    <div>
                        <h3 class="text-xs text-gray-500 uppercase font-medium">Assigned To</h3>
                        <p class="font-medium text-gray-800">{{ $request->assignee->name }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="bg-green-100 rounded-full h-6 w-6 flex items-center justify-center mt-1">
                            <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Request Created</p>
                            <p class="text-xs text-gray-500">{{ $request->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($request->updated_at->gt($request->created_at))
                    <div class="flex gap-3">
                        <div class="bg-blue-100 rounded-full h-6 w-6 flex items-center justify-center mt-1">
                            <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Request Updated</p>
                            <p class="text-xs text-gray-500">{{ $request->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($request->status === 'completed')
                    <div class="flex gap-3">
                        <div class="bg-green-100 rounded-full h-6 w-6 flex items-center justify-center mt-1">
                            <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Request Completed</p>
                            <p class="text-xs text-gray-500">{{ $request->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
