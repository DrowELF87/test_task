<sсript type="text/javascript" src="/js/jquery-3.1.1.min.js"></sсript>

<div class="header">
    Type valid uri in a field beside.
</div>

<form action="index.php/UriController" method="post">
    <div>
        <input type="text" name="originalUri" value=""/>
    </div>

    <div>
        <input type="checkbox"/> Set short uri manually
    </div>

    <div class="shortUriCont" id="zxc">
        <input type="text" name="shortUri" value=""/>
    </div>

    <div>
        <input type="submit" value="Ok"/>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        //your code here
        alert('zzz');
    });
</script>