@extends('layouts.master')
@section('css')
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    @section('title')
        Invoices-Reports
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">reports</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ reports
                invoices</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if( $errors->any() )
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

    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card mg-b-20">


                <div class="card-header pb-0">

                    <form action="{{route('report.findOne')}}" method="POST" role="search" autocomplete="off">
                        @csrf

                            <div class="col-sm-5 col-md-5">
                                <label style="font-size: 30px;">invoice number</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                            </div>
                            <div class="col-sm-5 col-md-5 mt-2">
                                <button class="btn btn-primary btn-block col-sm-5 col-md-5 mt-2">Find Invoice</button>
                            </div>

                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (session()->has('invoice'))
                            <table id="example" class="table key-buttons text-md-nowrap" style=" text-align: center">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">invoice number</th>
                                    <th class="border-bottom-0">invoice date  </th>
                                    <th class="border-bottom-0">Due date</th>
                                    <th class="border-bottom-0">Product</th>
                                    <th class="border-bottom-0">Section</th>
                                    <th class="border-bottom-0">Discount</th>
                                    <th class="border-bottom-0">Rate_VAT </th>
                                    <th class="border-bottom-0">Value_VAT</th>
                                    <th class="border-bottom-0">Total</th>
                                    <th class="border-bottom-0">status</th>
                                    <th class="border-bottom-0">Notes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $invoice = session('invoice') @endphp
                                    <tr>
                                        <td>{{ 1 }}</td>
                                        <td>{{ $invoice->invoice_number }} </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td><a
                                                href="{{ url('InvoicesDetails') }}/{{$invoice->id}}">{{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vat }}</td>
                                        <td>{{ $invoice->value_vat }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->value_status == 1)
                                                <span class="text-success">{{ $invoice->status }}</span>
                                            @elseif($invoice->value_status == 2)
                                                <span class="text-danger">{{ $invoice->status }}</span>
                                            @else
                                                <span class="text-warning">{{ $invoice->status }}</span>
                                            @endif

                                        </td>

                                        <td>{{ $invoice->note }}</td>
                                    </tr>

<!--                                    <tr>
                                        <td colspan="12">
                                            <div class="alert alert-info">
                                                There Is No Invoice such Number You Entered
                                            </div>
                                        </td>
                                    </tr>-->


                                </tbody>
                            </table>

                        @endif
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
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>




@endsection
