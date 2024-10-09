@extends('layouts.master')
@section('tittle')

الاقسام

@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/الاقسام</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
<div class="row row-sm">
    {{-- to show any error in validation --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::has("done"))
<div class="alert alert-success text-center">
   {{Session::get("done")}}
</div>
@endif
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    @can('اضافة قسم')
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافه قسم</a>
                    </div>
                    @endcan

                </div>
                </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم القسم</th>
                                <th class="wd-20p border-bottom-0">الوصف</th>
                                <th class="wd-15p border-bottom-0">بواسطه</th>
                                <th class="wd-15p border-bottom-0" colspan="2">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              @forelse ( $section as $item)

                                 <tr>
                                  <td>{{$item->id}}</td>
                                  <td>{{$item->section_name}}</td>
                                  <td>{{$item->description}}</td>
                                  <td>{{$item->created_by}}</td>
                                 @can('تعديل قسم')
                                 <td><a class="btn btn-info" href="{{route('edit.section',$item->id)}}">تعديل</a></td>

                                 @endcan
                                  @can('حذف قسم')
                                  <td> <a  href="#" data-section_id="{{ $item->id }}"
                                    data-toggle="modal" data-target="#delete_section">
                                    <i class="text-danger fas fa-trash-alt"></i>
                                </a>
                                </td>
                                  @endcan

                                </tr>
                              @empty
                                   <h1 class="text-center text-info">no public data</h1>
                                 @endforelse
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- create  --}}
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">

                <div class="modal-body">
                   <form action="{{route('store.section')}}" method="POST">
                    @csrf
                    <div class="form-group">
                    <label for="">اسم القسم</label>
                    <input type="text" name="section_name" id="section_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">الوصف</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">تاكيد</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                        </div>
                   </form>
                </div>

            </div>
        </div>
    </div>

 {{-- delete model --}}
 <div class="modal fade" id="delete_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">حذف القسم</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             <form action="{{ route('delete.section', $item->id) }}" method="post">
                 {{ method_field('delete') }}
                 {{ csrf_field() }}
         </div>
         <div class="modal-body">
             هل انت متاكد من عملية الحذف ؟
             <input type="text" name="section_id" id="section_id" value="">
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
             <button type="submit" class="btn btn-danger">تاكيد</button>
         </div>
         </form>
     </div>
 </div>
</div>

    @endsection


@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>


<script>
    $('#delete_section').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var section_id = button.data('section_id')
        var modal = $(this)
        modal.find('.modal-body #section_id').val(section_id);
    })

</script>

@endsection
