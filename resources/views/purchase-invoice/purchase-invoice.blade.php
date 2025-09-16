@extends('layouts.master')
@section('css')
@endsection
@section('title')
    تقارير فواتير المشتريات
@endsection
@section('PageTitle')
    تقارير فواتير المشتريات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <h4 style="font-family: 'Cairo', sans-serif; color: #84BA3F;">
                        تقارير فواتير المشتريات
                    </h4>
                    <div class="table-responsive mt-15">
                        <table style="text-align: center" id="datatable" class="table table-hover table-sm table-bordered p-0"
                            data-page-length="10">
                            <thead>
                                <tr class="table-info text-danger">
                                    <th>#</th>
                                    <th>رقم الفاتورة</th>
                                    <th>المخزن</th>

                                    <th>أجمالى الفاتورة</th>
                                    <th>تاريخ إستحقاق الفاتورة</th>
                                    <th>المشتري</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $inv)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $inv->invoice_number }}</td>
                                        <td>{{ $inv->store->name }}</td>
                                        <td>{{ $inv->total_amount }}</td>
                                        <td>{{ $inv->invoice_date->format('Y-m-d') }}</td>
                                        <td>{{ $inv->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
