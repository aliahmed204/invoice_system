@extends('layouts.master')
@section('css')

@endsection
@section('title')
     Edit Invoice
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">inovices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    Edit </span>
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

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('invoices.update',['invoice'=>$show_invoice->id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('patch')
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label"> invoice_number</label>
                                <input type="text" class="form-control" id="inputName"
                                       title="يرجي ادخال رقم الفاتورة" value="{{$show_invoice->invoice_number}}" readonly>
                            </div>

                            <div class="col">
                                <label> invoice_date</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{$show_invoice->invoice_date}}" required>
                            </div>

                            <div class="col">
                                <label> due_date</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{$show_invoice->due_date}}" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Section</label>
                                <select name="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')">
                                    <!--placeholder-->
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @selected($show_invoice->section_id  == $section->id )> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">product</label>
                                <select id="product" name="product" class="form-control">
                                    <option  value="{{ $show_invoice->product }}" > {{ $show_invoice->product }}  </option>
                                    {{--  <option value="Ajax"> auto complete with ajax-depend on section </option>  --}}
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> Amount_collection</label>
                                <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{$show_invoice->amount_collection}}"
                                >
                            </div>
                        </div>

                        {{-- 3 --}}
                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label"> Amount_Commission</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                       name="Amount_Commission" title="Amount_Commission  "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{$show_invoice->amount_commission}}" required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Discount</label>
                                <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                       title="Entre Discount "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{$show_invoice->discount}}" required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> Rate_VAT  </label>
                                <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>Rate_VAT  </option>
                                    <option value="5%" @selected($show_invoice->rate_vat == "5%" )>5%</option>
                                    <option value="10%" @selected($show_invoice->rate_vat == '10%') >10%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Value_VAT</label>
                                <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" value="{{$show_invoice->value_vat}}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Total</label>
                                <input type="text" class="form-control" id="Total" name="Total" value="{{$show_invoice->total}}" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">note</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3" >{{$show_invoice->note}}</textarea>
                            </div>
                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" > Conifrm </button>
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
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
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

    <script>
        /*var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();*/

    </script>

    <script>
        /*$(document).ready(function() { /!*Section product*!/
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val(); // create variable and its value = section.id
                if (SectionId) { // if have section id then
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId, // create Url (section/{id})
                        type: "GET",  // type of Route GET
                        dataType: "json", // data send with controller
                        success: function(data) {  // make change in product selectBox
                            $('select[name="product"]').empty(); // work on product selectBox
                            $.each(data, function(key, value) { // loop to put all products related to the section
                                $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });*/
        $(document).ready(function() {
            function loadProductsForSection() {
                var SectionId = $('select[name="Section"]').val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            }

            // Trigger the function on page load
            /*$(window).on('load', function() {
                loadProductsForSection();
            });*/
            // Trigger the function when the 'Section' select element changes
            $('select[name="Section"]').on('change', function() {
                loadProductsForSection();
            });
        });


    </script>


    <script>
            {{-- get_vat قيمة ضريبة القيمة المضافة  + العمولة بتاعتى اللى هى الاجمالى --}}
        function myFunction() {
            // get elements throw id Getter
            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value); // مبلغ العمولة
            var Discount = parseFloat(document.getElementById("Discount").value);   // الخصم
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);   // نسبة الضريبة المقامة
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value); // القيمة اللى انت هتحبهالى

            var Amount_After_Discount = Amount_Commission - Discount; // المبلغ بعد الخصم

            // processing
                    // لو حددت نسبة الضريبة من غير ما ادخل مبلغ العمولة
            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                 // // المبلغ بعد الخصم * نسبة الضريبة / 100  =  قيمة ضريبة القيمة المضافة
                var Value_VAT_Results = Amount_After_Discount * Rate_VAT / 100;

                //  الاجمالى شامل مبلغ القيمة المضافة
                var Total_Plus_Amount = parseFloat(Value_VAT_Results + Amount_After_Discount);

                   // عاوز يحط علامات عشرية 2 بعد النقطة انا كنت عاملها كده فى الداتا بيس
                Sum_Value_VAT = parseFloat(Value_VAT_Results).toFixed(2);
                Sum_Total = parseFloat(Total_Plus_Amount).toFixed(2);

            // setter
                //  هتحط القيم اللى اتحسبت فى مكانها فى الفورم بتاعتى
                document.getElementById("Value_VAT").value = Sum_Value_VAT;
                document.getElementById("Total").value = Sum_Total;

            }

        }

    </script>


@endsection
