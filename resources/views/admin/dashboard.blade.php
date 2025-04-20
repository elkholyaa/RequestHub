@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome to the administration area</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Statistics Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">System Statistics</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Users</span>
                    <span class="font-bold">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Requests</span>
                    <span class="font-bold">{{ \App\Models\Request::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pending Requests</span>
                    <span class="font-bold">{{ \App\Models\Request::where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('requests.index') }}" class="block w-full py-2 px-4 bg-blue-600 text-white text-center rounded hover:bg-blue-700">
                    View All Requests
                </a>
                <a href="{{ route('requests.create') }}" class="block w-full py-2 px-4 bg-green-600 text-white text-center rounded hover:bg-green-700">
                    Create New Request
                </a>
            </div>
        </div>

        <!-- System Info Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">System Information</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Laravel Version</span>
                    <span class="font-bold">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">PHP Version</span>
                    <span class="font-bold">{{ phpversion() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Environment</span>
                    <span class="font-bold">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 