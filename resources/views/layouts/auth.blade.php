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
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    @vite(['resources/css/auth.css', 'resources/js/front.js'])
    @stack('styles')
    @stack('scripts')
    <!-- Fonts and icons     -->
    <!-- Nucleo Icons -->
    @livewireStyles

</head>

<body>
<!-- /header -->
<body id="register_bg">

{{ $slot }}
</body>


<!-- COMMON SCRIPTS -->
<script src="{{asset("/asset/js/common_scripts.js")}}"></script>
<script src="{{asset("/asset/js/common_func.js")}}"></script>
<script src="{{asset("/asset/js/validate.js")}}"></script>

@livewireScripts
</body>

</html>
