@extends('Layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('title')
    إضافة فاتورة مشتريات
@endsection
@section('PageTitle')
    إضافة فاتورة مشتريات
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <form id="invoice_form" action="{{ route('purchaseInvoice.store') }}" method="POST">
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
                                    <label for="purchase_store">مخزن المشتريات</label>
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
                                            <label for="costPrice">سعر الشراء</label>
                                            <input type="number" step="any" min="0" id="costPrice"
                                                class="form-control purchase_price" readonly>
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
                                            <th>معرف المنتج</th>
                                            <th>الكمية</th>
                                            <th>سعر البيع</th>
                                            <th>سعر الشراء</th>
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
            var rowTotal = parseFloat($(this).find("td:eq(6) input").val()) || 0;
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
        var itemName = $("#international_code").val()
        $.ajax({
          url: "{{ route('product.searchProduct') }}",
          method: 'GET',
          data: {
              barcode: itemName
          },
          success: function (response) {
            $("#error").empty();
            $("#international_code").val(response.data.detailsProduct.barcode);
            $("#itemName").val(response.data.detailsProduct.product_name);
            $("#sellingPrice").val(response.data.detailsProduct.sale_price);
            $("#costPrice").val(response.data.detailsProduct.purchase_price);
            $("#product_id").val(response.data.detailsProduct.id);

            // count total product
            $("#quantity").off('input').on('input', function() {
              var quantity = parseFloat($(this).val()) || 0;
              var price = parseFloat($("#costPrice").val()) || 0;
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
                var costPrice = $('#costPrice').val();
                var total = $('#totalValue').val();

                var newRow = "<tr>";
                newRow +=
                  '<td><input type="text" name="barcode[]" value="' + barcode +'" class="form-control" readonly></td>';
                newRow +='<td><input type="text" name="itemName[]" value="' + name + '" class="form-control" readonly></td>';
                newRow +='<td><input type="text" name="product_id[]" value="' + productId + '" class="form-control" readonly></td>';
                newRow += '<td><input type="number" name="quantity[]" value="' + quantity + '" class="form-control" readonly></td>';
                newRow += '<td><input type="number" name="sellingPrice[]" value="' + salePrice + '" class="form-control" readonly></td>';
                newRow += '<td><input type="number" name="costPrice[]" value="' + costPrice + '" class="form-control" readonly></td>';
                newRow += '<td><input type="number" name="totalValue[]" value="' + total + '" class="form-control" readonly></td>';
                newRow += '<td><button type="button" class="btn btn-danger btn-sm deleteRow">حذف</button></td>';
                newRow += "</tr>";
                $("#invoice_details_table tbody").append(newRow);
                updateTotals();
                $("#international_code, #itemName, #quantity, #sellingPrice, #costPrice, #totalValue").val("");
                $("#international_code").focus();
              }
            });
          },
          error: function(xhr, status, error) {
            let response = xhr.responseJSON;
            $("#error").text(response.message);
          }
        });
      }, 1000);
    });
  });
  </script>
@endsection
