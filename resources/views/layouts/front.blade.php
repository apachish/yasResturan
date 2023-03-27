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
    @vite(['resources/css/front.css', 'resources/js/front.js'])
    @stack('styles')
    @stack('scripts')
    <!-- Fonts and icons     -->
    <!-- Nucleo Icons -->
    @livewireStyles

</head>

<body>

<header class="header clearfix element_to_stick">
    <div class="container">
        <div id="logo">
            <a href="{{route("home")}}">
                <img src="{{asset("/asset/img/logo.png")}}" width="162" height="35" alt="" class="logo_normal">
                <img src="{{asset("/asset/img/logo_sticky.png")}}" width="162" height="35" alt="" class="logo_sticky">
            </a>
        </div>
        <div class="layer"></div><!-- Opacity Mask Menu Mobile -->
    </div>
</header>
<!-- /header -->

{{ $slot }}
<div id="toTop"></div><!-- Back to top button -->


<!-- COMMON SCRIPTS -->
<script src="{{asset("/asset/js/common_scripts.js")}}"></script>
<script src="{{asset("/asset/js/common_func.js")}}"></script>
<script src="{{asset("/asset/js/validate.js")}}"></script>

<!-- SLIDER REVOLUTION SCRIPTS  -->
<script src="{{asset("/asset/revolution-slider/js/jquery.themepunch.tools.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/jquery.themepunch.revolution.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.actions.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.carousel.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.kenburn.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.migration.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.navigation.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.parallax.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.slideanims.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.extension.video.min.js")}}"></script>
<script src="{{asset("/asset/revolution-slider/js/extensions/revolution.addon.slicey.min.js")}}"></script>
<script>
    var tpj = jQuery;
    var revapi45;
    tpj(document).ready(function() {
        if (tpj("#rev_slider_45_1").revolution == undefined) {
            revslider_showDoubleJqueryError("#rev_slider_45_1");
        } else {
            revapi45 = tpj("#rev_slider_45_1").show().revolution({
                sliderType: "standard",
                jsFileLocation: "revolution/js/",
                sliderLayout: "fullscreen",
                dottedOverlay: "none",
                delay: 9000,
                navigation: {
                    keyboardNavigation: "off",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation: "off",
                    mouseScrollReverse: "default",
                    onHoverStop: "off",
                    bullets: {
                        enable: true,
                        hide_onmobile: false,
                        style: "bullet-bar",
                        hide_onleave: false,
                        direction: "horizontal",
                        h_align: "center",
                        v_align: "bottom",
                        h_offset: 0,
                        v_offset: 50,
                        space: 5,
                        tmp: ''
                    }
                },
                responsiveLevels: [1240, 1024, 778, 480],
                visibilityLevels: [1240, 1024, 778, 480],
                gridwidth: [1240, 1024, 778, 480],
                gridheight: [868, 768, 960, 720],
                lazyType: "none",
                shadow: 0,
                spinner: "off",
                stopLoop: "off",
                stopAfterLoops: -1,
                stopAtSlide: -1,
                shuffle: "off",
                autoHeight: "off",
                fullScreenAutoWidth: "off",
                fullScreenAlignForce: "off",
                fullScreenOffsetContainer: "",
                fullScreenOffset: "0px",
                hideThumbsOnMobile: "off",
                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                debugMode: false,
                fallbacks: {
                    simplifyAll: "off",
                    nextSlideOnWindowFocus: "off",
                    disableFocusListener: false,
                }
            });
        }
        if (revapi45) revapi45.revSliderSlicey();
    });
</script>

@livewireScripts
</body>

</html>
