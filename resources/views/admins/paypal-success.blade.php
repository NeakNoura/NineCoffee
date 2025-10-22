@extends('layouts.admin')

@section('content')
<div class="container mt-5 text-center">
    <h2>Payment Successful!</h2>
    <p>The admin checkout has been processed successfully.</p>
    <a href="{{ route('admins.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>
@endsection
