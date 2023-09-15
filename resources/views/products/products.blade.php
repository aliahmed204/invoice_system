@extends('layouts.master')
@section('title')
    products
@stop

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">products </h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
        <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card mg-b-20">
                  <div class="card-header pb-0">
                              <div class="d-flex justify-content-between">

                                  @can('add product')
                                  <div class="col-sm-3 col-md-3 col-xl-3">
                                      <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus ml-1">Add Product </i></a>
                                  </div>
                                  @endcan

                                  <!--    Create Product -->
                                  <div class="modal" id="modaldemo8">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content modal-content-demo">
                                              <div class="modal-header">
                                                  <h6 class="modal-title">Add Product</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                              </div>
                                              <div class="modal-body">

                                                  <form action="{{route('products.store')}}" method="post" autocomplete="off">
                                                      @csrf
                                                      <div class="form-group">
                                                          <label for="exampleInputName">Product Name </label>
                                                          <input type="text" class="form-control" id="product_name" name="product_name">
                                                      </div>

                                                      <div class="form-group">
                                                              <select id="section_id" name="section_id" class="form-control select2-no-search" required>
                                                                  <option label="--Section--">
                                                                  </option>
                                                                  @foreach($sections as $section)
                                                                      <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                                  @endforeach
                                                              </select>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="exampleFormControlTextarea1">note </label>
                                                          <textarea type="text" class="form-control" id="description" name="description" rows="3"></textarea>
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button class="btn ripple btn-primary"  type="submit">submit</button>
                                                          <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                                                      </div>
                                                  </form>

                                              </div>
                                          </div>
                                      </div>
                                  </div>


                              </div>
                          </div>
                <div class="card-body">
                    <div class="table-responsive">

                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> {{session()->get('success')}} </strong>
                            </div>
                        @endif

                            @if(session()->has('updated'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong> {{session()->get('updated')}} </strong>
                            </div>
                        @endif

                            @if(session()->has('delete'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> {{session()->get('delete')}} </strong>
                            </div>
                        @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger font-weight-bold text-center">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif

                                            {{-- Display Products    --}}
                        <table id="example1" class="table key-buttons text-md-nowrap text-center" data-page-length="50">
                            <thead>
                            <tr>
                                <th class="border-bottom-0"> # </th>
                                <th class="border-bottom-0"> Product Name </th>
                                <th class="border-bottom-0"> section Name </th>
                                <th class="border-bottom-0"> note </th>
                                <th class="border-bottom-0"> operations </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->section->section_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        @can('edit product')
                                        <button class="btn btn-outline-success"
                                                data-name="{{ $product->product_name }}"
                                                data-id="{{ $product->id }}"
                                                data-section_name="{{ $product->section->section_name }}"
                                                data-description="{{ $product->description }}" data-toggle="modal"
                                                data-target="#edit_Product"
                                                onclick="prepareModalData(this)"> Edit </button>
                                        @endcan
                                        @can('delete product')
                                        <form action="{{route('products.destroy',['product'=>$product->id])}}" method="post" style="display: inline-block">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-outline-danger" onclick="return confirm('Are You Sure you Want To delete  ')">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"><div class="alert alert-info">There Is No Products to Show </div></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @if(isset($product))
        <!-- edit -->
        <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm" action="{{ route('products.update', ['product' => $product->id]) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">Product_name :</label>

                                <input type="hidden" class="form-control" name="id" id="id" value="">

                                <input type="text" class="form-control" name="product_name" id="product_name">
                            </div>
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">section</label>
                            <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                @foreach ($sections as $section)
                                    <option>{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <label for="des">note :</label>
                                <textarea name="description" cols="20" rows="5" id='description' class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"> Edite+</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
				<!-- row closed -->
        </div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')


    <script>
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('name')
            var section_name = button.data('section_name')
            var description = button.data('description')
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #id').val(id);
        })


        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
        })

    </script>
    <script>
        function prepareModalData(button) {
            var productId = button.getAttribute('data-id');
            var form = document.querySelector('#editForm');
            var action = form.getAttribute('action');

            // Update the action URL with the correct product ID
            var newAction = action.replace(/product\/\d+/, 'product/' + productId);
            form.setAttribute('action', newAction);
        }

    </script>

@endsection
