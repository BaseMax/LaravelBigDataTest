@extends('layout')



@section('content')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    You are Logged In
                </div>
            </div>


            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $data)
                    <tr>
                        <th scope="row">{{ $data->id }}</th>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $employees->links() !!}
            </div>

        </div>

    </div>

</div>

@endsection
