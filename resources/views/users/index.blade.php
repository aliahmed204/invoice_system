@extends('layouts.master')

    @section('title')
        users
    @stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ list
                users</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="col-sm-1 col-md-2">
                        @can('add user')
                        <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}">Create User</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive hoverable-table">
                        <table class="table table-hover" id="example1" data-page-length='25' style=" text-align: center;">
                            <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0"> User Name</th>
                                <th class="wd-20p border-bottom-0"> Email</th>
                                <th class="wd-15p border-bottom-0"> User Status</th>
                                <th class="wd-15p border-bottom-0"> User Roles</th>
                                <th class="wd-10p border-bottom-0">Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->status == 'active')
                                            <div class="text-success font-weight-bolder">
                                                {{ strtoupper($user->status )}}
                                            </div>
                                        @else
                                            <div class="text-danger font-weight-bolder">
                                                {{ strtoupper($user->status) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $role)
                                                <label class="badge badge-success">{{ $role }}</label>
                                            @endforeach
                                        @endif
                                            {{--@if (!empty($user->roles_name))
                                            @foreach ($user->roles_name as $role)
                                                <label class="badge badge-success">{{ $role }}</label>
                                            @endforeach
                                        @endif--}}
                                    </td>

                                    <td>
                                    @can('edit user')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                       title="Edit"><i class="las la-pen"></i></a>
                                     @endcan

                                    @can('delete user')
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                       data-user_id="{{ $user->id }}"
                                       data-username="{{ $user->name }}"
                                       data-toggle="modal" href="#modaldemo8" title="Delete"><i
                                            class="las la-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Delete User</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.destroy','user_id') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>Are you Sure you want to Delete this user ? </p> <br>
                            <input type="hidden" name="user_id" id="user_id" >
                            <input class="form-control" name="username" id="username" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')


    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })

    </script>


@endsection
