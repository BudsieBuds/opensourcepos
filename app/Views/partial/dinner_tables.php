<?php
/**
 * @var array $dinner_tables
 */
?>

<span class="d-flex justify-content-start">
    <button type="button" class="btn btn-outline-success mb-3 add_dinner_table"><i class="bi bi-plus-lg"></i>&nbsp;Add table</button> <!-- TODO-BS5 translate -->
</span>

<div class="row" id="dinner_tables_list">
    <?php
    $i = 0;

    foreach ($dinner_tables as $table_key => $table) {
        $dinner_table_id = $table['dinner_table_id'];
        $dinner_table_name = $table['name'];
        ++$i;
    ?>

        <div class="col-12 col-lg-6 table-row <?= $table['deleted'] ? 'd-none' : '' ?>">
            <label for="dinner_table_<?= $dinner_table_id ?>" class="form-label table-label"><?= lang('Config.dinner_table') . " $i"; ?></label>
            <div class="input-group mb-3">
                <span class="input-group-text table-number"><?= $dinner_table_id ?>.</span>
                <input type="text" class="form-control dinner_table valid_chars" name="dinner_table_<?= $dinner_table_id ?>" id="dinner_table_<?= $dinner_table_id ?>" value="<?= esc($dinner_table_name) ?>" placeholder="Table name" required <?= $table['deleted'] ? 'disabled' : '' ?>>
                <button type="button" class="btn btn-outline-danger remove_dinner_table"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

    <?php } ?>
</div>

<template id="dinner_table_template">
    <div class="col-12 col-lg-6 table-row">
        <label class="form-label table-label"></label>
        <div class="input-group mb-3">
            <span class="input-group-text table-number"></span>
            <input type="text" class="form-control dinner_table valid_chars" placeholder="Table name" required>
            <button type="button" class="btn btn-outline-danger remove_dinner_table"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>
</template>
