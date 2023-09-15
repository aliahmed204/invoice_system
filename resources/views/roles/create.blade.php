@extends('layouts.master')

    @section('title')
        Add permissions
    @stop


@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">permissions</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Create
                permission</span>
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
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif




{{--
    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
--}}
    <form method="post" action="{{route('roles.store')}}" >
        @csrf
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-group">
                                <p>permission  :</p>
                                <input type="text" name="name" class="form-control">
{{-- {!! Form::text('name', null, array('class' => 'form-control')) !!} --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- col -->
                        <div class="col-lg-4">
                            <ul id="treeview1">
                                <li><a href="#">Permissions</a>
                                    <ul>
                                </li>
                                @foreach($permission as $value)
{{--{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}--}}
                                <input type="checkbox" name="permission[]" value="{{$value->id}}"  >
                                    <label style="font-size: 16px;">  {{ $value->name }}</label><br>
                                 @endforeach
                                    </li>

                            </ul>
                            </li>
                            </ul>
                        </div>
                        <!-- /col -->
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-main-primary">create</button>
                        </div>

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
