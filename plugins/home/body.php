<?php
echo Lang::tr("just some dummy text as placeholder..", __PLUGINS_DIR__."/home");
?>

<div>
    <strong>$plugin</strong>
    <pre>
        <?php var_dump($plugin); ?>
    </pre>
</div>

<div>
    <strong>$params</strong>
    <pre>
        <?php var_dump($params); ?>
    </pre>
</div>