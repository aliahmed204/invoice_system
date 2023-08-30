@extends('layouts.master')
@section('title')
    معلومات الفاتورة | details
@stop
@section('css')
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-body">

                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-1">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">invoice details </a></li>
                                                <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">Payment Status</a></li>
                                                <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">Attachments</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">

                                                            <div class="table-responsive mt-15">
                                                                <table class="table table-striped text-center">
                                                                    <tbody>
                                                                    {{-- 1 --}}
                                                                    <tr>
                                                                        <th scope="row"> invoice_number</th>
                                                                        <td>{{$invoice_info->invoice_number}}</td>
                                                                        <th scope="row"> invoice_date</th>
                                                                        <td>{{$invoice_info->invoice_date}}</td>
                                                                        <th scope="row"> due_date</th>
                                                                        <td>{{$invoice_info->due_date}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th scope="row"> section_name </th>
                                                                        <td>{{$invoice_info->section->section_name}}</td>
                                                                        <th scope="row"> product </th>
                                                                        <td>{{$invoice_info->product}}</td>
                                                                        <th scope="row">  amount_collection </th>
                                                                        <td>{{$invoice_info->amount_collection}}</td>

                                                                    {{-- 2 --}}
                                                                    <tr>
                                                                        <th scope="row">  amount_commission </th>
                                                                        <td>{{$invoice_info->amount_commission}}</td>
                                                                        <th scope="row"> amount_commission </th>
                                                                        <td>{{$invoice_info->discount}}</td>
                                                                        <th scope="row"> amount_commission </th>
                                                                        <td>{{$invoice_info->rate_vat}}</td>
                                                                    </tr>
                                                                    {{-- 3 --}}
                                                                    <tr>
                                                                        <th scope="row">amount_commission</th>
                                                                        <td>{{$invoice_info->value_vat}}</td>
                                                                        <th scope="row">total  </th>
                                                                        <td>{{$invoice_info->total}}</td>
                                                                        <th scope="row">  value_status </th>
                                                                        @if ($invoice_info->value_status == 1)
                                                                            <td>
                                                                                <span class="badge  badge-success">
                                                                                    {{$invoice_info->status}}
                                                                                </span>
                                                                            </td>
                                                                        @elseif($invoice_info->value_status == 2)
                                                                            <td>
                                                                                <span class="badge badge-danger">
                                                                                    {{$invoice_info->status}}
                                                                                </span>
                                                                            </td>
                                                                        @elseif($invoice_info->value_status == 3)
                                                                            <td>
                                                                                <span class="badge badge-pill badge-warning">
                                                                                    {{$invoice_info->status}}
                                                                                </span>
                                                                            </td>

                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row"> notes </th>
                                                                        <td colspan="5" >{{$invoice_info->note}}</td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div><!-- bd -->
                                            </div><!-- bd -->

                                            <div class="tab-pane" id="tab2">
                                                <div class="table-responsive mt-15">
                                                    <table class="table table-striped text-center">
                                                        <thead>
                                                        {{-- 1 --}}
                                                        <tr>
                                                            <th>#</th>
                                                            <th> invoice_number </th>
                                                            <th>  product </th>
                                                            <th> section_name </th>
                                                            <th>  value_status </th>
                                                            <th>  status </th>
                                                            <th> note </th>
                                                            <th>  created_at </th>
                                                            <th> user </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        {{-- 2 --}}
                                                        @php $i=1; @endphp
                                                        @foreach($invoice_status as $info)
                                                            <tr>
                                                                <td>{{$i++}}</td>
                                                                <td>{{$info->invoice_number}}</td>
                                                                <td>{{$info->product}}</td>
                                                                <td>{{$invoice_info->section->section_name}}</td>
                                                                @if ($info->value_status == 1)
                                                                    <td>
                                                                    <span class="badge  badge-success">
                                                                        {{$info->status}}
                                                                    </span>
                                                                    </td>
                                                                @elseif($info->value_status == 2)
                                                                    <td>
                                                                    <span class="badge badge-danger">
                                                                        {{$info->status}}
                                                                    </span>
                                                                    </td>
                                                                @elseif($info->value_status == 3)
                                                                    <td>
                                                                    <span class="badge badge-pill badge-warning">
                                                                        {{$info->status}}
                                                                    </span>
                                                                    </td>

                                                                @endif
                                                                    @if($info->value_status == 2)
                                                                    <td>
                                                                        <span class="badge badge-danger">
                                                                            {{$info->status}}
                                                                        </span>
                                                                    </td>
                                                                    @elseif($info->value_status == 1)
                                                                    <td>
                                                                        {{$info->payment_date}}
                                                                    </td>
                                                                    @endif

                                                                <td>{{$info->note}}</td>
                                                                <td>{{$info->created_at->format('Y-m-d')}}</td>
                                                                <td>{{$info->user}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div><!-- bd -->
                                            </div>

                                            <div class="tab-pane" id="tab3">
                                                <div class="table-responsive mt-15">
                                                    @if (session()->has('deleted'))
                                                        <div class="alert alert-info">
                                                            {{session()->get('deleted')}}
                                                        </div>
                                                    @endif
                                                    <table class="table table-striped text-center">
                                                        <thead>
                                                        {{-- 1 --}}
                                                        <tr>
                                                            <th>#</th>
                                                            <th>  file_name </th>
                                                            <th>   user </th>
                                                            <th>   created_at </th>
                                                            <th> operations </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        {{-- 2 --}}
                                                        @php $i=1; @endphp
                                                        @forelse ($invoice_attachments as $invoice_attachment)
                                                            <tr>
                                                                <td>{{$i++}}</td>
                                                                <td class = "text-wrap" style="max-width: 300px" >
                                                                    {{$invoice_attachment->file_name}}
                                                                </td>
                                                                <td>{{$invoice_attachment->user}}</td>
                                                                <td>{{$invoice_attachment->created_at->format('Y-m-d')}}</td>
                                                                <td>
                                                                    {{--show--}}
                                                                    <a class="btn btn-outline-success btn-sm"
                                                                        href="{{route('view_file',['invoice_number'=>$invoice_info->invoice_number ,'file_name'=>$invoice_attachment->file_name ])}}"
                                                                        role="button" target="_blank"> <i class="fas fa-eye"></i>
                                                                        &nbsp show
                                                                    </a>
                                                                    {{--download--}}
                                                                    <a class="btn btn-outline-info btn-sm"
                                                                       href="{{route('download_file',['invoice_number'=>$invoice_info->invoice_number ,'file_name'=>$invoice_attachment->file_name ])}}"
                                                                       role="button" ><i class="fas fa-download"></i>
                                                                        &nbsp Download
                                                                    </a>

                                                                    <form method="post" action="{{route('invoice_attachments.destroy',['invoice_attachment'=>$invoice_info->id ])}}" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                           role="button" ><i class="fas fa-cut"></i>
                                                                            &nbsp Delete
                                                                        </button>
                                                                    </form>

                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <th colspan="5"><div class="alert alert-info"> There is no attachment to show </th>
                                                            </tr>
                                                        @endforelse

                                                        {{--  add file --}}
                                                        @if(session()->has('success_attach'))
                                                            <div class="alert alert-success text-center">
                                                                {{session()->get('success_attach')}}
                                                            </div>
                                                        @endif

                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif


                                                        <form method="post" action="{{route('invoice_attachments.store')}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <h5 class="card-title"> add attachment   <small class="text-danger">*  pdf, jpeg ,.jpg , png </small></h5>
                                                                    <div class="custom-file">
                                                                        <label class="custom-file-label" for="customFile">Upload</label>
                                                                        <input class="custom-file-input" name="file_name" id="customFile" type="file" >
                                                                    </div>
                                                                <input  type="hidden" name="invoice_id" value="{{$invoice_info->id}}">
                                                                <input  type="hidden" name="invoice_number" value="{{$invoice_info->invoice_number}}">

                                                            {{-- <div class="d-flex justify-content-center ">--}}
                                                                <button type="submit" class="btn btn-primary btn-sm m-2">submit </button>

                                                        </form>


                                                        {{--  add file --}}




                                                        </tbody>
                                                    </table>
                                                </div><!-- bd -->


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Prism Precode -->
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
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
@endsection
