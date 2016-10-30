<?php
include_once('common/header.tpl');
?>

<div class="header">
    Type valid uri in a field beside.
</div>

<form action="/test_task/index.php/UriController" method="post">
    <div>
        <input id="originalUriField" type="text" name="originalUri" value="<?=$originalUri ?>"/>
    </div>

    <?php if ($shortUri) { ?>
        <div class="shortUriCont" style="padding-top: 15px;">
            Short Uri: <br/>
            <input id="shortUriField" type="text" name="shortUri" value="<?=$shortUri ?>"/>
        </div>
    <?php } ?>

    <div>
        <input type="submit" value="Generate"/>
        <?php if ($shortUri) { ?>
            <input id="save" type="button" value="Save"/>
        <?php } ?>
    </div>

    <div id="responseCont"></div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#save').click(function () {
            $.ajax({
                type: "POST",
                url: "/test_task/index.php/UriController/saveUriPair",
                data: "originalUri=" + $('#originalUriField').val() + "&shortUri=" + $('#shortUriField').val(),
                success: function (msg) {
                    $('#responseCont').html(msg);
                }
            })
        });
    });

</script>
<?php
include_once('common/footer.tpl');
?>