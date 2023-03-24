<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("message.Dashboard")}}</a>
            </li>
            @if($category_id)
            <li class="breadcrumb-item active">{{__("messages.Edit Category Food")}}</li>
            @else
            <li class="breadcrumb-item active">{{__("messages.Create Category Food")}}</li>
                @endif
        </ol>
        <form class="row g-3 mt-5 ml-5">
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Title")}}</label>
                <input type="text" wire:model.defer="category.title" class="form-control @error('category.title')is-invalid @elseif(data_get($category,"title"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('category.title')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($category,"title"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Menus")}}</label>
                <select multiple class="form-select @error('menu_ids') is-invalid @elseif(data_get($category,"status"))  is-valid @enderror" wwire:model.defer="menu_ids" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    @foreach($menus as $menu)
                        <option value="{{$menu->id}}"> {{$menu->title}}</option>
                    @endforeach
                </select>
                @error('menu_ids')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($category,"status"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Status")}}</label>
                <select class="form-select @error('category.status')is-invalid @elseif(data_get($category,"status"))  is-valid @enderror" wire:model.defer="category.status" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    <option value=1 >فعال</option>
                    <option value=-1 >غیر فعال</option>
                </select>
                @error('category.status')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($category,"status"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                @if($category_id)
                    <button type="button" wire:click.prevent="editUpdateCategory()"
                            class="btn btn-info">{{__("message.Edit")}}</button>
                @else
                    <button type="button" wire:click.prevent="createUpdateCategory()"
                            class="btn btn-info">{{__("message.Create")}}</button>
                @endif
            </div>
        </form>
    </div>
</div>
