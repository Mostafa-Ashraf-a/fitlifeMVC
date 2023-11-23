<div id="table-id_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer" wire:ignore.self>

    <div class="dataTables_length" id="table-id_length" wire:ignore>
        <label>Show
            <select name="table-id_length" aria-controls="table-id" wire:model='rows_pagination'
                class="custom-select custom-select-sm form-control form-control-sm">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select> entries
        </label>
    </div>

    <div class="dt-buttons btn-group flex-wrap mb-3" wire:ignore>
        <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="table-id"
            type="button">
            <span>Copy</span>
        </button>

        <button class="btn btn-secondary buttons-csv buttons-html5" tabindex="0" aria-controls="table-id"
            type="button">
            <span>CSV</span>
        </button>

        <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="table-id"
            type="button">
            <span>Excel</span>
        </button>

        <button class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="table-id"
            type="button">
            <span>PDF</span>
        </button>

        <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="table-id" type="button">
            <span>Print</span>
        </button>

        <div class="btn-group">
            <button class="btn btn-secondary buttons-collection dropdown-toggle buttons-colvis" tabindex="0"
                aria-controls="table-id" type="button" aria-haspopup="true">
                <span>Column visibility</span>
                <span class="dt-down-arrow"></span>
            </button>
        </div>
    </div>

    <div class="table-overlay">

        <div class="overlay" id="tableOverlay" wire:loading>
            <div class="spinner"></div>
        </div>

        <div class="table-responsive">

            <table id="table-id" class="table table-bordered table-striped text-center" wire:ignore.self>
                <thead wire:ignore>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Exercise Place</th>
                        <th>equipment</th>
                        <th>Level</th>
                        <th>Muscle</th>
                        <th>Exercise Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($exercises as $exercise)
                        <tr class="odd">
                            <td class="dtr-control">{{ $exercise->id }}</td>

                            <td>
                                <img src="{{ Storage::url('files/exercise/images/' . $exercise->id . '/thumb-' . $exercise->image) }}"
                                    style="width: 50px; height: 50px; padding: 2px;">
                            </td>
                            <td>{{ $exercise->title }}</td>
                            <td>{{ $exercise->place == 1 ? 'Gym' : 'Home' }}</td>
                            <td>{{ $exercise->equipment->title }}</td>
                            <td>{{ $exercise->level ? $exercise->level->title : '' }}</td>
                            <td>{{ $exercise->muscle->title }}</td>

                            <td>
                                @if ($exercise->exercise_category == 1)
                                    <span class="badge badge-pill bg-success"
                                        style="width: 6rem; padding: 8px 0;">Pre</span>
                                @elseif ($exercise->exercise_category == 2)
                                    <span class="badge badge-pill bg-warning"
                                        style="width: 6rem; padding: 8px 0;">Main</span>
                                @elseif ($exercise->exercise_category == 3)
                                    <span class="badge badge-pill bg-info"
                                        style="width: 6rem; padding: 8px 0;">Post</span>
                                @else
                                    <span class="badge badge-pill bg-primary"
                                        style="width: 6rem; padding: 8px 0;">Cardio</span>
                                @endif
                            </td>

                            <td>
                                <div class="row">
                                    <div class="col-md-12 col-sm-6">

                                        <a class="btn btn-sm btn-info"
                                            style="margin-right: 5px;margin-bottom: 5px !important;"
                                            href="{{ route('manager.exercises.edit', $exercise->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <button class="btn btn-sm btn-danger"
                                            style="margin-right: 5px;margin-bottom: 5px !important;"
                                            value="{{ $exercise->id }}" id="delete-model">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="dataTables_info" id="table-id_info" role="status" aria-live="polite">Showing
            {{ $exercises->perPage() }} of {{ $exercises->total() }} entries
        </div>

        <div class="dataTables_paginate paging_simple_numbers" id="table-id_paginate">
            <ul class="pagination">
                {{ $exercises->withQueryString()->onEachSide(0)->links() }}
            </ul>
        </div>

    </div>

</div>
