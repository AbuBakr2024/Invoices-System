@extends('layouts.master')
@section('tittle')

قائمه الفواتير

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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير </span>
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

@section('content')

@if (Session::has("done"))
<div class="alert alert-success text-center">
   {{Session::get("done")}}
</div>
@endif

<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">

                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" href="{{route('create.invoices')}}">اضافه فاتوره</a>
                    </div>

                </div>
                </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1" data-page-length='50'>
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">رقم الفاتوره</th>
                                <th class="wd-20p border-bottom-0">تاريخ الفاتوره</th>
                                <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="wd-10p border-bottom-0">المنتج</th>
                                <th class="wd-25p border-bottom-0">القسم</th>
                                <th class="wd-15p border-bottom-0">الخصم</th>
                                <th class="wd-10p border-bottom-0">نسبه الضريبه</th>
                                <th class="wd-25p border-bottom-0">قيمه الضرببه</th>
                                <th class="wd-25p border-bottom-0">الاجمالى</th>
                                <th class="wd-15p border-bottom-0">الحاله</th>
                                <th class="wd-25p border-bottom-0">الملاحظات</th>
                                <th class="wd-25p border-bottom-0" colspan="5">العمليات</th>

                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoice as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->invoice_number}}</td>
                                <td>{{$item->invoice_date}}</td>
                                <td>{{$item->due_date}}</td>
                                <td>{{$item->product}}</td>
                                <td>
                        <a href="{{route('edit.invoicesdetails',$item->id)}}">{{ $item->section->section_name }}</a>
                                </td>
                                <td>{{$item->discount}}</td>
                                <td>{{$item->amount_collection}}</td>
                                <td>{{$item->amount_commission}}</td>
                                <td>{{$item->total}}</td>
                                <td>

                              @if ($item->value_status == 1)
                              <span class="text-success">{{$item->status}}</span>

                               @elseif ($item->value_status == 2)
                               <span class="text-danger">{{$item->status}}</span>
                              @else
                               <span class="text-info">{{$item->status}}</span>

                             @endif
                                </td>
                                <td>{{$item->note}}</td>
                           @can('تعديل الفاتورة')
                           <td><a class="btn btn-info" href="{{route('edit.invoices',$item->id)}}">تعديل الفاتورة</a></td>

                           @endcan
                           @can('حذف الفاتورة')
                           <td> <a  href="#" data-invoice_id="{{ $item->id }}"
                            data-toggle="modal" data-target="#delete_invoice">
                            <i class="text-danger fas fa-trash-alt"></i>
                        </a>
                        </td>
                           @endcan

                        @can('تغير حالة الدفع')
                        <td><a class="btn btn-info" href="{{route('show.invoices',$item->id)}}">تغير حالة الدفع</a></td>

                        @endcan

                        @can('ارشفة الفاتورة')
                        <td> <a  class="btn btn-info" href="#" data-invoice_id="{{ $item->id }}"
                            data-toggle="modal" data-target="#archive_invoice">
                            ارشفة الفاتورة
                        </a>
                        </td>

                        @endcan
                        @can('طباعةالفاتورة')
                        <td><a class="btn btn-info" href="{{route('print.invoices',$item->id)}}">طباعةالفاتورة</a></td>

                        @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
{{-- delete model --}}
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="{{ route('delete.invoices', $item->id) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
            </div>
            <div class="modal-body">
                هل انت متاكد من عملية الحذف ؟
                <input type="hidden" name="invoice_id" id="invoice_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" class="btn btn-danger">تاكيد</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- archive --}}
<div class="modal fade" id="archive_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ارشف الفاتورة</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form action="{{ route('delete.invoices', $item->id) }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
        </div>
        <div class="modal-body">
            هل انت متاكد من عملية الارشفه ؟
            <input type="hidden" name="invoice_id" id="invoice_id" value="">
            <input type="hidden" name="id_page" id="id_page" value="2">
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
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

{{-- select id will deleted --}}
<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>

{{-- archive --}}
<script>
    $('#archive_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>


@endsection
