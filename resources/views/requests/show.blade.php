@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">
            Request #{{ $request->id }} — {{ $request->title }}
        </h1>
        <div class="flex gap-2">
            <a href="{{ route('requests.edit', $request) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('requests.index') }}" 
               class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition-colors">
                Back
            </a>
        </div>
    </div>

    <div class="bg-white p-6 shadow rounded">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <h3 class="text-sm text-gray-600">Type</h3>
                <p class="font-medium capitalize">{{ $request->type }}</p>
            </div>
            <div>
                <h3 class="text-sm text-gray-600">Priority</h3>
                <p class="font-medium capitalize">{{ $request->priority }}</p>
            </div>
            <div>
                <h3 class="text-sm text-gray-600">Status</h3>
                <p class="font-medium capitalize">{{ $request->status }}</p>
            </div>
            <div>
                <h3 class="text-sm text-gray-600">Due Date</h3>
                <p class="font-medium">{{ $request->due_date ? date('M d, Y', strtotime($request->due_date)) : '—' }}</p>
            </div>
            <div>
                <h3 class="text-sm text-gray-600">Requested By</h3>
                <p class="font-medium">{{ $request->requester->name }}</p>
            </div>
            @if($request->assignee)
            <div>
                <h3 class="text-sm text-gray-600">Assigned To</h3>
                <p class="font-medium">{{ $request->assignee->name }}</p>
            </div>
            @endif
        </div>

        <h3 class="text-sm text-gray-600 mb-2">Description</h3>
        <div class="whitespace-pre-wrap border p-4 rounded bg-gray-50">
            {{ $request->description ?: '—' }}
        </div>
    </div>
</div>
@endsection
