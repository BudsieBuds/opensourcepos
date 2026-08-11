<?php
/**
 * @var array $tax_codes
 */
?>

<?= form_open('taxes/save_tax_codes/', ['id' => 'tax_codes_form']) ?>

    <ul id="tax_codes_error_message_box" class="alert alert-warning d-none"></ul>

    <div id="tax_codes">
        <?= view('partial/tax_codes', ['tax_codes' => $tax_codes]) ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit_tax_codes"><?= lang('Common.submit'); ?></button>
    </div>

<?= form_close() ?>

<script type="text/javascript">
    // Validation and Submit Handling
    $(document).ready(function() {
        let tax_code_count = <?= sizeof($tax_codes) ?>;
        if (tax_code_count == 0) {
            tax_code_count = 1;
        }

        const hide_show_remove_tax_code = function() {
            if ($("input[name*='tax_code']:enabled").length > 1) {
                $(".remove_tax_code").show();
            } else {
                $(".remove_tax_code").hide();
            }
        };

        const add_tax_code = function() {
            var $row = $(this).closest('.row');
            var id = $row.find("input[name='tax_code[]']").attr('id');
            if (id) {
                id = id.replace(/.*?_(\d+)$/g, "$1");
            }
            var block = $row.clone(true);
            var new_block = block.insertAfter($row);
            ++tax_code_count;
            const new_tax_code_id = 'tax_code_' + tax_code_count;

            $(new_block).find('label').html("<?= lang('Taxes.tax_code') ?> " + tax_code_count).attr('for', new_tax_code_id).attr('class', 'col-form-label col-form-label-sm col-md-2');
            var $input = $(new_block).find("input[name='tax_code[]']").attr('id', new_tax_code_id).removeAttr('disabled').attr('class', 'form-control form-control-sm text-uppercase required').val('');
            $(new_block).find("input[name='tax_code_name[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm required').val('');
            $(new_block).find("input[name='city[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm').val('');
            $(new_block).find("input[name='state[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm').val('');
            $(new_block).find("input[name='tax_code_id[]']").val('-1');

            $input.rules('add', {
                requireTaxCode: true,
                check4TaxCodeDups: true,
                validateTaxCodeCharacters: true
            });

            hide_show_remove_tax_code();
        };

        const remove_tax_code = function() {
            $(this).closest('.row').remove();
            hide_show_remove_tax_code();
        };

        const init_add_remove_tax_codes = function() {
            $('.add_tax_code').click(add_tax_code);
            $('.remove_tax_code').click(remove_tax_code);
            hide_show_remove_tax_code();
        };
        init_add_remove_tax_codes();

        // Run validator once for all fields
        $.validator.addMethod('check4TaxCodeDups', function(value, element) {
            let value_count = 0;
            $("input[name='tax_code[]']").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count <= 1;

        }, "<?= lang('Taxes.tax_code_duplicate') ?>");

        $.validator.addMethod('validateTaxCodeCharacters', function(value, element) {
            return (value.indexOf('_') == -1);

        }, "<?= lang('Taxes.tax_code_invalid_chars') ?>");

        $.validator.addMethod('requireTaxCode', function(value, element) {
            return value.trim() != '';

        }, "<?= lang('Taxes.tax_code_required') ?>");

        $('#tax_codes_form').validate($.extend(form_support.handler, {
            submitHandler: function(form, event) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#tax_codes").load('<?= "taxes/ajax_tax_codes" ?>', init_add_remove_tax_codes);
                    },
                    dataType: 'json'
                });
            },
            invalidHandler: function(event, validator) {
                $.notify("<?= lang('Common.correct_errors') ?>");
            },
            errorLabelContainer: "#tax_code_error_message_box"
        }));

        <?php
        $i = 0;
        foreach ($tax_codes as $tax_code => $tax_code_data) {
        ?>
            $('<?= '#tax_code_' . ++$i ?>').rules("add", {
                requireTaxCode: true,
                check4TaxCodeDups: true,
                validateTaxCodeCharacters: true
            });
        <?php } ?>

    });
</script>
