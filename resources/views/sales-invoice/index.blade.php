@extends('Layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('title')
    إضافة فاتورة مبيعات
@endsection
@section('PageTitle')
    إضافة فاتورة مبيعات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <form id="invoice_form" action="{{ route('salesInvoice.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h4 style="font-family: 'Cairo', sans-serif;color: #84BA3F">بيانات الفاتورة</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_date">تاريخ الفاتورة</label>
                                    <input type="date" id="invoice_date" name="invoice_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="invoice_number">رقم الفاتورة</label>
                                    <input type="number" value="{{ old('invoice_number') }}" id="invoice_number"
                                        name="invoice_number" class="form-control">
                                    @error('invoice_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_store">مخزن المبيعات</label>
                                    <select name="store_id" id="purchase_store" class="custom-select" required>
                                        <option disabled value="">اختار المخزن</option>
                                        @foreach ($store as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <label for="invoice_notes">ملاحظات الفاتورة</label>
                                <input type="text" id="invoice_note" name="note" class="form-control">
                            </div>
                            
                        </div>
                        <div class="row">

                            <div class="card-body">
                                <h4 style="font-family: 'Cairo', sans-serif;color: #84BA3F">بيانات الفاتورة</h4>
                                <div class="row" id="invoiceItemData">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="international_code">باركود الصنف</label>
                                            <input type="text" id="international_code" class="form-control">
                                            <input style='display:none' type='text' id="product_id" class='form-control'>
                                            <br><br>
                                            <span id="error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="itemName" style="display:block"> اسم الصنف</label>
                                            <input type="text" id="itemName" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quantity">الكمية</label>
                                            <input type="number" id="quantity" class="form-control quantity">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="sellingPrice">سعر البيع</label>
                                            <input type="number" step="any" min="0" id="sellingPrice"
                                                class="form-control selling_price">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="totalValue">اجمالى التكاليف </label>
                                            <input type="text" style="color: #84BA3F" id="totalValue" step="any"
                                                min="0" class="form-control total_cost" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <h4 style="font-family: 'Cairo', sans-serif;color: #84BA3F">تفاصيل الفاتورة</h4>
                                <table id="invoice_details_table" style="text-align: center"
                                    class="table center-aligned-table table-hover mb-0">
                                    <thead>
                                        <tr class="table-info text-danger">
                                            <th>باركود الصنف</th>
                                            <th>اسم الصنف</th>
                                            <th hidden>معرف المنتج</th>
                                            <th>الكمية</th>
                                            <th>سعر البيع</th>
                                            <th>أجمالى التكاليف</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            {{-- *** --}}
                        </div>

                        <div class="card-body">
                            <h4 style="font-family: 'Cairo', sans-serif;color: #84BA3F">أجماليات الفاتورة</h4>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">عدد الاصناف</label>
                                    <input type="number" step="any" min="0" name="total_items"
                                        id="total_items" class="form-control" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="">أجمالى الفاتورة</label>
                                    <input type="number" step="any" min="0" name="total_invoice"
                                        id="total_invoice" class="form-control total_invoice" readonly>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body text-right">
                        <input type="submit" class="btn btn-success" value="حفظ الفاتورة">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
$(document).ready(function () {
    var searchTimeout;

    function updateTotals() {
        var totalItems = $("#invoice_details_table tbody tr").length;
        var totalInvoice = 0;

        $("#invoice_details_table tbody tr").each(function () {
            var rowTotal = parseFloat($(this).find("td:eq(5) input").val()) || 0;
            totalInvoice += rowTotal;
        });

        $("#total_items").val(totalItems);
        $("#total_invoice").val(totalInvoice.toFixed(2));
    }

    $(document).on("click", ".deleteRow", function () {
        $(this).closest("tr").remove();
        updateTotals();
    });

    $("#international_code").on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            var itemName = $("#international_code").val();
            $.ajax({
                url: "{{ route('salesInvoice.searchProduct') }}",
                method: 'GET',
                data: { barcode: itemName },
                success: function (response) {
                    $("#error").empty();
                    $("#international_code").val(response.data.barcode);
                    $("#itemName").val(response.data.product_name);
                    $("#sellingPrice").val(response.data.sale_price);
                    $("#product_id").val(response.data.prodctID);

                    $("#quantity").off('input').on('input', function() {
                        var quantity = parseFloat($(this).val()) || 0;
                        var price = parseFloat($("#sellingPrice").val()) || 0;
                        var total = quantity * price;
                        $("#totalValue").val(total.toFixed(2));
                    });

                    $("#quantity").off("keypress").on("keypress", function (e) {
                        if(e.which === 13) {
                            e.preventDefault();
                            var barcode = $('#international_code').val();
                            var name = $('#itemName').val();
                            var productId = $('#product_id').val();
                            var quantity = $('#quantity').val();
                            var salePrice = $('#sellingPrice').val();
                            var total = $('#totalValue').val();

                            var newRow = "<tr>";
                            newRow += '<td><input type="text" name="barcode[]" value="' + barcode + '" class="form-control barcode" readonly></td>';
                            newRow += '<td><input type="text" name="itemName[]" value="' + name + '" class="form-control itemName" readonly></td>';
                            newRow += '<td hidden><input type="hidden" type="text" name="product_id[]" value="' + productId + '" class="form-control product_id" readonly></td>';
                            newRow += '<td><input type="number" name="quantity[]" value="' + quantity + '" class="form-control quantity" readonly></td>';
                            newRow += '<td><input type="number" name="sellingPrice[]" value="' + salePrice + '" class="form-control sellingPrice" readonly data-original-price="' + salePrice + '"></td>';
                            newRow += '<td><input type="number" name="totalValue[]" value="' + total + '" class="form-control totalValue" readonly></td>';
                            newRow += '<td><button type="button" class="btn btn-danger btn-sm deleteRow">حذف</button></td>';
                            newRow += "</tr>";

                            $("#invoice_details_table tbody").append(newRow);
                            updateTotals();

                            $("#international_code, #itemName, #quantity, #sellingPrice, #totalValue").val("");
                            $("#international_code").focus();
                        }
                    });
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    $("#error").text(response.message);
                }
            });
        }, 1000);
    });

    setInterval(function () {
        $("#invoice_details_table tbody tr").each(function () {
            var row = $(this);
            var productId = row.find(".product_id").val();   
            var salePriceInput = row.find(".sellingPrice");
            var totalInput = row.find(".totalValue");
            var quantity = parseFloat(row.find(".quantity").val()) || 0;

            var originalPrice = salePriceInput.data("original-price");

            $.ajax({
                url: "sales/latest-price/" + productId,
                method: "GET",
                success: function (response) {
                    var latestPrice = parseFloat(response.sale_price);

                    if (parseFloat(salePriceInput.val()) == parseFloat(originalPrice)) {
                        salePriceInput.val(latestPrice);
                        salePriceInput.data("original-price", latestPrice);

                        var total = quantity * latestPrice;
                        totalInput.val(total.toFixed(2));

                        updateTotals();
                    }
                }
            });
        });
    }, 10000);

});
</script>


@endsection
