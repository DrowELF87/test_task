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

<?php if (!empty($stored)) { ?>
        <select>
        <?php foreach ($stored as $storeItem) { ?>
              <option value="<?=$storeItem->original_uri ?>">
                  <?=$storeItem->short_uri ?>
              </option>
        <?php } ?>
        </select>
        <input type="button" value="Share">

        <select>
            <?php foreach ($users as $user) { ?>
                <option value="<?=$user->id ?>">
                    <?=$user->fname ?>&nbsp;<?=$user->lname ?>
                </option>
            <?php } ?>
        </select>
<?php } ?>

<div class="income">
    Income (<?=count($myUri) ?>)
    <ul class="incomeCont">
        <?php foreach ($myUri as $myUriItem) { ?>
            <li>
                <a href="http://<?=$myUriItem->original_uri ?>" target="_blank"><?=$myUriItem->short_uri ?></a><br/>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="settings">
    Settings
</div>

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

        $('.income').click(function () {
            $('.incomeCont').toggle('fast');
        })
    });

</script>
<?php
include_once('common/footer.tpl');
?>