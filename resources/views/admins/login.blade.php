@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-4 offset-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mt-3">Login</h5>
                <form method="POST" action="{{ route('check.login') }}">
                    @csrf
                
                    <div class="form-outline mb-4">
                        <label for="form2Example1">Email:</label>
                        <input type="email" name="email" id="form2Example1" class="form-control" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label for="form2Example2">Password:</label>
                        <input type="password" name="password" id="form2Example2" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection