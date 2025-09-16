@extends('Layouts.master')
@section('css')
@endsection
@section('title')
    إضافة صنف جديد
@endsection
@section('PageTitle')
    إضافة صنف جديد
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <h3 style="font-family: 'Cairo', sans-serif;color: #84BA3F">تسجيل بيانات صنف جديد</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">أسم المنتج</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="barcode">باركود الصنف</label>
                                    <input name="barcode" value="{{ old('barcode') }}" 
                                        class="form-control @error('barcode') is-invalid @enderror">
                                    @error('barcode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_price">سعر الشراء</label>
                                    <input name="purchase_price" value="{{ old('purchase_price') }}" 
                                        class="form-control @error('purchase_price') is-invalid @enderror">
                                    @error('purchase_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sale_price">سعر البيع</label>
                                    <input type="text" name="sale_price" value="{{ old('sale_price') }}"
                                        class="form-control @error('sale_price') is-invalid @enderror">
                                    @error('sale_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" value="حفظ البيانات">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
