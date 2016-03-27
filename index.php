<?php
//teste

include '../Config/config.php';

session_destroy();
header("Location: Modulos/Login.php");
