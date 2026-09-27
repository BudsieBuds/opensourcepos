<?php
/**
 * @var array $customer_rewards
 */
?>

<span class="d-flex justify-content-start">
    <button type="button" class="btn btn-outline-success mb-3 add_customer_reward"><i class="bi bi-plus-lg"></i>&nbsp;Add reward</button> <!-- TODO-BS5 translate -->
</span>

<div class="row" id="customer_rewards_list">
    <?php
    $i = 0;

    foreach ($customer_rewards as $reward_key => $reward_category) {
        $customer_reward_id = $reward_category['package_id'];
        $customer_reward_name = $reward_category['package_name'];
        $customer_points_percent = $reward_category['points_percent'];
        ++$i;
    ?>

        <div class="col-12 col-lg-6 reward-row <?= $reward_category['deleted'] ? 'd-none' : '' ?>">
            <label for="customer_reward_<?= $customer_reward_id ?>" class="form-label reward-label"><?= lang('Config.customer_reward') . " $i"; ?></label>
            <div class="input-group mb-3">
                <span class="input-group-text reward-number"><?= $customer_reward_id ?>.</span>
                <input type="text" class="form-control customer_reward valid_chars w-50" name="customer_reward_<?= $customer_reward_id ?>" id="customer_reward_<?= $customer_reward_id ?>" value="<?= esc($customer_reward_name) ?>" placeholder="Reward name" required <?= $reward_category['deleted'] ? 'disabled' : '' ?>>
                <input type="number" min="0" class="form-control customer_reward valid_chars" name="reward_points_<?= $customer_reward_id ?>" id="reward_points_<?= $customer_reward_id ?>" value="<?= esc($customer_points_percent) ?>" placeholder="0" required <?= $reward_category['deleted'] ? 'disabled' : '' ?>>
                <button type="button" class="btn btn-outline-danger remove_customer_reward"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>

    <?php } ?>
</div>

<template id="customer_reward_template">
    <div class="col-12 col-lg-6 reward-row">
        <label class="form-label reward-label"></label>
        <div class="input-group mb-3">
            <span class="input-group-text reward-number"></span>
            <input type="text" class="form-control customer_reward valid_chars w-50" placeholder="Reward name" required>
            <input type="number" min="0" class="form-control customer_reward valid_chars" placeholder="0" required>
            <button type="button" class="btn btn-outline-danger remove_customer_reward"><i class="bi bi-x-lg"></i></button>
        </div>
    </div>
</template>
