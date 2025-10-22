@extends('layouts.admin')

@section('content')
<style>
    /* Ensure form-control borders remain visible */
    .form-control {
        border: 1px solid #ced4da !important;
        border-radius: .25rem !important;
        background-color: #fff !important;
    }

    /* Optional: give some space below the navbar */
    .content-wrapper {
        padding-top: 80px; /* adjust based on your navbar height */
    }
</style>

<div class="content-wrapper">
    <div class="row">
        <div class="col">
            {{-- Success messages --}}
            @if (Session::has('update'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('update') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('delete'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('delete') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Bookings</h5>
                        {{-- Fixed: use route() and float-end --}}
                        <a href="{{ route('create.bookings') }}" class="btn btn-primary">
                            Create Booking
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Change Status</th>
                                    <th>Created At</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr class="text-center">
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->first_name }}</td>
                                        <td>{{ $booking->last_name }}</td>
                                        <td>{{ $booking->date }}</td>
                                        <td>{{ $booking->time }}</td>
                                        <td>{{ $booking->phone }}</td>
                                        <td>{{ $booking->message }}</td>
                                        <td>{{ $booking->status }}</td>
                                        <td>
                                            <a href="{{ route('edit.bookings', $booking->id) }}" class="btn btn-sm btn-warning">
                                                Change Status
                                            </a>
                                        </td>
                                        <td>{{ $booking->created_at }}</td>
                                        <td>
                                            <form action="{{ route('delete.bookings', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-3">
                                            No bookings found.
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
@endsection
