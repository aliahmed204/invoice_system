@extends('layouts.master')
@section('title')
    Invoices Archive
@stop
@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">invoices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ list
                   invoices Archive  </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

      @if (session()->has('statusUpdated'))
        <script>
            window.onload = function() {
                notif({
                    msg: "status Updated successfully ",
                    type: "success"
                })
            }

        </script>
    @endif
                {{-- updated  --}}
    @if (session()->has('updated'))
        <div class="alert alert text-center">
            {{session()->get('updated')}}
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
                {{-- delete --}}
    @if (session()->has('deleted'))
        <script>
            window.onload = function() {
                notif({
                    msg: "invoice Deleted Successfully",
                    type: "success"
                })
            }
        </script>
    @endif

    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
        <div class="card mg-b-20">
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
                    @forelse ($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
                                    type="button">operations<i class="fas fa-caret-down ml-1"></i></button>
                            <div class="dropdown-menu tx-13">
                                @can('restore invoice')
                                <form action="{{ route('archiveInvoices.update',[ 'archiveInvoice'=>$invoice->id])}}" method="post" >
                                    @method('patch')
                                    @csrf
                                    <button type="submit" class="dropdown-item"  >
                                        <i class="text-danger fas fa-edit"></i>
                                        &nbsp;&nbsp;restore Invoice
                                    </button>
                                </form>
                                @endcan

                                @can('edit invoice')
                                        {{-- Force-Dlete --}}
                                <form action="{{ route('archiveInvoices.destroy', ['archiveInvoice'=>$invoice->id ]) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Complete Delete')">
                                        <i class="text-danger fas fa-trash-alt"></i>
                                        &nbsp;&nbsp;Delete Invoice
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="15"><div class="alert alert-info text-center">there is no Invoices to show  </div></td>
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
