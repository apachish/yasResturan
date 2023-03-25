<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("message.Dashboard")}}</a>
            </li>
            @if($popular_food_id)
                <li class="breadcrumb-item active">{{__("messages.Edit Food")}}</li>
            @else
                <li class="breadcrumb-item active">{{__("messages.Create Food")}}</li>
            @endif
        </ol>
        <form class="row g-3 mt-5 ml-5">
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Title")}}</label>
                <input type="text" wire:model.defer="popular_food.title" class="form-control @error('popular_food.title')is-invalid @elseif(data_get($popular_food,"title"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('popular_food.title')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($popular_food,"title"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Status")}}</label>
                <select class="form-select @error('popular_food.status')is-invalid @elseif(data_get($popular_food,"status"))  is-valid @enderror" wire:model.defer="popular_food.status" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    <option value=1 >فعال</option>
                    <option value=-1 >غیر فعال</option>
                </select>
                @error('popular_food.status')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($popular_food,"status"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="mb-6">
                <input type="file"  wire:model.defer="upload" class="form-control @error('upload')is-invalid @elseif($upload)  is-valid @enderror" aria-label="file example" required>
                @error('upload')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif($upload)
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
                    @if ($upload)
                        {{__("messages.Photo Preview")}}:
                        <img src="{{ $upload->temporaryUrl() }}" width="100" height="100">
                    @elseif(data_get($popular_food,'image'))
                        <img src="{{asset("/images/popular_foods/".data_get($popular_food,'image'))}}" width="100" height="100">

                    @endif

            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                @if($popular_food_id)
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
