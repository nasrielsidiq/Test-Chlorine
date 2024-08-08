@extends('template.template')
@section('content')

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
@if (session('errors'))
    <div class="alert alert-danger">
        {{ session('errors') }}
    </div>
@endif

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data User</strong>
                        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#mediumModal">
                            Add Data
                        </button>
                        <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="modalinput" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="modalinput">Add Data User</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/users/create" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="recipient-name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="col-form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" value="Add" class="btn btn-success">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email}}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit{{ $key }}">
                                                Edit
                                            </button>
                                            <div class="modal fade" id="edit{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalinput" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title" id="modalinput{{ $key }}">Edit Data User</h3>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/users/update/{{ $item->id }}" method="post">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="recipient-name" class="col-form-label">Name</label>
                                                                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" id="recipient-name">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email" class="col-form-label">Email</label>
                                                                    <input type="email" name="email" class="form-control" value="{{ $item->email }}" id="email">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="password" class="col-form-label">Password</label>
                                                                    <input type="password" name="password" class="form-control" id="password">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <input type="submit" value="Edit" class="btn btn-primary">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @foreach ($edit as $key =>  $item)
                                            @endforeache --}}
                                            <a href="/users/delete/{{ $item->id }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- .animated -->
</div><!-- .content -->


<div class="clearfix"></div>

<footer class="site-footer">
    <div class="footer-inner bg-white">
        <div class="row">
            <div class="col-sm-6">
                Copyright &copy; 2018 Ela Admin
            </div>
            <div class="col-sm-6 text-right">
                Designed by <a href="https://colorlib.com">Colorlib</a>
            </div>
        </div>
    </div>
</footer>
@endsection
