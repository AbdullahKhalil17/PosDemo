<!-- jquery -->
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<!-- plugins-jquery -->
<script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>
<!-- plugin_path -->
<script type="text/javascript">var plugin_path = '{{ asset('assets/js') }}/';</script>

<!-- chart -->
<script src="{{ URL::asset('assets/js/chart-init.js') }}"></script>
<!-- calendar -->
<script src="{{ URL::asset('assets/js/calendar.init.js') }}"></script>
<!-- charts sparkline -->
<script src="{{ URL::asset('assets/js/sparkline.init.js') }}"></script>
<!-- charts morris -->
<script src="{{ URL::asset('assets/js/morris.init.js') }}"></script>
<!-- datepicker -->
<script src="{{ URL::asset('assets/js/datepicker.js') }}"></script>
<!-- sweetalert2 -->
<script src="{{ URL::asset('assets/js/sweetalert2.js') }}"></script>
<!-- toastr -->
@yield('js')
<script src="{{ URL::asset('assets/js/toastr.js') }}"></script>
<!-- validation -->
<script src="{{ URL::asset('assets/js/validation.js') }}"></script>
<!-- lobilist -->
<script src="{{ URL::asset('assets/js/lobilist.js') }}"></script>
<!-- custom -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>
<script src="{{ URL::asset('assets/js/general.js') }}"></script>

<script src="{{ URL::asset('assets/js/bootstrap-datatables/ar/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-datatables/ar/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();

        // $(document).on('keydown', (event) => {
        //     // منع F12
        //     if (event.key === 'F12') {
        //         event.preventDefault();
        //     }

        //     // منع Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+Shift+C
        //     if ((event.ctrlKey && event.shiftKey && ['I', 'J', 'C'].includes(event.key)) ||
        //         (event.ctrlKey && event.key === 'U')) {
        //         event.preventDefault();
        //     }
        // });

        // // تعطيل زر الفأرة الأيمن
        // $(document).on('contextmenu', (event) => {
        //     event.preventDefault();
        // });

        // // مراقبة الإدخالات السريعة لمنع قارئ الباركود من إرسال الطلبات
        // let lastInputTime = Date.now();
        // let barcodeBuffer = '';

        // $(document).on('keypress', (event) => {
        //     let currentTime = Date.now();

        //     // إذا كانت الإدخالات متتالية بسرعة كبيرة، نفترض أنه قارئ باركود
        //     if (currentTime - lastInputTime < 50) {
        //         barcodeBuffer += event.key;
        //     } else {
        //         barcodeBuffer = event.key;
        //     }

        //     lastInputTime = currentTime;

        //     // إذا كان الباركود قد تم إدخاله بالكامل، منع الإرسال
        //     if (barcodeBuffer.length > 6) { // رقم 6 كمثال، قد تحتاج إلى ضبطه حسب نوع الباركود المستخدم
        //         event.preventDefault();
        //     }
        // });

    });
</script>
