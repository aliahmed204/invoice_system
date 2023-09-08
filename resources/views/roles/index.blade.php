@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    @section('title')
        users roles
    @stop


@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                users roles</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم اضافة الصلاحية بنجاح",
                    type: "success"
                });
            }

        </script>
    @endif

    @if (session()->has('edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم تحديث بيانات الصلاحية بنجاح",
                    type: "success"
                });
            }

        </script>
    @endif

    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم حذف الصلاحية بنجاح",
                    type: "error"
                });
            }

        </script>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">

                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">Add</a>

                            </div>
                        </div>
                        <br>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>role name</th>
                                <th>operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as  $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>

                                            <a class="btn btn-success btn-sm"
                                               href="{{ route('roles.show', $role->id) }}">show</a>


                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('roles.edit', $role->id) }}">edit</a>


                                        @if($role->name !== 'owner')

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                               data-role_id="{{ $role->id }}"
                                               data-role_name="{{ $role->name }}"
                                               data-toggle="modal" href="#modaldemo9" title="Delete"> delete
                                            </a>
                                        @endif

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
    </div>
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Delete User</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.destroy','role_id') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are you Sure you want to Delete this role ? </p> <br>
                        <input type="hidden" name="role_id" id="role_id" >
                        <input class="form-control" name="role_name" id="role_name" type="text" readonly>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var role_id = button.data('role_id')
            var role_name = button.data('role_name')
            var modal = $(this)
            modal.find('.modal-body #role_id').val(role_id);
            modal.find('.modal-body #role_name').val(role_name);
        })

    </script>

@endsection
