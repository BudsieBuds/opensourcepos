<?php
/**
 * @var array $dinner_tables
 * @var array $config
 */
?>

<?= form_open('config/saveTables/', ['id' => 'table_config_form']) ?>

    <?php
    $title_info['config_title'] = lang('Config.table_configuration');
    echo view('configs/config_header', $title_info);
    ?>

    <ul id="error_message_box" class="table_error_message_box alert alert-warning d-none"></ul>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="dinner_table_enable" name="dinner_table_enable" value="dinner_table_enable" <?= $config['dinner_table_enable'] == 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="dinner_table_enable"><?= lang('Config.dinner_table_enable'); ?></label>
    </div>

    <div class="row" id="dinner_tables">
        <?= view('partial/dinner_tables', ['dinner_tables' => $dinner_tables]) ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit_table"><?= lang('Common.submit'); ?></button>
    </div>

<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {

        const enable_disable_dinner_table_enable = (function() {
            const dinner_table_enable = $("#dinner_table_enable").is(":checked");
            $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").prop("disabled", !dinner_table_enable);
            if (dinner_table_enable) {
                $(".add_dinner_table, .remove_dinner_table").show();
            } else {
                $(".add_dinner_table, .remove_dinner_table").hide();
            }
            return arguments.callee;
        })();

        $("#dinner_table_enable").change(enable_disable_dinner_table_enable);

        let table_count = <?= sizeof($dinner_tables) ?>;

        const hide_show_remove = function() {
            if ($("input[name*='dinner_table']:enabled").length > 1) {
                $(".remove_dinner_table").show();
            } else {
                $(".remove_dinner_table").hide();
            }
        };

        const add_dinner_table = function() {
            var $rows = $('#dinner_tables_list .table-row');
            var $new_block;
            if ($rows.length > 0) {
                $new_block = $rows.last().clone(true);
            } else {
                $new_block = $($('#dinner_table_template').html());
                $new_block.find('.remove_dinner_table').click(remove_dinner_table);
            }

            // Calculate next available ID number
            var max_id = 0;
            $('#dinner_tables_list input.dinner_table').each(function() {
                var attr_id = $(this).attr('id');
                if (attr_id) {
                    var match = attr_id.match(/dinner_table_(\d+)/);
                    if (match) {
                        var num = parseInt(match[1], 10);
                        if (num > max_id) max_id = num;
                    }
                }
            });
            var new_id = max_id + 1;
            ++table_count;

            var new_block_id = 'dinner_table_' + new_id;

            $new_block.removeClass('d-none').show();
            $new_block.find('.table-label').html("<?= lang('Config.dinner_table') ?> " + table_count).attr('for', new_block_id);
            $new_block.find('.table-number').text(new_id + '.');
            $new_block.find('input').attr('id', new_block_id).removeAttr('disabled').attr('name', new_block_id).val('');

            $('#dinner_tables_list').append($new_block);
            hide_show_remove();
        };

        const remove_dinner_table = function() {
            $(this).closest('.table-row').remove();
            hide_show_remove();
        };

        const init_add_remove_tables = function() {
            $('.add_dinner_table').click(add_dinner_table);
            $('.remove_dinner_table').click(remove_dinner_table);
            hide_show_remove();
            // Set back disabled state
            enable_disable_dinner_table_enable();
        };
        init_add_remove_tables();

        const duplicate_found = false;
        // Run validator once for all fields
        $.validator.addMethod('dinner_table', function(value, element) {
            let value_count = 0;
            $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count < 2;
        }, "<?= lang('Config.dinner_table_duplicate') ?>");

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === -1;
        }, "<?= lang('Config.dinner_table_invalid_chars') ?>");

        $('#table_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("input[name*='dinner_table']:not(input[name=dinner_table_enable])").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#dinner_tables").load('<?= "config/dinnerTables" ?>', init_add_remove_tables);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: "#table_error_message_box",

            rules: {
                <?php
                $i = 0;

                foreach ($dinner_tables as $dinner_table => $table) {
                ?>
                    <?= 'dinner_table_' . ++$i ?>: {
                        required: true,
                        dinner_table: true,
                        valid_chars: true
                    },
                <?php } ?>
            },

            messages: {
                <?php
                $i = 0;

                foreach ($dinner_tables as $dinner_table => $table) {
                ?>
                    <?= 'dinner_table_' . ++$i ?>: "<?= lang('Config.dinner_table_required') ?>",
                <?php } ?>
            }
        }));
    });
</script>
