<?php
/**
 * @var array $stock_locations
 */
?>

<span class="d-flex justify-content-start">
    <button type="button" class="btn btn-outline-success mb-3 add_stock_location"><i class="bi bi-plus-lg"></i>&nbsp;Add location</button> <!-- TODO-BS5 translate -->
</span>

<div class="row" id="stock_locations_list">
<?php
$i = 0;

foreach ($stock_locations as $location => $location_data) {
    $location_id = $location_data['location_id'];
    $location_name = $location_data['location_name'];
    ++$i;
?>

    <div class="col-12 col-lg-6 location-row <?= $location_data['deleted'] ? 'd-none' : '' ?>">
        <label for="stock_location_<?= $i ?>" class="form-label location-label"><?= lang('Config.stock_location') . " $i"; ?></label>
        <div class="input-group mb-3">
            <span class="input-group-text location-number"><?= $location_id ?>.</span>
            <input type="text" class="form-control stock_location valid_chars" name="stock_location[<?= $location_id ?>]" id="stock_location_<?= $location_id ?>" value="<?= esc($location_name) ?>" required <?= $location_data['deleted'] ? 'disabled' : '' ?>>
            <button type="button" class="btn btn-outline-danger remove_stock_location"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>

<?php } ?>
</div>

<template id="stock_location_template">
    <div class="col-12 col-lg-6 location-row">
        <label class="form-label location-label"></label>
        <div class="input-group mb-3">
            <span class="input-group-text location-number"></span>
            <input type="text" class="form-control stock_location valid_chars" placeholder="Location name" required>
            <button type="button" class="btn btn-outline-danger remove_stock_location"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>
</template>
