<?php // Data Extraction tab for reporting ?>

<script>
$(document).ready(function () {
    let qe = null;
    <?php if ($project->get_extraction() > 0) {
    foreach ($extraction as $qe){ ?>
        qe = new Extraction_Chars('<?=$qe['id']?>', '<?=$qe['type']?>',<?=json_encode($qe['data'])?>);
        qe.show();
    <?php }
    foreach ($multiple as $qe){ ?>
        qe = new Extraction_Chars('<?=$qe['id']?>', '<?=$qe['type']?>',<?=json_encode($qe['data'])?>);
        qe.show();
    <?php }
    } ?>
});
</script>

<div class="card">
    <div class="card-body">
        <div id="extraction_content"></div>
    </div>
</div>
