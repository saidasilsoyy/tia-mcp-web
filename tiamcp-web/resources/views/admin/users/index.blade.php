@extends('admin.layout')

@section('title', 'Admin Users - TIA MCP')

@section('content')
    <section class="tmcp-panel rounded-lg p-6">
        @if (session('status'))
            <div class="tmcp-status-alert mb-5">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="tmcp-kicker">Admin users</p>
                <h1 class="mt-3 text-3xl font-black text-slate-950">Users</h1>
            </div>
            <form class="flex w-full max-w-md gap-2" method="GET" action="{{ route('admin.users.index') }}">
                <label class="sr-only" for="search">Search users</label>
                <input id="search" class="tmcp-input mt-0" name="search" value="{{ $search }}" placeholder="Search email or name">
                <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Search</button>
            </form>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="tmcp-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Devices</th>
                        <th>Created</th>
                        <th>Admin actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="font-bold text-slate-950">{{ $user->name }}</div>
                                <div class="text-sm text-slate-600">{{ $user->email }}</div>
                            </td>
                            <td>{{ $user->status }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->devices_count }}</td>
                            <td>{{ $user->created_at?->toDateString() }}</td>
                            <td>
                                <div class="grid gap-3 md:min-w-72">
                                    <form class="flex gap-2" method="POST" action="{{ route('admin.users.role', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <label class="sr-only" for="role-{{ $user->id }}">Role</label>
                                        <select id="role-{{ $user->id }}" class="tmcp-select mt-0" name="role">
                                            <option value="user" @selected($user->role === 'user')>User</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>
                                        <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Save</button>
                                    </form>
                                    <form class="flex gap-2" method="POST" action="{{ route('admin.users.status', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <label class="sr-only" for="status-{{ $user->id }}">Status</label>
                                        <select id="status-{{ $user->id }}" class="tmcp-select mt-0" name="status">
                                            <option value="active" @selected($user->status === 'active')>Active</option>
                                            <option value="suspended" @selected($user->status === 'suspended')>Suspended</option>
                                        </select>
                                        <button class="tmcp-button tmcp-button-secondary tmcp-focus" type="submit">Save</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No users matched the current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </section>
@endsection
