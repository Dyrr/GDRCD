<?php
ob_start("ob_gzhandler");
echo phpinfo();
ob_get_clean();