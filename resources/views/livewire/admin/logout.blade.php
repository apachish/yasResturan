<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">آیا برای خارج شدن مطمئن هستید?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">اگر برای خروج مطمئن هستید هستید، «خروج» را در زیر انتخاب کنید.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">لغو</button>
                <a class="btn btn-primary" wire:click="logout">خروج</a>
            </div>
        </div>
    </div>
</div>
