<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("message.Dashboard")}}</a>
            </li>
            @if($slide_id)
                <li class="breadcrumb-item active">{{__("messages.Edit Slide")}}</li>
            @else
                <li class="breadcrumb-item active">{{__("messages.Create Slide")}}</li>
            @endif
        </ol>
        <form class="row g-3 mt-5 ml-5">
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Title")}}</label>
                <input type="text" wire:model.defer="slide.title" class="form-control @error('slide.title')is-invalid @elseif(data_get($slide,"title"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('slide.title')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($slide,"title"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("message.Description")}}</label>
                <textarea  wire:model.defer="slide.description" class="form-control @error('slide.description')is-invalid @elseif(data_get($slide,"description"))  is-valid @enderror" id="validationServer01"
                           required></textarea>
                @error('slide.description')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($slide,"description"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("messages.Title Link")}}</label>
                <input type="text" wire:model.defer="slide.title_link" class="form-control @error('slide.title_link')is-invalid @elseif(data_get($slide,"title_link"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('slide.title_link')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($slide,"title_link"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-4">
                <label for="validationServer01" class="form-label">{{__("messages.Link")}}</label>
                <input type="text" wire:model.defer="slide.link" class="form-control @error('slide.link')is-invalid @elseif(data_get($slide,"link"))  is-valid @enderror" id="validationServer01"
                       required>
                @error('slide.link')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($slide,"link"))
                    <div class="valid-feedback">
                        درست می باشد
                    </div>
                    @enderror
            </div>
            <div class="col-md-3">
                <label for="validationServer04" class="form-label">{{__("message.Status")}}</label>
                <select class="form-select @error('slide.status')is-invalid @elseif(data_get($slide,"status"))  is-valid @enderror" wire:model.defer="slide.status" id="validationServer04"
                        aria-describedby="validationServer04Feedback" required>
                    <option  value="">{{__("message.Select")}}...</option>
                    <option value=1 >فعال</option>
                    <option value=-1 >غیر فعال</option>
                </select>
                @error('slide.status')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @elseif(data_get($slide,"status"))
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
                    @elseif(data_get($slide,'image'))
                        <img src="{{asset("/images/slides/".data_get($slide,'image'))}}" width="100" height="100">

                    @endif

            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                @if($slide_id)
                    <button type="button" wire:click.prevent="editUpdateSlide()"
                            class="btn btn-info">{{__("message.Edit")}}</button>
                @else
                    <button type="button" wire:click.prevent="createUpdateSlide()"
                            class="btn btn-info">{{__("message.Create")}}</button>
                @endif
            </div>
        </form>
    </div>
</div>
