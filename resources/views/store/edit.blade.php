@extends('Layouts.master')
@section('css')
@endsection
@section('title')
   {{ $store->name }}
@endsection
@section('PageTitle')
   {{ $store->name }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form action="{{ route('stores.update', $store->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h3 style="font-family: 'Cairo', sans-serif;color: #84BA3F">تعديل بيانات المخزن</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">أسم المخزن</label>
                                    <input type="text" name="name" value="{{ $store->name }}"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">عنوان المخزن</label>
                                    <input name="address" value="{{ $store->name }}"
                                        class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
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
