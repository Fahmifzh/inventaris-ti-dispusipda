<?php

session_start();
session_unset();
session_destroy();

header("Location: /inventaris-ti-dispusipda/login.php");
exit;