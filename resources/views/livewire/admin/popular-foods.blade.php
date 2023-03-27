<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("messages.Dashboard")}}</a>
            </li>
            <li class="breadcrumb-item active">{{__("messages.List Food")}}</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> {{__("messages.List Food")}}</div>
            <a  font-color="red">

            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.ID")}}
                        </th>
                        <th></th>

                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.Title")}}
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__("message.Status")}}</th>

                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.Action")}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <input type="text" class="form-control" wire:model="filter.title">
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <select wire:model="filter.status" class="form-control"
                                    aria-describedby="status-addon">
                                <option value="">انتخاب کنید</option>
                                <option value=0 > غیرفعال</option>
                                <option value=1 > فعال</option>
                            </select>
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($popular_foods as  $key=>$popular_food)
                        <tr>
                            <td class="ps-4">
                                <p class="text-xs font-weight-bold mb-0">{{$key+1}}</p>
                            </td>
                            <td class="text-center">
                                <img src="{{asset("images/popular_foods/".$popular_food->image)}}" width="100" height="100"/>
                            </td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{$popular_food->title}}</p>
                            </td>

                            <td class="align-middle text-center text-sm">
                                @if($popular_food->status=="1")
                                    <span class="p-2 mb-2  bg-success text-white">فعال</span>
                                @else
                                    <span class="p-3 mb-2 bg-danger text-white">غیرفعال</span>
                                @endif
                            </td>
                            <td class="text-center">

                                <a  class="mx-3"
                                    href="{{route("popular-foods-edit",["popular_food_id"=>$popular_food->id])}}"
                                    data-bs-original-title="Edit Category">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <span>
                                    <i class="fa fa-trash"  data-toggle="modal" data-target="#deleteModal" wire:click="delete('{{$popular_food->id}}')"></i>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    <tr>
                        <td colspan="4">
                            {{ $popular_foods->links() }}

                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted"></div>
    </div>
    <!-- /tables-->
</div>
<livewire:admin.delete-item/>
<!-- /container-fluid-->
</div>
