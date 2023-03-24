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
                <input class="form-control" type="text" wire:model.defer="national_code" placeholder="کدملی">
                <i class="icon_id"></i>
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
            <div class="clearfix add_bottom_15">
                <div class="checkboxes float-start">
                    <label class="container_check">مرا بخاطر بسپار
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="float-end"><a id="forgot" href="#0">فراموشی رمز عبور</a></div>
            </div>
            <button wire:click.prevent="login" class="btn_1 gradient full-width">ورود</button>
        </form>
        <div class="copy">©داده ابری آپادانا 1402</div>
    </aside>
</div>
