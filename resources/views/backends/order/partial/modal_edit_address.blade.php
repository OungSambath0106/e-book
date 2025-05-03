<div class="modal fade" id="editAddressModal" tabindex="-1" role="dialog" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body position-relative">
                <h5 class="modal-title text-center">{{ __('Edit Shipping Address') }}</h5>
                <button type="button" class="close btn-close-modal position-absolute" style="top: 10px; right: 10px; border: none; background: none; font-size: 1.5rem;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <form action="#" enctype="multipart/form-data" class="submit-form mt-4" method="post">
                    <div class="row">
                        <!-- Label field -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group m-0">
                                <button class="btn btn-sm btn-outline-primary mb-0 @if(@$order->address['label'] == 'home') active @endif" value="home">Home</button>
                                <button class="btn btn-sm btn-outline-primary mb-0 @if(@$order->address['label'] == 'work') active @endif" value="work">Work</button>
                                <button class="btn btn-sm btn-outline-primary mb-0 @if(@$order->address['label'] == 'other') active @endif" value="other">Other</button>
                            </div>
                        </div>

                        <!-- Phone Number field -->
                        <div class="col-md-6 mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" value="+855 855 964 828">
                        </div>

                        <!-- Province field -->
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" value="Siem Reap">
                        </div>

                        <!-- Street Line #1 field -->
                        <div class="col-md-6 mb-3">
                            <label for="streetLine1" class="form-label">Street Line #1</label>
                            <input type="text" class="form-control" id="streetLine1" value="Siem Reap">
                        </div>

                        <!-- Street Line #2 field -->
                        <div class="col-md-6 mb-3">
                            <label for="streetLine2" class="form-label">Street Line #2</label>
                            <input type="text" class="form-control" id="streetLine2" value="Siem Reap">
                        </div>

                        <!-- Note field -->
                        <div class="col-md-12 mb-3">
                            <label for="deliveryNote" class="form-label">Note</label>
                            <textarea class="form-control" id="deliveryNote" rows="2">Noted</textarea>
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-end gap-2 pt-3">
                    <button type="button" class="btn bg-gradient-danger btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn bg-gradient-primary btn-sm">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>