@extends('layouts.master')
@section('css')
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    @section('title')
        invoice reports
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
                @foreach ($errors->all() as $error)
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
                    <form action="{{route('reports.search')}}" method="post" role="search" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 mg-t-20 mg-lg-t-0" id="type">
                                <p class="mg-b-10">Define invoice status </p>
                                <select class="form-control " name="type"  required>
                                    <option hidden> Define invoice status </option>
                                    <option value="1"> Paid </option>
                                    <option value="2"> Unpaid </option>
                                    <option value="3"> Partially Paid</option>
                                    <option value="4"> All Invoices</option>
                                </select>
                            </div>

                            <div class="col-lg-3" id="start_at">
                                <label for="exampleFormControlSelect1">Data From</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker"
                                                 name="start_at" placeholder="YYYY-MM-DD" type="text">
                                </div><!-- input-group -->
                            </div>

                            <div class="col-lg-3" id="end_at">
                                <label for="exampleFormControlSelect1">To Data</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div><input class="form-control fc-datepicker" name="end_at"
                                                 value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="text">
                                </div><!-- input-group -->
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-sm-3 col-md-2">
                                <button class="btn btn-primary btn-block">Show Invoices</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (session()->has('invoices'))
                            <table id="example1" class="table key-buttons text-md-nowrap" style=" text-align: center">
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
                                    <th class="border-bottom-0"> Value_VAT</th>
                                    <th class="border-bottom-0">Total</th>
                                    <th class="border-bottom-0">status</th>
                                    <th class="border-bottom-0">Notes</th>

                                </tr>
                                </thead>
                                <tbody>
                                @forelse(session()->get('invoices') as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->invoice_number }} </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td><a
                                                href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->section->section_name }}</a>
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
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <div class="alert alert-info">
                                                There Is No Invoice such Number You Entered
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
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
