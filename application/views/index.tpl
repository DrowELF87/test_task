<?php
include_once('common/header.tpl');
?>
<sсript type="text/javascript" src="/js/jquery-3.1.1.min.js"></sсript>
<div class="header">
    Type valid uri in a field beside.
</div>

<form action="/test_task/index.php/UriController" method="post">
    <div>
        <input type="text" name="originalUri" value="<?=$originalUri ?>"/>
    </div>

    <?php if ($shortUri) { ?>
        <div class="shortUriCont" style="padding-top: 15px;">
            Short Uri: <br/>
            <input type="text" name="shortUri" value="<?=$shortUri ?>"/>
        </div>
    <?php } ?>

    <div>
        <input type="submit" value="Generate"/>
        <?php if ($shortUri) { ?>
            <input type="button" value="Save"/>
        <?php } ?>
    </div>
</form>
<?php
include_once('common/footer.tpl');
?>