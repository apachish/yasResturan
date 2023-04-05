<main>

    <div class="hero_in detail_page background-image" data-background="url(/asset/img/hero_general.jpg)">
        <div class="wrapper opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">

            <div class="container">
                <div class="main_info">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="head">
                                <div class="score"><img src="/asset/img/menu-thumb-placeholder.jpg"
                                                        data-src="/asset/img/logo.png" alt="thumb" class="lazy"></div>
                            </div>
                            <h1>رستوران یاس</h1>
                        </div>
                        <div class="col-xl-8 col-lg-7 col-md-6 position-relative">
                            <div class="buttons clearfix">
                                @if($type_menu=="en")
                                <a href="{{route("food-menu")}}" target="blank" class="btn_hero "><i class="icon_documents"></i> فارسی</a>
                                @else
                                <a href="{{route("food-menu",["type_menu"=>"en"])}}" target="blank" class="btn_hero "><i class="icon_documents"></i> English</a>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /main_info -->
            </div>
        </div>
    </div>
    <!--/hero_in-->

    <nav class="secondary_nav sticky_horizontal">
        <div class="container">
            <ul id="secondary_nav">
                @foreach($categories as $category)
                <li class="mt-4"><a href="#{{slug_seo($category->title)."_".$category->id}}">{{$category->title}}</a></li>
                @endforeach
            </ul>
        </div>
        <span></span>
    </nav>
    <!-- /secondary_nav -->

    <div class="bg_gray">
        <div class="container margin_detail">
            <div class="row">
                <div class="col-lg-12 list_menu">
                    @foreach($categories as $category)

                    <section id="{{slug_seo($category->title)."_".$category->id}}">
                        <h4>{{$category->title}}</h4>
                        <div class="row">
                            @foreach($category->foods as $key=>$food)
                            <div class="col-md-4">
                                <a class="menu_item modal_dialog" >
{{--                                    href="#exampleModal"--}}
                                    <figure><img src="{{asset("images/foods/".$food->image)}}"
                                                 data-src="{{asset("images/foods/".$food->image)}}" alt="thumb" class="lazy"></figure>
                                    <h3>{{$key+1}}. {{$food->title}}</h3>
                                    <p>{{$food->description}}</p>
                                    <strong>@convertPrice($food->price) </strong>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <!-- /row -->
                    </section>
                    @endforeach
                    <!-- /section -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bg_gray -->

    <!-- /container -->

</main>
<livewire:menu-detiles/>
