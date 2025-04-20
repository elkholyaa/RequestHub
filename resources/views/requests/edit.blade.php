@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Edit Request #{{ $request->id }}</h1>
        <a href="{{ route('requests.show', $request) }}"
           class="text-blue-600 underline">← Back to request</a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('requests.update', $request) }}" class="space-y-4 bg-white p-6 shadow rounded">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title"
                   value="{{ old('title', $request->title) }}"
                   class="w-full border rounded p-2"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border rounded p-2">{{ old('description', $request->description) }}</textarea>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="service" {{ old('type', $request->type) == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="maintenance" {{ old('type', $request->type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Priority</label>
                <select name="priority" class="w-full border rounded p-2">
                    <option value="low" {{ old('priority', $request->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $request->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $request->priority) == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="pending" {{ old('status', $request->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $request->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('status', $request->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Due Date</label>
                <input type="date" name="due_date"
                       value="{{ old('due_date', $request->due_date) }}"
                       class="w-full border rounded p-2" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded">
                Update Request
            </button>
        </div>
    </form>
</div>
@endsection
