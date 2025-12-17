@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Links</h1>

        <form method="GET" class="mb-4">
            <input type="text" name="slug" value="{{ request('slug') }}" placeholder="Search by slug">
            <button type="submit">Search</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Slug</th>
                <th>Target URL</th>
                <th>Total Hits</th>
                <th>Active</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($links as $link)
                <tr>
                    <td>{{ $link->slug }}</td>
                    <td>{{ $link->target_url }}</td>
                    <td>{{ $link->hits_count }}</td>
                    <td>{{ $link->is_active ? 'Yes' : 'No' }}</td>
                    <td>{{ $link->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $links->links() }}
    </div>
@endsection
