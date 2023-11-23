<script>
    $('.selectpicker').selectpicker('refresh');
    function add_day_exercise(current_day) {
        var count = 0;
        $(document).on('click',`.add_day_${current_day}`,function (){
            count++;
            var html = '';
            html += '<tr>';
            html += `<td><select name="exercise_type_day_${current_day}[]" class="form-control exercise_type_day_${current_day}"><?php echo $output;?></select></td>`;
            html += `<td><select name="body_part_day_${current_day}[]" class="form-control body_part_day_${current_day}" data-body_part_day_${current_day}="${count}" required><option value="">Select Body Part</option><?php echo $bodyPartResult;?></select></td>`;
            html += `<td><select name="exercise_day_${current_day}[]" class="form-control exercise_day_${current_day}" id="exercise_day_${current_day}${count}"></select></td>`;
            html += `<td><button type="button" name="remove" class="btn btn-sm btn-danger remove_day_${current_day}"><i class="fa fa-trash"></i></button></td>`;
            $(`.tbody_day_${current_day}`).append(html);
        });

        $(document).on('click',`.remove_day_${current_day}`,function (){
            $(this).closest('tr').toggleClass(`day_${current_day}`).remove();
        });
        $(document).on('change',`.body_part_day_${current_day}`,function (){
            var body_part_id_day = $(this).val();
            var exercise_type_day = $(this).closest('tr').find(`.exercise_type_day_${current_day}`).val();
            var body_part_day_count = $(this).data(`body_part_day_${current_day}`);
            var exercise_day_select_td = $(this).parent().parent().find(`.exercise_day_${current_day}`).closest('td');
            var exercise_day_select = $(this).parent().parent().find(`.exercise_day_${current_day}`);
            exercise_day_select_td.html(exercise_day_select);

            $.ajax({
                url: '{{ url("manager/workouts/get-exercises") }}',
                method:"POST",
                data:{
                    "_token":"{{ csrf_token() }}",
                    body_part_id  : body_part_id_day,
                    exercise_type : exercise_type_day
                },
                success:function (data){
                    var html = '<option selected disabled>Select Exercise</option>';
                    html += data;
                    exercise_day_select.html(html);
                    exercise_day_select_td.find('div').addClass('d-none'); // not the best but solves the problem for now (-_-)
                    exercise_day_select.data('live-search', 'true').selectpicker();
                }
            });
        });
    }

    function workout_setup(){
        let workout_id = parseInt('{{ request()->workout }}');
        let is_workout = parseInt('{{ isset(request()->workout) ? 1 : 0 }}');

        if (is_workout) {
            $.ajax({
                url: '{{ url("manager/workouts") }}' + `/${workout_id}/setup`,
                method: "GET",
                data:{
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data){
                    for (let i = 0; i < 7; i++) {
                        $(`#data-details-${i + 1}`).html(data[i]);
                    }
                }
            });
        }
    }

    $(document).ready(function (){
        workout_setup();
        $('.details-btn').click(function(){
            let current_day  = $(this).data('day');
            let data_details = $(this).parent().find(`#data-details-${current_day} tr`);

            $('#days-modal-tr').addClass(`day_${current_day}`);
            $('#days-modal-add-btn').addClass(`add_day_${current_day}`);
            $('#days-modal-tbody').addClass(`tbody_day_${current_day}`);
            $('#days-modal-tbody').html(data_details);
            $('#days-modal-save-btn').data('day', current_day);
            $('#daysModalLabel').text(`Day #${current_day}`);
        });
        $('#daysModal').on('hide.bs.modal', function (event) {
            let current_day = $('#days-modal-save-btn').data('day');
            console.log('current day:', current_day);
            $('#days-modal-tr').removeClass(`day_${current_day}`);
            $('#days-modal-add-btn').removeClass(`add_day_${current_day}`);
            $('#days-modal-tbody').removeClass(`tbody_day_${current_day}`);
            $(`#data-details-${current_day}`).html($('#days-modal-tbody tr'));
        });

        for (let i = 0; i < 7; i++) {
            add_day_exercise(i + 1);
        }
    });
</script>
