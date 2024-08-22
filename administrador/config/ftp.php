<?php

$ftp_server="ftpupload.net";

 $ftp_user_name="if0_37157669";

 $ftp_user_pass="NSbqsEN3mut88Jb";

 //tobe uploaded

 $remote_file = "../../imgProductos/";



 // set up basic connection

 $conn_id = ftp_connect($ftp_server);



 // login with username and password

 $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);




?>