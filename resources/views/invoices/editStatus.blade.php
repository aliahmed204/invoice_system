@extends('layouts.master')
@section('css')

@endsection
@section('title')
     Edit payment Status
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">invoices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit Status</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.updateStatus',['invoice'=>$show_invoice->id]) }}" method="post"  autocomplete="off">
                        @csrf
                        @method('patch')
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">inovice number </label>
                                <input type="text" class="form-control" id="inputName"
                                        value="{{$show_invoice->invoice_number}}" readonly>
                            </div>

                            <div class="col">
                                <label> invoice_date</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{$show_invoice->invoice_date}}" readonly>
                            </div>

                            <div class="col">
                                <label> due_date</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{$show_invoice->due_date}}" readonly>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Section</label>
                                <select name="Section" class="form-control SlectBox" >
                                        <option  selected  readonly > {{ $show_invoice->section->section_name }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">product</label>
                                <select id="product" name="product" class="form-control">
                                    <option   selected disabled readonly > {{ $show_invoice->product }}  </option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Amount_collection </label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                       value="{{$show_invoice->amount_collection}}" readonly >
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">Amount_Commission </label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                       name="Amount_Commission" title=" Amount_Commission "
                                       value="{{$show_invoice->amount_commission}}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Discount</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                       title=" Discount " value="{{$show_invoice->discount}}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> Rate_VAT </label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" >
                                    <!--placeholder-->
                                    <option value="" selected disabled readonly>{{$show_invoice->rate_vat}}</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label"> Value_VAT </label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" value="{{$show_invoice->value_vat}}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">total  </label>
                                <input type="text" class="form-control" id="Total" name="Total" value="{{$show_invoice->total}}" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label">  status</label>
                                <select id="product" name="status" class="form-control" required>
                                    <option selected disabled > -- Choose status --  </option>
                                    <option value="1"> paid  </option>
                                    <option value="3" > partially paid  </option>
                                </select>
                            </div>

                            <div class="col">
                                <label>Payment_date </label>
                                <input class="form-control fc-datepicker" name="Payment_date" placeholder="YYYY-MM-DD"
                                       type="text"  required>
                            </div>
                        </div>

                        <br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Do You Want To Complete Editing')" readonly>Edit </button>
                        </div>


                    </form>
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
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

@endsection
