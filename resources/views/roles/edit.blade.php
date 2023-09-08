@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
    @section('title')
        تعديل الصلاحيات - مورا سوفت للادارة القانونية
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                الصلاحيات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Error</strong>
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


{{--    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}--}}
    <form method="post" action="{{route('roles.update',[ 'role' =>$role->id])}}" >
        @csrf
        @method('PATCH')
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="form-group">
                            <p>Permission Name :</p>
{{--                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}--}}
                                <input type="text" name="name" placeholder="Permission name" class="form-control" value="{{$role->name}}">
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">Permissions</a>
                                    <ul>
                                        <li>
                                            @foreach($permission as $value)
                                                <input type="checkbox" name="permission[]" value="{{$value->id}}" @checked(in_array($value->id,$rolePermissions)) >
                                                <label> {{ $value->name }}</label>
                                                {{--  {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}--}}
                                                <br />
                                            @endforeach
                                        </li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">Update</button>
                        </div>
                        <!-- /col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    </form>
{{--    {!! Form::close() !!}--}}
@endsection
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
