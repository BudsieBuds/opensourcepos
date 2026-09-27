<?php
/**
 * @var array $tax_jurisdictions
 * @var string $tax_type_options
 */
?>

<?= form_open('taxes/save_tax_jurisdictions/', ['id' => 'tax_jurisdictions_form']) ?>

    <ul id="tax_jurisdictions_error_message_box" class="alert alert-warning d-none"></ul>

    <div id="tax_jurisdictions">
        <?= view('partial/tax_jurisdictions') ?>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="submit_tax_jurisdictions"><?= lang('Common.submit'); ?></button>
    </div>

<?= form_close() ?>

<script type="text/javascript">
    // Validation and Submit Handling
    $(document).ready(function() {
        let tax_jurisdictions_count = <?= sizeof($tax_jurisdictions) ?>;
        if (tax_jurisdictions_count == 0) {
            tax_jurisdictions_count = 1;
        }
        const tax_type_options = '<?= esc($tax_type_options, 'js') ?>';

        const hide_show_remove_tax_jurisdiction = function() {
            if ($("input[name*='tax_jurisdiction']:enabled").length > 1) {
                $(".remove_tax_jurisdiction").show();
            } else {
                $(".remove_tax_jurisdiction").hide();
            }
        };

        const add_tax_jurisdiction = function() {
            var $row = $(this).closest('.row');
            var id = $row.find('input').attr('id');
            if (id) {
                id = id.replace(/.*?_(\d+)$/g, "$1");
            }

            var previous_jurisdiction_name_id = 'jurisdiction_name_' + id;
            var block = $row.clone(true);
            var new_block = block.insertAfter($row);
            ++tax_jurisdictions_count;
            const new_jurisdiction_name_id = 'jurisdiction_name_' + tax_jurisdictions_count;

            $(new_block).find('label').html("<?= lang('Taxes.tax_jurisdiction') ?> " + tax_jurisdictions_count).attr('for', new_jurisdiction_name_id).attr('class', 'col-form-label col-form-label-sm col-md-2');
            var $input = $(new_block).find("input[name='jurisdiction_name[]']").attr('id', new_jurisdiction_name_id).removeAttr('disabled').attr('class', 'form-control form-control-sm required').val('');
            $(new_block).find("input[name='tax_group[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm required').val('');
            $(new_block).find("select[name='tax_type[]']").removeAttr('disabled').attr('class', 'form-select form-select-sm required').val('');
            $(new_block).find("input[name='reporting_authority[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm').val('');
            $(new_block).find("input[name='tax_group_sequence[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm').val('');
            $(new_block).find("input[name='cascade_sequence[]']").removeAttr('disabled').attr('class', 'form-control form-control-sm').val('');
            $(new_block).find("input[name='jurisdiction_id[]']").val('-1');

            $input.rules('add', {
                requireTaxJurisdiction: true,
                check4TaxJurisdictionDups: true,
                validateTaxJurisdictionCharacters: true
            });

            hide_show_remove_tax_jurisdiction();
        };

        const remove_tax_jurisdiction = function() {
            $(this).closest('.row').remove();
            hide_show_remove_tax_jurisdiction();
        };

        const init_add_remove_tax_jurisdiction = function() {
            $('.add_tax_jurisdiction').click(add_tax_jurisdiction);
            $('.remove_tax_jurisdiction').click(remove_tax_jurisdiction);
            hide_show_remove_tax_jurisdiction();
        };
        init_add_remove_tax_jurisdiction();

        // Run validator once for all fields
        $.validator.addMethod('check4TaxJurisdictionDups', function(value, element) {
            let value_count = 0;
            $("input[name='jurisdiction_name[]']").each(function() {
                value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
            return value_count <= 1;

        }, "<?= lang('Taxes.tax_jurisdiction_duplicate') ?>");

        $.validator.addMethod('validateTaxJurisdictionCharacters', function(value, element) {
            return (value.indexOf('_') == -1);

        }, "<?= lang('Taxes.tax_jurisdiction_invalid_chars') ?>");

        $.validator.addMethod('requireTaxJurisdiction', function(value, element) {
            return value.trim() != '';

        }, "<?= lang('Taxes.tax_jurisdiction_required') ?>");

        $('#tax_jurisdictions_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            icon: 'bi bi-bell-fill',
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        });
                        $("#tax_jurisdictions").load('<?= esc("taxes/ajax_tax_jurisdictions") ?>', init_add_remove_tax_jurisdiction);
                    },
                    dataType: 'json'
                });
            },
            invalidHandler: function(event, validator) {
                $.notify("<?= lang('Common.correct_errors') ?>");
            },
            errorLabelContainer: "#tax_jurisdiction_error_message_box"
        }));

        <?php
        $i = 0;
        foreach ($tax_jurisdictions as $tax_jurisdiction => $tax_jurisdiction_data) {
        ?>
            $('<?= '#jurisdiction_name_' . ++$i ?>').rules("add", {
                requireTaxJurisdiction: true,
                check4TaxJurisdictionDups: true,
                validateTaxJurisdictionCharacters: true
            });
        <?php } ?>
    });
</script>
