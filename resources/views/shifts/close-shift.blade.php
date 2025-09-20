@extends('Layouts.master')
@section('css')
@endsection
@section('title')
    اغلاق الشيفت
@endsection
@section('PageTitle')
    اغلاق الشيفت
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <h3 style="font-family: 'Cairo', sans-serif;color: #84BA3F">بيانات الشيفت</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">اسم الكاشير </label>
                                <input type="text" value="{{ $shift->user->name ?? '' }}" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_time">وقت البدء</label>
                                <input type="text" value="{{ $shift->start_time ?? '' }}" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="opening_balance">الرصيد الافتتاحي</label>
                                <input type="text" value="{{ $shift->opening_balance ?? '00' }}" readonly class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="closing_balance">الرصيد الحالي</label>
                                <input type="text" value="{{ $shift->actual_balance ?? '' }}" readonly class="form-control">
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('shifts.close', $shift->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="actual_balance">الرصيد الفعلي عند الاغلاق</label>
                                    <input type="number" name="actual_balance" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" value="اغلاق الشيفت">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
