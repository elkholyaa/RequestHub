@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl">
    <h1 class="text-2xl font-semibold mb-2">
        Request #{{ $request->id }} — {{ $request->title }}
    </h1>

    <ul class="mb-4 text-sm text-gray-700">
        <li><strong>Type:</strong> {{ ucfirst($request->type) }}</li>
        <li><strong>Status:</strong> {{ ucfirst($request->status) }}</li>
        <li><strong>Priority:</strong> {{ ucfirst($request->priority) }}</li>
        <li><strong>Requested by:</strong> {{ $request->requester->name }}</li>
        @if($request->assignee)
            <li><strong>Assigned to:</strong> {{ $request->assignee->name }}</li>
        @endif
    </ul>

    <p class="whitespace-pre-wrap border p-4 rounded bg-gray-50">
        {{ $request->description ?: '—' }}
    </p>

    <div class="mt-4">
        <a href="{{ route('requests.index') }}" class="text-blue-600 underline">← Back to list</a>
    </div>
</div>
@endsection
