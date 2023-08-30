@extends('layouts.master')
@section('css')
    <style>
        /*when print-ordre work display the button */
        @media print {
            #print_Button {
                display: none;
            }
        }

    </style>
@endsection
@section('title')
    print-invoice
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">inovices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    print-invoice</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title"> Inovice</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">Info</label>
                                <p class="invoice-info-row"><span> Invoice_number</span>
                                    <span>{{ $invoices->invoice_number }}</span></p>
                                <p class="invoice-info-row"><span> invoice_date</span>
                                    <span>{{ $invoices->invoice_date }}</span></p>
                                <p class="invoice-info-row"><span>due_date </span>
                                    <span>{{ $invoices->due_date }}</span></p>
                                <p class="invoice-info-row"><span>Section</span>
                                    <span>{{ $invoices->section->section_name }}</span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">Product</th>
                                    <th class="tx-center"> amount_collection</th>
                                    <th class="tx-right"> amount_commission</th>
                                    <th class="tx-right">$total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">{{ $invoices->product }}</td>
                                    <td class="tx-center">{{ number_format($invoices->amount_collection, 2) }}</td>
                                    <td class="tx-right">{{ number_format($invoices->amount_commission, 2) }}</td>
                                    @php
                                        $total = $invoices->amount_collection + $invoices->amount_commission ;
                                    @endphp
                                    <td class="tx-right">
                                        {{ number_format($total, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">#</label>

                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-right">Total</td>
                                    <td class="tx-right" colspan="2"> {{ number_format($total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> rate_vat ({{ $invoices->rate_vat }})</td>
                                    <td class="tx-right" colspan="2">287.50</td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> discount</td>
                                    <td class="tx-right" colspan="2"> {{ number_format($invoices->discount, 2) }}</td>

                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">total </td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{ number_format($invoices->total, 2) }}</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">

                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>print</button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }

    </script>

@endsection
