<?php

$pw = password_hash('test1', PASSWORD_DEFAULT); //test1は暗号化したいパスワードを入れると、hash化する

echo $pw;//暗号化したパスワードが入る




?>