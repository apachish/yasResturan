<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="رستوران یاس">
    <meta name="date" content="{{now()}}">

    <meta data-hid="og:title" name="og:title" content="رستوران یاس">
    <meta data-hid="og:description" name="og:description"
          content="این رستوران یکی از با اصالت ترین و قدیمی ترین رستوران های تهرانه و اکثر تهرونی های اصیل این رستوران رو می شناسن. زرده تخم مرغ رو با برنج قاطی کن و سماق رو بریز و با فلفل و گوجه نوش جان کن. به قدری این کباب خوشمزس که به نظرم بهترین کباب برگ دنیا رو اینجا می تونی بخوری، اگر امروز پلنی برای ناهار نچیدی حتما امروز ظهر ناهار برو یاس.
          دسر هم کرم بروله بهترین انتخاب خواهد بود. کرم بروله دسر فرانسوی خوشمزه ایه که مواد اولیه اصلیش خامه و زرده تخم مرغه. بافت داخلی این دسر، نرم و کرم ماننده اما لایه روییش ترد و کاراملی است. ویژگی اصلی کرم بروله روکش کاراملیشه که حالت سوخته داره. بروله (brûlée) در زبان فرانسه به معنی سوخته هست. حالت کاراملی سوخته کرم بروله با نگه داشتن فندک مخصوص روی این دسر ایجاد می شه.
          میسیز پش ملبا گرفت که میکس بستنی و کمپوت هلو و گیلاس و خامه بود و خوشمزه بود. محیطش هم فوق العادس و می تونین کلی لذت ببرید. پروتکل های بهداشتی هم کاملا رعایت می شه و می تونین با خیال راحت اونجا غذا بخورید.">
    <meta property="og:image" content="https://restaurantyas.ir/images/logo.png">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('styles')
<!-- Fonts and icons     -->
    <!-- Nucleo Icons -->
    @livewireStyles

</head>

<body class="fixed-nav sticky-footer" id="page-top">

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html"><img src="{{asset("asset/img/logo.png")}}" alt="" width="167" height="36"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-fw fa-sign-out"></i>خروج</a>
            </li>
        </ul>
    </div>
</nav>
<!-- /Navigation-->
{{ $slot }}

<!-- /.container-wrapper-->
<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>کپی رایت داده ابری آپادانا 1402</small>
        </div>
    </div>
</footer>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>

<livewire:admin.logout/>



<script src="{{asset("/asset/admin/vendor/jquery/jquery.min.js")}}"></script>
<script src="{{asset("/asset/admin/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- Core plugin JavaScript-->
<script src="{{asset("/asset/admin/vendor/jquery-easing/jquery.easing.min.js")}}"></script>
<!-- Page level plugin JavaScript-->
<script src="{{asset("/asset/admin/vendor/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("/asset/admin/vendor/datatables/dataTables.bootstrap4.js")}}"></script>
<script src="{{asset("/asset/admin/vendor/jquery.magnific-popup.min.js")}}"></script>
<!-- Custom scripts for all pages-->
<script src="{{asset("/asset/admin/js/admin.js")}}"></script>
<script src="{{asset("/asset/admin/js/jquery.priceformat.min.js")}}"></script>
<script>
    var element = document.getElementById("price");

    if(typeof(element) != 'undefined' && element != null) {
        $('#price').priceFormat({
            prefix: '',
            suffix: 'ریال',
            centsLimit: 0

        });
    }

</script>
@stack('scripts')

<!-- Custom scripts for this page-->
@livewireScripts
</body>

</html>
