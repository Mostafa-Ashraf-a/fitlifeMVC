<div class="modal fade" id="daysModal" tabindex="-1" aria-labelledby="daysModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="daysModalLabel">Day #</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr id="days-modal-tr">
                            <th><h5>Exercise Type <span class="text-danger">*</span></h5></th>
                            <th><h5>Body Parts <span class="text-danger">*</span></h5></th>
                            <th><h5>Exercises <span class="text-danger">*</span></h5></th>
                            <th>
                                <button id="days-modal-add-btn" type="button" name="add" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody id="days-modal-tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="days-modal-save-btn" class="btn btn-primary d-none">Save changes</button>
        </div>
    </div>
    </div>
</div>
