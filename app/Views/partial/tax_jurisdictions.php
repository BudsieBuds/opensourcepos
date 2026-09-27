<?php
/**
 * @var array $tax_jurisdictions
 * @var array $tax_types
 */
?>

<?php
$i = 0;

foreach ($tax_jurisdictions as $tax_jurisdiction => $jurisdiction) {
    $jurisdiction_id = $jurisdiction['jurisdiction_id'];
    $jurisdiction_name = $jurisdiction['jurisdiction_name'];
    $tax_group = $jurisdiction['tax_group'];
    $reporting_authority = $jurisdiction['reporting_authority'];
    $tax_type = $jurisdiction['tax_type'];
    $tax_group_sequence = $jurisdiction['tax_group_sequence'];
    $cascade_sequence = $jurisdiction['cascade_sequence'];
    ++$i;
?>

    <div class="row g-2 mb-3 align-items-center">
        <?= form_label(lang('Taxes.tax_jurisdiction') . " $i", "jurisdiction_name_$i", ['class' => 'col-form-label col-form-label-sm col-md-2']) ?>
        <div class="col-md-2">
            <?php $form_data = [
                'name'        => 'jurisdiction_name[]',
                'id'          => "jurisdiction_name_$i",
                'class'       => 'valid_chars form-control form-control-sm',
                'placeholder' => lang('Taxes.jurisdiction_name'),
                'value'       => $jurisdiction_name
            ];
            echo form_input($form_data);
            ?>
        </div>

        <div class="col-md-1">
            <?php $form_data = [
                'name'        => 'tax_group[]',
                'class'       => 'valid_chars form-control form-control-sm',
                'placeholder' => lang('Taxes.tax_group'),
                'value'       => $tax_group
            ];
            echo form_input($form_data);
            ?>
        </div>

        <div class="col-md-2">
            <?= form_dropdown('tax_type[]' . $i, $tax_types, $tax_type, ['class' => 'form-select form-select-sm']) ?>
        </div>

        <div class="col-md-2">
            <?php $form_data = [
                'name'        => 'reporting_authority[]',
                'class'       => 'valid_chars form-control form-control-sm',
                'placeholder' => lang('Taxes.reporting_authority'),
                'value'       => $reporting_authority
            ];
            echo form_input($form_data);
            ?>
        </div>

        <div class="col-md-1">
            <?php $form_data = [
                'name'        => 'tax_group_sequence[]',
                'class'       => 'valid_chars form-control form-control-sm',
                'placeholder' => lang('Taxes.sequence'),
                'value'       => $tax_group_sequence
            ];
            echo form_input($form_data);
            ?>
        </div>

        <div class="col-md-1">
            <?php $form_data = [
                'name'        => 'cascade_sequence[]',
                'class'       => 'valid_chars form-control form-control-sm',
                'placeholder' => lang('Taxes.cascade_sequence'),
                'value'       => $cascade_sequence
            ];
            echo form_input($form_data);
            ?>
        </div>

        <div class="col-auto">
            <span class="add_tax_jurisdiction bi bi-plus-circle" style="cursor: pointer;"></span>
            <span>&nbsp;&nbsp;</span>
            <span class="remove_tax_jurisdiction bi bi-dash-circle" style="cursor: pointer;"></span>
            <?= form_hidden('jurisdiction_id[]', (string)$jurisdiction_id) ?>
        </div>
    </div>

<?php } ?>
