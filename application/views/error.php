<div class="content">
    <h1 style="color: red;">
        <?php echo $message; ?>
    </h1>
    <div>
    <?php
    $backtrace = debug_backtrace();
    d($backtrace);
    ?>
    </div>
</div>