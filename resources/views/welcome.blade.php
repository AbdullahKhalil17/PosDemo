@extends('Layouts.master')
@section('title')
    لوحة التحكم
@endsection
@section('PageTitle')
    لوحة التحكم
@endsection
@section('content')
    <div class="row">
      @include('components.alerts')
        <!-- Card 1: Total Daily Purchases -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-danger">
                                {{-- <i class="fa fa-shopping-cart highlight-icon" aria-hidden="true"></i> --}}
                                <img src="{{ URL::asset('assets/images/invoice/check-out.png') }}" style="width:4rem"
                                    aria-hidden="true"></img>
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">اجمالي المشتريات اليومية</p>
                            <h4 id="dailyPurchases" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i>
                        <a href="#" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Daily Purchase Returns -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-warning">
                                <img src="{{ URL::asset('assets/images/invoice/back.png') }}" style="width:4rem"
                                    aria-hidden="true"></img>
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">أجمالى مرتجع المشتريات اليومية</p>
                            <h4 id="dailyPurchaseReturns" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i>
                        <a href="#" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Daily Sales -->
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
                            <p class="card-text text-dark">أجمالى المبيعات خلال اليوم</p>
                            <h4 id="dailySales" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i>
                        <a href="#" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional row for other cards -->
    <div class="row">
        <!-- Card 4: Total Daily Sales Returns -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-primary">
                                <img src="{{ URL::asset('assets/images/invoice/return.png') }}"
                                    style="width:4rem"aria-hidden="true"></img>
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">إجمالى مرتجع المبيعات اليومية</p>
                            <h4 id="dailySalesReturns" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i>
                        <a href="#" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 5: Total Daily Safe Balance -->
        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-success">
                                {{-- <i class="fa fa-dollar highlight-icon" aria-hidden="true"></i> --}}
                                <img src="{{ URL::asset('assets/images/invoice/point-of-sale.png') }}"
                                    style="width:4rem"aria-hidden="true"></img>
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">إجمالى الخزنة</p>
                            <h4 id="safeBalance" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i>
                        <a href="#" target="_blank"><span class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>



        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <span class="text-primary">
                                <img src="{{ URL::asset('assets/images/invoice/accepted.png') }}" style="width:4rem"
                                    aria-hidden="true"></img>
                            </span>
                        </div>
                        <div class="float-right text-right">
                            <p class="card-text text-dark">أجمالى المشتريات خلال الشهر</p>
                            <h4 id="monthlyPurchases" style="font-family: 'Cairo'">جنيه </h4>
                        </div>
                    </div>
                    <p class="text-muted pt-3 mb-0 mt-2 border-top">
                        <i class="fa fa-binoculars mr-1" aria-hidden="true"></i><a href="#" target="_blank"><span
                                class="text-danger">عرض البيانات</span></a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
@section('js')
@endsection
