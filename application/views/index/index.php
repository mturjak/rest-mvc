<div class="content">
    <h1>Index</h1>

    <!-- echo out the system feedback (error and success messages) -->
    <?php //$this->renderFeedbackMessages(); ?>
    <p></p>
    <p>
        This box (everything between header and footer) is the content of views/index/index.php,
        so it's the index/index view.
        <br/>
        It's rendered by the index-method within the index-controller (in controllers/index.php).
    </p>
    <h3>General information on this little framework</h3>
    <p>
    <?php
    if(DEBUG_MODE){
        d(debug_backtrace());
    }
    ?>
    </p>
</div>
