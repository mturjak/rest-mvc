<?php
// data resources not to display:
$silent = array('flash', 'render_without_header_and_footer');

echo json_encode(array_diff_key($this->all(), array_flip($silent)));