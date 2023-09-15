@extends('layouts.master')
@section('title')
     partially Paid-invoices
@stop
@section('css')

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">inovices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ list
                    Partially Paid</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">

                        <a href="{{route('invoices.create')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; Add New Invoice</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50' style="text-align: center">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">invoice_number</th>
                                    <th class="border-bottom-0">invoice_date</th>
                                    <th class="border-bottom-0">due_date</th>
                                    <th class="border-bottom-0">product</th>
                                    <th class="border-bottom-0">section_name</th>
                                    <th class="border-bottom-0">discount</th>
                                    <th class="border-bottom-0">rate_vat</th>
                                    <th class="border-bottom-0">value_vat</th>
                                    <th class="border-bottom-0">total</th>
                                    <th class="border-bottom-0">status</th>
                                    <th class="border-bottom-0">note</th>
                                    <th class="border-bottom-0">operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 0; @endphp
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $invoice->invoice_number  }}   </td>
                                        <td>{{ $invoice->invoice_date  }}     </td>
                                        <td>{{ $invoice->due_date  }}         </td>
                                        <td>{{ $invoice->product  }}          </td>
                                        <td>
                                        <a href="{{route('invoice_details.show',['invoice_detail'=>$invoice->id])}}">
                                            {{ $invoice->section->section_name  }}
                                        </a>
                                        </td>
                                        <td>{{ $invoice->discount  }}          </td>
                                        <td>{{ $invoice->rate_vat  }}          </td>
                                        <td>{{ $invoice->value_vat  }}         </td>
                                        <td>{{ $invoice->total  }}             </td>
                                        <td>

                                            @if($invoice->value_status == 2)  {{-- not paid --}}
                                                <span class="text-danger"> {{ $invoice->status  }}  </span>
                                            @elseif($invoice->value_status == 1) {{-- paid --}}
                                                <span class="text-success"> {{ $invoice->status  }}  </span>
                                            @else
                                                <span class="text-warning"> {{ $invoice->status  }}  </span>
                                            @endif

                                        </td>
                                        <td>{{ $invoice->note  }} </td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                        type="button">operation<i class="fas fa-caret-down ml-1"></i></button>
                                                <div class="dropdown-menu tx-13">

                                                    <a class="dropdown-item" href=" {{ route('invoices.edit',[ 'invoice'=>$invoice->id]) }}">
                                                        <i class="text-danger fas fa-edit"></i>
                                                        &nbsp;&nbsp;Edit
                                                    </a>

                                                    {{-- soft-Dlete --}}
                                                    <form action="{{ route('invoices.destroy', ['invoice'=>$invoice->id ]) }}" method="post">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}

                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Complete Move')">
                                                            <i class="text-warning fas fa-exchange-alt"></i>
                                                            &nbsp;&nbsp;Move To Archive
                                                        </button>
                                                    </form>

                                                    {{-- change payment-status --}}
                                                    <a class="dropdown-item"
                                                       href="{{route('invoices.editStatus',['invoice'=>$invoice->id ])}}">
                                                        <i class=" text-success fas fa-money-bill"></i>
                                                        &nbsp;&nbsp;Change Payment Status
                                                    </a>

                                                    {{-- Force-Dlete --}}
                                                    <form action="{{ route('invoices.forceDelete', ['invoice'=>$invoice->id ]) }}" method="post">
                                                        {{ method_field('delete') }}
                                                        {{ csrf_field() }}

                                                        <button type="submit" class="dropdown-item" onclick="return confirm('Complete Delete')">
                                                            <i class="text-danger fas fa-trash-alt"></i>
                                                            &nbsp;&nbsp;Delete
                                                        </button>
                                                    </form>


                                                    <a class="dropdown-item" href="{{ route('printInvoices',['invoice'=>$invoice->id ]) }}"><i
                                                            class="text-success fas fa-print"></i>
                                                        &nbsp;&nbsp;Print
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15"><div class="alert alert-info text-center"> there is no Invoices to show </div></td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are You Sure You Want To Delete
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ارشيف الفاتورة -->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    Are You Sure You Want To Move To Archive ?
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="id_page" id="id_page" value="2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </form>
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


    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>







@endsection
