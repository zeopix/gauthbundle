<?php
$t = file_get_contents("https://picasaweb.google.com/data/feed/api/user/zeopix/albumid/5651031111891371441");

print_r(simplexml_load_string($t));
?>