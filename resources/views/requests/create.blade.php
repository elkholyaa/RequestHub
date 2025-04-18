@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-lg">
    <h1 class="text-2xl font-semibold mb-4">New Request</h1>

    <x-errors />

    <form method="POST" action="{{ route('requests.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium">Title</label>
            <input name="title" class="w-full border rounded p-2" required />
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="service">Service</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium">Priority</label>
                <select name="priority" class="w-full border rounded p-2">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Due date</label>
            <input type="date" name="due_date" class="border rounded p-2" />
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Submit
        </button>
    </form>
</div>
@endsection
