@extends('layouts.master')

@section('title')
    Sections
@endsection


@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Sections </h4>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')
				<!-- row  tables -->
				<div class="row">
                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        {{--Add New Section--}}
                                        @can('add section')
                                        <div class="col-sm-3 col-md-2 col-xl-3">
                                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">Add Sectoin </a>
                                        </div>
                                         @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @if($errors->any())
                                            <div class="alert alert-danger mt-2">
                                                @foreach($errors->all() as $error )
                                                    <li> {{$error}}</li>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(session()->has('success'))
                                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                                <strong> {{session()->get('success')}} </strong>
                                            </div>
                                        @endif

                                        @if(session()->has('updated'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong> {{session()->get('updated')}} </strong>
                                            </div>
                                         @endif

                                        @if(session()->has('delete'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong> {{session()->get('delete')}} </strong>
                                            </div>
                                         @endif

                                        @if(session()->has('Error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong> {{session()->get('Error')}} </strong>
                                            </div>
                                        @endif

                                        <table class="table text-md-nowrap text-center" id="example1">
                                            <thead>
                                            <tr>
                                                <th class="wd-5p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">section name</th>
                                                <th class="wd-15p border-bottom-0">description</th>
                                                <th class="wd-15p border-bottom-0">created_by</th>
                                                <th class="wd-15p border-bottom-0">operations</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse ($sections as $section)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$section->section_name}}</td>
                                                    <td>{{$section->description}}</td>
                                                    <td>{{$section->created_by}}</td>
                                                    <td>
                                                        @can('edit product')
                                                        <a class="modal-effect btn btn-outline-success" data-effect="effect-scale"
                                                               data-id="{{$section->id}}" data-section_name="{{$section->section_name}}"
                                                               data-description="{{$section->description}}"
                                                               data-toggle="modal" href="#exampleModal12" > Edit
                                                        </a>
                                                        @endcan
                                                        @can('delete product')
                                                        <form action="{{route('sections.destroy',['section'=>$section->id])}}" method="post" style="display: inline-block">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-outline-danger" onclick="return confirm('Do You want to Complete Deleting')">Delete</button>
                                                        </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"><div class="alert alert-info">empty sections</div></td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="modaldemo8">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Add Section </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{route('sections.store')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputName">Name </label>
                                                <input type="text" class="form-control" id="section_name" name="section_name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">notes </label>
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


                        @if(isset($section))
                        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">Edit Section</span></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="post" action="{{route('sections.update',['section'=>$section->id])}}">
                                        @csrf
                                        @method('patch')

                                        <div class="form-group">
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                        <div class="form-group">
                                            <label for="section_name">name</label>
                                            <input type="text" id="section_name" name="section_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="sectionDescription">description</label>
                                            <textarea id="sectionDescription" name="description" class="form-control"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button onclick="return confirm('Confirm Edit')" type="submit"  class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


		<!-- main-content closed -->
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $('#exampleModal12').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract information from data-* attributes
                var section_name = button.data('section_name');
                var description = button.data('description');

                var modal = $(this); // Modal itself
                modal.find('.modal-title').text('Edit Section'); // Set modal title
                modal.find('#id').val(id); // Set the value of an input element
                modal.find('#section_name').val(section_name); // Set the value of another input element
                modal.find('#sectionDescription').val(description); // Set the value of a textarea element
            });
        });
    </script>

@endsection
