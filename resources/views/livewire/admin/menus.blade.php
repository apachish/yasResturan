<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route("dashboard")}}">{{__("messages.Dashboard")}}</a>
            </li>
            <li class="breadcrumb-item active">{{__("messages.List Menu")}}</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> {{__("messages.List Menu")}}</div>
            <a  font-color="red">

                نکته ۱: درصورت حذف تمام غذاهای تعریف شده تاکنون در زیر منوی حذف خواهند شد
            </a>
            <a  font-color="red">

                نکته ۲:آدرس منو می شود
                http://site/food-menu/{address}
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

                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.Title")}}
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.Slug")}}
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__("message.Status")}}</th>

                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            {{__("message.Action")}}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <input type="text" class="form-control" wire:model="filter.title">
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            <input type="text" class="form-control" wire:model="filter.slug">
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
                    @foreach($menus as $key=>$menu)
                        <tr>
                            <td class="ps-4">
                                <p class="text-xs font-weight-bold mb-0">{{$key+1}}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{$menu->title}}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{$menu->slug}}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                @if($menu->status=="1")
                                    <span class="p-2 mb-2  bg-success text-white">فعال</span>
                                @else
                                    <span class="p-3 mb-2 bg-danger text-white">غیرفعال</span>
                                @endif
                            </td>
                            <td class="text-center">

                                <a  class="mx-3"
                                    href="{{route("menus-edit",["menu_id"=>$menu->id])}}"
                                    data-bs-original-title="Edit menu">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <span>
                                    <i class="fa fa-trash"  data-toggle="modal" data-target="#deleteModal" wire:click="delete('{{$menu->id}}')"></i>
                                        </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
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
