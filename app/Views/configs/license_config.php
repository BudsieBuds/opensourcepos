<?php
/**
 * @var array $licenses
 */
?>

<?php
/**
 * @var array $licenses
 */
?>

<h4 style="margin-top: 0;"><strong><i class="bi-journal-check icon-spacing"></i><?= lang('Config.license_configuration'); ?></strong></h4>
<hr style="margin-top: 0;">

<form id="config_form_license" enctype="multipart/form-data">

        <?php $counter = 0; ?>
        <?php foreach($licenses as $license): ?>
            <div class="form-group">
                <label for="license_<?= $counter ?>"><?= $license['title'] ?></label>
                <textarea name="license" rows="15" id="license_<?= $counter++; ?>" class="form-control" style="font-family: monospace; font-size: .9em; resize: vertical; min-height: 2.5em;" readonly><?= $license['text']; ?></textarea>
            </div>
        <?php endforeach; ?>

</form>
