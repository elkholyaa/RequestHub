@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">My Requests</h1>
        <a href="{{ route('requests.create') }}"
           class="bg-red-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
            New Request
        </a>
    </div>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left text-sm">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Priority</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $req->id }}</td>
                <td class="px-4 py-2">{{ $req->title }}</td>
                <td class="px-4 py-2 capitalize">{{ $req->type }}</td>
                <td class="px-4 py-2 capitalize">{{ $req->status }}</td>
                <td class="px-4 py-2 capitalize">{{ $req->priority }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('requests.show', $req) }}"
                       class="text-blue-600 underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection
