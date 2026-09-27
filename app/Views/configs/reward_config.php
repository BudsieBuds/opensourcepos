<?php
/**
 * @var array $customer_rewards
 * @var array $config
 */
?>

<?= form_open('config/saveRewards/', ['id' => 'reward_config_form']) ?>

    <?php
    $title_info['config_title'] = lang('Config.reward_configuration');
    echo view('configs/config_header', $title_info);
    ?>

    <ul id="error_message_box" class="reward_error_message_box alert alert-warning d-none"></ul>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="customer_reward_enable" name="customer_reward_enable" value="customer_reward_enable" <?= $config['customer_reward_enable'] == 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="customer_reward_enable"><?= lang('Config.customer_reward_enable'); ?></label>
    </div>

    <div class="row" id="customer_rewards">
        <?= view('partial/customer_rewards', ['customer_rewards' => $customer_rewards]) ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit_reward"><?= lang('Common.submit'); ?></button>
    </div>

<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {

        const enable_disable_customer_reward_enable = (function() {
            const customer_reward_enable = $("#customer_reward_enable").is(":checked");
            $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").prop("disabled", !customer_reward_enable);
            $("input[name*='reward_points_']:not(input[name=customer_reward_enable])").prop("disabled", !customer_reward_enable);
            if (customer_reward_enable) {
                $(".add_customer_reward, .remove_customer_reward").show();
            } else {
                $(".add_customer_reward, .remove_customer_reward").hide();
            }
            return arguments.callee;
        })();

        $("#customer_reward_enable").change(enable_disable_customer_reward_enable);

        let table_count = <?= sizeof($customer_rewards) ?>;

        const hide_show_remove = function() {
            if ($("input[name*='customer_reward']:enabled").length > 1) {
                $(".remove_customer_reward").show();
            } else {
                $(".remove_customer_reward").hide();
            }
        };

        const add_customer_reward = function() {
            var $rows = $('#customer_rewards_list .reward-row');
            var $new_block;
            if ($rows.length > 0) {
                $new_block = $rows.last().clone(true);
            } else {
                $new_block = $($('#customer_reward_template').html());
                $new_block.find('.remove_customer_reward').click(remove_customer_reward);
            }

            // Calculate next reward ID number
            var max_id = 0;
            $('#customer_rewards_list input[name^="customer_reward_"]').each(function() {
                var attr_id = $(this).attr('id');
                if (attr_id) {
                    var match = attr_id.match(/customer_reward_(\d+)/);
                    if (match) {
                        var num = parseInt(match[1], 10);
                        if (num > max_id) max_id = num;
                    }
                }
            });
            var new_id = max_id + 1;
            ++table_count;

            var new_reward_id = 'customer_reward_' + new_id;
            var new_points_id = 'reward_points_' + new_id;

            $new_block.removeClass('d-none').show();
            $new_block.find('.reward-label').html("<?= lang('Config.customer_reward') ?> " + table_count).attr('for', new_reward_id);
            $new_block.find('.reward-number').text(new_id + '.');
            $new_block.find('input').eq(0).attr('id', new_reward_id).removeAttr('disabled').attr('name', new_reward_id).val('');
            $new_block.find('input').eq(1).attr('id', new_points_id).removeAttr('disabled').attr('name', new_points_id).val('');

            $('#customer_rewards_list').append($new_block);
            hide_show_remove();
        };

        const remove_customer_reward = function() {
            $(this).closest('.reward-row').remove();
            hide_show_remove();
        };

        const init_add_remove_tables = function() {
            $('.add_customer_reward').click(add_customer_reward);
            $('.remove_customer_reward').click(remove_customer_reward);
            hide_show_remove();
            // Set back disabled state
            enable_disable_customer_reward_enable();
        };
        init_add_remove_tables();

        const duplicate_found = false;
        // Run validator once for all fields
        $.validator.addMethod('customer_reward', function(value, element) {
            let value_count = 0;
            $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count < 2;
        }, "<?= lang('Config.customer_reward_duplicate') ?>");

        $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === -1;
        }, "<?= lang('Config.customer_reward_invalid_chars') ?>");

        $('#reward_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("input[name*='customer_reward']:not(input[name=customer_reward_enable])").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#customer_rewards").load('<?= "config/customerRewards" ?>', init_add_remove_tables);
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: ".reward_error_message_box",

            rules: {
                <?php
                $i = 0;

                foreach ($customer_rewards as $customer_reward => $table) {
                ?>
                    <?= 'customer_reward_' . ++$i ?>: {
                        required: true,
                        customer_reward: true,
                        valid_chars: true
                    },
                <?php } ?>
            },

            messages: {
                <?php
                $i = 0;

                foreach ($customer_rewards as $customer_reward => $table) {
                ?>
                    <?= 'customer_reward_' . ++$i ?>: "<?= lang('Config.customer_reward_required') ?>",
                <?php } ?>
            }
        }));
    });
</script>
