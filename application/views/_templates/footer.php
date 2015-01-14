    <div class="footer">
        <!-- echo out the content of the SESSION via KINT, a Composer-loaded much better version of var_dump -->
        <!-- KINT can be used with the simple function d() -->
        <?php  d($data); ?>
        <?php if(isset($_SESSION)) d($_SESSION); ?>
    </div>
</body>
</html>
