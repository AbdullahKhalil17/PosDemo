<!-- Title -->
<title>@yield("title")</title>
{{-- <title>{{ @$data['pageTitle'] }}</title> --}}

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon" />

<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
@yield('css')

<!--- Style css -->
<link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">

<!--- Style css -->
<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
