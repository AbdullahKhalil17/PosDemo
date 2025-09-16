@extends('Layouts.master')
@section('css')
@endsection
@section('title')
    قائمة المخازن
@endsection
@section('PageTitle')
    قائمة المخازن
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <a href="{{ route('stores.create') }}" class="btn btn-sm btn-success">تسجيل بيانات مخزن جديد</a>
                    <div class="table-responsive mt-15">
                        <table style="text-align: center"
                            class="table table-hover table-sm table-bordered p-0" data-page-length="10">
                            <thead>
                                <tr class="table-info text-danger">
                                    <th>#</th>
                                    <th>اسم المخزن</th>
                                    <th>العنوان</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($stores as $item)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>
                                            <a type="button" href="{{ route('stores.view', $item->id) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete" title="حذف البيانات"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    {{-- Delete Modal --}}
                                    <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">حذف البيانات</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- delete form -->
                                                    <form action="{{ route('stores.destroy', $item->id) }}" method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <h5 style="font-family: cairo">هل تريد بالفعل حذف بيانات الفرع</h5>
                                                        <input type="hidden" id="id" name="id"
                                                            class="form-control" value="{{ $item->id }}">
                                                        <br><br>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إغلاق</button>
                                                            <button type="submit" class="btn btn-danger">حذف
                                                                البيانات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
@endsection
