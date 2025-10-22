@extends('layouts.admin')

@section('content')
<div class="container mt-5 pt-5"> {{-- added pt-5 to prevent navbar overlap --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
                        @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card shadow border-0 rounded-4">
                <div class="card-body">

                    {{-- Header + Add button --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Admins List</h4>
                        <a href="{{ route('create.admins') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Add Admin
                        </a>
                    </div>

                    {{-- ✅ Admins table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allAdmins as $admin)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td><span class="text-muted">••••••••</span></td>
                                        <td>
                                            <a href="{{ route('edit.admin', $admin->id) }}" class="btn btn-sm btn-warning me-1">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('delete.admin', $admin->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this admin?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No admins found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ✅ Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection
