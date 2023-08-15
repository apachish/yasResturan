<div id="register">
    <aside>
        <figure>
            <a href="index.html"><img src="{{asset("/asset/img/logo_sticky.png")}}" width="140" height="35" alt=""></a>
        </figure>
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
        <form autocomplete="off">
            {{csrf_field()}}
            <div class="form-group">
                <input class="form-control" type="text" wire:model.defer="name" placeholder="نام ">
                <i class="icon_id"></i>
                <div class="text-danger text-left mt-2">
                    @error('name')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" wire:model.defer="family" placeholder=" نام خانوادگی">
                <i class="icon_id"></i>
                <div class="text-danger text-left mt-2">
                    @error('family')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" wire:model.defer="mobile" placeholder="موبایل">
                <i class="icon_mobile"></i>
                <div class="text-danger text-left mt-2">
                    @error('mobile')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" wire:model.defer="national_code" placeholder="کد ملی">
                <i class="icon_tag"></i>
                <div class="text-danger text-left mt-2">
                    @error('national_code')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" id="password" wire:model.defer="password" placeholder="رمز عبور">
                <i class="icon_lock_alt"></i>
                <div class="text-danger text-left mt-2">
                    @error('password')
                    <strong>{{ $message }}</strong>
                    @enderror
                </div>
            </div>

            <button wire:click.prevent="register" class="btn_1 gradient full-width">ثبت نام</button>
        </form>
        <p class="text-sm mt-3 mb-0">{{ __('message.Already have an account?') }}<a
                href="{{ route('login') }}"
                class="text-dark font-weight-bolder">{{ __('message.Sign In') }}</a>
        </p>
        <div class="copy">©داده ابری آپادانا 1402</div>
    </aside>
</div>
