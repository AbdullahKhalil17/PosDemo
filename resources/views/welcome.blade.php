@extends('Layouts.master')
@section('title')
    لوحة التحكم
@endsection
@section('PageTitle')
    لوحة التحكم
@endsection
@section('content')
    <div class="row">
        <!-- Card 1: Total Daily Sales -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-success">
                                <img src="{{ URL::asset('assets/images/invoice/check-out.png') }}" style="width:4rem"
                                    aria-hidden="true">
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">اجمالي المبيعات اليومية</p>
                            <h4 style="font-family: 'Cairo'">{{ number_format($dailySales, 2) }} جنيه</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Daily Purchases -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-danger">
                                <img src="{{ URL::asset('assets/images/invoice/back.png') }}" style="width:4rem"
                                    aria-hidden="true">
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">اجمالي المشتريات اليومية</p>
                            <h4 style="font-family: 'Cairo'">{{ number_format($dailyPurchases, 2) }} جنيه</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
              <div class="card-body">
                  <h4>فواتير المبيعات الغير مدفوعة بــ Visa</h4>
                    <div class="table-responsive mt-15">
                        <table style="text-align: center" class="table table-hover table-sm table-bordered p-0"
                            data-page-length="10">
                            <thead>
                                <tr class="table-info text-danger">
                                    <th>#</th>
                                    <th>رقم الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>المبلغ</th>
                                    <th>طريقة الدفع</th>
                                    <th>حالة الدفع</th>
                                    <th>المبلغ المطلوب</th>
                                    <th>دفع الفاتورة</th>
                                    <th>المستخدم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allInvoices as $index => $invoice)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>مبيعات</td>
                                        <td>{{ number_format($invoice->total_invoice, 2) }} جنيه</td>
                                        <td>{{ $invoice->payment_method }}</td>
                                        <td>
                                            @if ($invoice->payment_status == 'paid')
                                                <span class="badge badge-success">مدفوع</span>
                                            @else
                                                <span class="badge badge-danger">غير مدفوع</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($invoice->total_invoice, 2) }} جنيه</td>
                                        <td><a href="{{ route('pay.intintionPay', $invoice->id) }}">دفع الفاتورة</a></td>
                                        <td>{{ $invoice->user->name ?? 'غير محدد' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">لا توجد فواتير غير مدفوعة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
