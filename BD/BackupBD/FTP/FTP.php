<?php

// **********************************************************//
// ----------------------- DADOS FTP ----------------------- //
// Nome de usuário do FTP: scpbkp_bd0223@app.dmweb.com.br    //
// Senha do usuário FTP: bTa9XGs^2MkZ                        //
// Servidor FTP: ftp.app.dmweb.com.br                        //
// FTP & porta FTPS explícita:  21                           //
// **********************************************************//

class FTP {

    function UploadFTP($file, $remote_file) {

        $ftp_server = "ftp.app.dmweb.com.br";
        $ftp_user_name = "scpbkp_bd0223@app.dmweb.com.br";
        $ftp_user_pass = "bTa9XGs^2MkZ";
        $file = ""; //tobe uploaded
        $remote_file = "";

        // set up basic connection
        $conn_id = ftp_connect($ftp_server);

        // login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        // upload a file
        if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
            echo "successfully uploaded $file\n";
            exit;
        } else {
            echo "There was a problem while uploading $file\n";
            exit;
        }
        // close the connection
        ftp_close($conn_id);
    }

}
