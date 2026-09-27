<?php
/**
 * @var array $stock_locations
 */
?>

<?= form_open('config/saveLocations/', ['id' => 'location_config_form']) ?>

    <?php
    $title_info['config_title'] = lang('Config.location_configuration');
    echo view('configs/config_header', $title_info);
    ?>

    <ul id="error_message_box" class="stock_error_message_box alert alert-warning d-none"></ul>

    <div id="stock_locations">
        <?= view('partial/stock_locations', ['stock_locations' => $stock_locations]) ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit_stock"><?= lang('Common.submit'); ?></button>
    </div>

<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        let location_count = <?= sizeof($stock_locations) ?>;

        const hide_show_remove = function() {
            if ($("input[name*='stock_location']:enabled").length > 1) {
                $(".remove_stock_location").show();
            } else {
                $(".remove_stock_location").hide();
            }
        };

        const add_stock_location = function() {
            var $rows = $('#stock_locations_list .location-row');
            var $new_block;
            if ($rows.length > 0) {
                $new_block = $rows.last().clone(true);
            } else {
                $new_block = $($('#stock_location_template').html());
                $new_block.find('.remove_stock_location').click(remove_stock_location);
            }
            ++location_count;

            var new_block_id = 'stock_location[]';
            $new_block.removeClass('d-none').show();
            $new_block.find('.location-label').html("<?= lang('Config.stock_location') ?> " + location_count).attr('for', new_block_id);
            $new_block.find('.location-number').text(location_count + '.');
            $new_block.find('input').attr('id', new_block_id).removeAttr('disabled').attr('name', new_block_id).val('');

            $('#stock_locations_list').append($new_block);
            hide_show_remove();
        };

        const remove_stock_location = function() {
            $(this).closest('.location-row').remove();
            hide_show_remove();
        };

        const init_add_remove_locations = function() {
            $('.add_stock_location').click(add_stock_location);
            $('.remove_stock_location').click(remove_stock_location);
            hide_show_remove();
        };
        init_add_remove_locations();

        const duplicate_found = false;
        // Run validator once for all fields
        $.validator.addMethod('stock_location', function(value, element) {
            let value_count = 0;
            $("input[name*='stock_location']").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count < 2;
        }, "<?= lang('Config.stock_location_duplicate') ?>");

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === -1;
        }, "<?= lang('Config.stock_location_invalid_chars') ?>");

        $('#location_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#stock_locations").load('<?= "config/stockLocations" ?>', init_add_remove_locations);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: ".stock_error_message_box",

            rules: {
                <?php
                $i = 0;

                foreach ($stock_locations as $location => $location_data) {
                ?>
                    <?= 'stock_location_' . ++$i ?>: {
                        required: true,
                        stock_location: true,
                        valid_chars: true
                    },
                <?php } ?>
            },

            messages: {
                <?php
                $i = 0;

                foreach ($stock_locations as $location => $location_data) {
                ?>
                    <?= 'stock_location_' . ++$i ?>: "<?= lang('Config.stock_location_required') ?>",
                <?php } ?>
            }
        }));
    });
</script>
