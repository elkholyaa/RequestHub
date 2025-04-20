@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Debug Request Form</h1>
        <a href="{{ route('requests.index') }}"
           class="text-blue-600 underline">← Back to list</a>
    </div>

    <form method="POST" action="{{ route('debug.request.store') }}" class="space-y-4 bg-white p-6 shadow rounded">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title"
                   value="Debug Request"
                   class="w-full border rounded p-2"
                   required />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border rounded p-2">This is a debug request</textarea>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="service">Service</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium mb-1">Priority</label>
                <select name="priority" class="w-full border rounded p-2">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Due Date</label>
            <input type="date" name="due_date"
                   value="{{ now()->addDays(7)->format('Y-m-d') }}"
                   class="border rounded p-2" />
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded">
                Submit Debug Request
            </button>
        </div>
    </form>
</div>
@endsection 