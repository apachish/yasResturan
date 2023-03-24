<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("message.Dashboard")}}</a>
            </li>
            <li class="breadcrumb-item active">{{__("message.Create Menu")}}</li>
        </ol>
        <form class="row g-3 mt-5 ml-5">
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Title")}}</label>
                <input type="text" wire:model.defer="menu.title" class="form-control @error('menu.title')is-invalid @elseif(data_get($menu,"title"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('menu.title')
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                @elseif(data_get($menu,"title"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer02" class="form-label">{{__("message.Slug")}}</label>

                <input type="text" wire:model.defer="menu.slug" class="form-control @error('menu.slug')is-invalid @elseif(data_get($menu,"slug")) is-valid @enderror " id="validationServer02"  required>
                @error('menu.slug')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($menu,"slug"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Status")}}</label>
                <select class="form-select @error('menu.status')is-invalid @elseif(data_get($menu,"status"))  is-valid @enderror" wire:model.defer="menu.status" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    <option value=1 >فعال</option>
                    <option value=-1 >غیر فعال</option>
                </select>
                @error('menu.status')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($menu,"status"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                @if($menu_id)
                <button type="button" wire:click.prevent="editUpdateMenu()"
                        class="btn btn-info">{{__("message.Edit")}}</button>
                @else
                    <button type="button" wire:click.prevent="createUpdateMenu()"
                            class="btn btn-info">{{__("message.Create")}}</button>
                @endif
            </div>
        </form>
    </div>
</div>
