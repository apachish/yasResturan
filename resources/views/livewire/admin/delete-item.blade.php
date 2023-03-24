<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف آیتم {{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>آیا از حذف ایتم
                    {{$title}}
                    مطمئن می باشید؟
                    .</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" wire:click="delete('{{$item_id}}')">{{__("messages.Delete")}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("messages.Close")}}</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('component.initialized', (component) => {})
        Livewire.hook('element.initialized', (el, component) => {})
        Livewire.hook('element.updating', (fromEl, toEl, component) => {})
        Livewire.hook('element.updated', (el, component) => {})
        Livewire.hook('element.removed', (el, component) => {})
        Livewire.hook('message.sent', (message, component) => {
            $(".modal-backdrop").hide();
        })
        Livewire.hook('message.failed', (message, component) => {})
        Livewire.hook('message.received', (message, component) => {})
        Livewire.hook('message.processed', (message, component) => {

        })
    });
</script>
