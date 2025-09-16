<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li>
                        <a href="#">
                            <div class="pull-left">
                                <img src="{{ URL::asset('assets/images/sidebar/operational-system.png') }}"
                                    style="width: 20px; height: 20px; margin-left: 8px;" aria-hidden="true"></img>
                                <span class="right-nav-text">لوحة التحكم</span>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">شجرة النظام </li>

                    <li>
                        <a href="{{ route('stores.index') }}"><img
                                src="{{ URL::asset('assets/images/sidebar/checklist.png') }}"
                                style="width: 20px; height: 20px; margin-left: 8px;" aria-hidden="true"></img><span
                                class="right-nav-text">الفروع</span> </a>
                    </li>

                    <!-- menu item product-->
                    <li>
                        <a href="{{ route('product.index') }}"><img
                                src="{{ URL::asset('assets/images/sidebar/checklist.png') }}"
                                style="width: 20px; height: 20px; margin-left: 8px;" aria-hidden="true"></img><span
                                class="right-nav-text">قائمة الاصناف </span> </a>
                    </li>

                    <!-- menu item product-->

                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sales-menu">
                                <div class="pull-left">
                                    <img src="{{ URL::asset('assets/images/invoice/check-out.png') }}"
                                        style="width: 20px; height: 20px; margin-left: 8px;" aria-hidden="true"></img>
                                    <span class="right-nav-text">المشتريات</span>
                                </div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <ul id="sales-menu" class="collapse" data-parent="#sidebarnav">
                                    <li> <a href="{{ route('purchaseInvoice.index') }}">إنشاء فاتورة مشتريات</a></li>
                                    <li> <a href="{{ route('purchaseInvoice.report') }}">فواتير المشتريات</a></li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        <!-- Left Sidebar End-->
        <script>
            $(document).ready(function() {
                $("#closeBtn").click(function() {
                    $("#detailes").modal('hide');
                });

                $("#modalClose").click(function() {
                    $("#casherModal").modal('hide');
                });
            });
        </script>
