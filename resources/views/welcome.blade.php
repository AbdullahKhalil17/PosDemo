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
                                    aria-hidden="true"></img>
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
                                {{-- <i class="fa fa-shopping-cart highlight-icon" aria-hidden="true"></i> --}}
                                <img src="{{ URL::asset('assets/images/invoice/back.png') }}" style="width:4rem"
                                    aria-hidden="true"></img>
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
@endsection
@section('js')
@endsection
