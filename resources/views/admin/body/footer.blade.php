<script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('dashboard/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function() {
        $("#table_id").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "sorting": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#table_id_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor-en'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor-ar'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor-en-3'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor-ar-3'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor-en-4'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor-ar-4'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
    };
</script>
<script type="text/javascript">
    $(".my-select").chosen({
        width: "100%"
    });
</script>
<script>
    @if (\Session::has('message'))
        var type = "{{ \Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ \Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ \Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ \Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ \Session::get('message') }} ");
                break;
        }
    @endif
</script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function() {
        readURL(this);
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        console.log(link)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Deleted!',
                    'Your Item has been deleted.',
                    'success'
                )
            }
        })
    });
</script>
</body>

</html>
