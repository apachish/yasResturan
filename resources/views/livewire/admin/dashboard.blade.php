<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}index.html">داشبورد</a>
            </li>
            <li class="breadcrumb-item active">داشبورد</li>
        </ol>
        <div  class="row">
            <div class="col-12">
                @if (session()->has('message'))
                    <div  class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert" >
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Icon Cards-->
        <div class="row">
            <li class="breadcrumb-item active">مدیریت منوها</li>
            <br>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="me-5">
                            <h5>دسته بندی منو (3)</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("menus-create")}}">
                        <span class="float-start">منو جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("menus")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="me-5">
                            <h5>دسته بندی غذا (20)</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("categories-create")}}">
                        <span class="float-start">دسته بندی جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("categories")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-list"></i>
                        </div>
                        <div class="me-5">
                            <h5>غذا (200)</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("foods-create")}}">
                        <span class="float-start">غذای جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("foods")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <li class="breadcrumb-item active">تنظیمات</li>
            <br>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-star"></i>
                        </div>
                        <div class="me-5">
                            <h5>اسلاید شو </h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("slides-create")}}">
                        <span class="float-start">اسلاید جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("slides")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-star"></i>
                        </div>
                        <div class="me-5">
                            <h5>غذاهای محبوب</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("popular-foods-create")}}">
                        <span class="float-start">غذای محبوب جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("popular-foods")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-star"></i>
                        </div>
                        <div class="me-5">
                            <h5>پیامک</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("sms-send")}}">
                        <span class="float-start">پیامک جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("sms-template")}}">
                        <span class="float-start">قالب پیامک</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("sms")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-star"></i>
                        </div>
                        <div class="me-5">
                            <h5>پروفایل</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("profile")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <li class="breadcrumb-item active">مشتریان</li>
            <br>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card dashboard text-white bg-success o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-user"></i>
                        </div>
                        <div class="me-5">
                            <h5>لیست مشتریان (200)</h5>
                        </div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("users-create")}}">
                        <span class="float-start">مشتری جدید</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                    <a class="card-footer text-white clearfix small z-1" href="{{route("users")}}">
                        <span class="float-start">نمایش جزئیات</span>
                        <span class="float-end">
                                <i class="fa fa-angle-left"></i>
                            </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- /cards -->
        <h2></h2>
    </div>
    <!-- /.container-fluid-->
</div>
