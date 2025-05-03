<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" style="padding-inline: 3.5rem;" role="document">
        <div class="modal-content" style="border-radius: 15px">
            <div class="modal-body p-4">
                <div class="icon-danger text-center pt-3">
                    <img class="icon-danger" src="{{ asset('uploads/logout.png') }}" alt="Warning Icon" height="75px" width="75px">
                </div>
                <div class="title text-dark text-center pt-3">
                    <h5 class="mb-0"> Are you sure? </h5>
                </div>
                <div class="description text-gray text-center pt-2 pb-3">
                    <small> Are you sure you want to logout? </small>
                </div>
                <div class="button">
                    <div class="d-flex justify-content-center col-12 button-footer" style="gap: 10px">
                        <button type="button" class="btn btn-outline-primary col-6 btn-cancel-modal" style="padding-block: .75rem; border-radius: 10px;" data-dismiss="modal">Cancel</button>
                        <a href="{{ route('logout') }}" class="btn bg-gradient-danger col-6 btn-confirm-modal" style="padding-block: .75rem; border-radius: 10px;">Yes, I'm sure</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
