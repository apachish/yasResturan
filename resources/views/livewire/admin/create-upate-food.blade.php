<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("message.Dashboard")}}</a>
            </li>
            @if($food_id)
                <li class="breadcrumb-item active">{{__("messages.Edit Food")}}</li>
            @else
                <li class="breadcrumb-item active">{{__("messages.Create Food")}}</li>
            @endif
        </ol>
        <form class="row g-3 mt-5 ml-5">
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Title")}}</label>
                <input type="text" wire:model.defer="food.title" class="form-control @error('food.title')is-invalid @elseif(data_get($food,"title"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('food.title')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($food,"title"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Description")}}</label>
                <textarea  wire:model.defer="food.description" class="form-control @error('food.description')is-invalid @elseif(data_get($food,"description"))  is-valid @enderror" id="validationServer01"
                           required></textarea>
                @error('food.description')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($food,"description"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Price")}}</label>
                <input id="price" type="text" wire:model.defer="food.price" class="form-control @error('food.price')is-invalid @elseif(data_get($food,"price"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('food.price')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($food,"price"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Category")}}</label>
                <select  class="form-select @error('food.category_id') is-invalid @elseif(data_get($food,"category_id"))  is-valid @enderror" wire:model="food.category_id"
                aria-describedby="validationServer04Feedback" required>
                <option  value="">{{__("message.Select")}}...</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}"> {{$category->title}}</option>
                    @endforeach
                    </select>
                    @error('food.category_id')
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @elseif(data_get($food,"category_id"))
                        <div class="valid-feedback">
                            درست می باشد
                        </div>
                        @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Menus")}}</label>
                <select multiple class="form-select @error('menu_ids') is-invalid @elseif($menu_ids)  is-valid @enderror" wire:model.defer="menu_ids" id="validationServer04"
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
                    @elseif($menu_ids)
                        <div class="valid-feedback">
                            درست می باشد
                        </div>
                        @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Status")}}</label>
                <select class="form-select @error('food.status')is-invalid @elseif(data_get($food,"status"))  is-valid @enderror" wire:model.defer="food.status" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    <option value=1 >فعال</option>
                    <option value=-1 >غیر فعال</option>
                </select>
                @error('food.status')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($food,"status"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                @if($food_id)
                    <button type="button" wire:click.prevent="editUpdateFood()"
                            class="btn btn-info">{{__("message.Edit")}}</button>
                @else
                    <button type="button" wire:click.prevent="createUpdateFood()"
                            class="btn btn-info">{{__("message.Create")}}</button>
                @endif
            </div>
        </form>
    </div>
</div>
