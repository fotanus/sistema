<?php

class Smtp {

    function __contruct() {
        
    }

    function SendEmail($from, $fromname, $to, $toname, $subject, $message) {
        //Details, from, from name, to, to name
        $logArray['Vars'] = array("De" => $from, "De Nombre" => $fromname, "Para" => $to, "Para Nombre" => $toname);
        
        //Server configuration
        $smtpServer = "mail.misistemapyme.mx";
        $port = "25";
        $timeout = "2";
        $username = "no-reply@misistemapyme.mx";
        $password = "";
        $identify = "localhost"; // This is used at the start of the connection to identify yourself but value isn't checked
        $newLine = "\r\n";
       
        //Connect to the host on the specified port
        $smtpConnect = @fsockopen($smtpServer, $port, $errno, $errstr, $timeout);

        if (empty($smtpConnect)) {
            $logArray['connection'] = "Failed to connect";
            $logArray['SUCCESS'] = "FALSE";
            return $logArray;
        }

        stream_set_timeout($smtpConnect, $timeout);

        $smtpResponse = fgets($smtpConnect, 515);
        $info = stream_get_meta_data($smtpConnect);
        if ($info['timed_out']) {
            $logArray['connection'] = "Timeout: $smtpResponse";
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }
        $logArray['connection'] = "Connected: $smtpResponse";

        //--- Say hello to the server --------
        fputs($smtpConnect, "EHLO " . $identify . $newLine);
        $logArray['ehlo'] = fgets($smtpConnect, 515);
        $info = stream_get_meta_data($smtpConnect);

        $i = 0;
        while (!$info['timed_out']) {
            $logArray['ehlo'] .= fgets($smtpConnect, 515);
            $info = stream_get_meta_data($smtpConnect);
            $i++;
        }
        if ($i = 0) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Request Auth Login --------
        fputs($smtpConnect, "AUTH LOGIN" . $newLine);
        $logArray['authrequest'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['authrequest'], "334")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Send username --------
        fputs($smtpConnect, base64_encode($username) . $newLine);
        $logArray['authusername'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['authusername'], "334")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Send password --------
        fputs($smtpConnect, base64_encode($password) . $newLine);
        $logArray['authpassword'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['authpassword'], "235")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Email From --------
        fputs($smtpConnect, "MAIL FROM: $from" . $newLine);
        $logArray['mailfrom'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['mailfrom'], "250")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Email To --------
        fputs($smtpConnect, "RCPT TO: $to" . $newLine);
        $logArray['mailto'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['mailto'], "250")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- The Email --------
        fputs($smtpConnect, "DATA" . $newLine);
        $logArray['data1'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['data1'], "354")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Construct Headers --------
        $headers = "MIME-Version: 1.0" . $newLine;
        $headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
        $headers .= "To: " . $toname . " <" . $to . ">" . $newLine;
        $headers .= "From: " . $fromname . " <" . $from . ">" . $newLine;
        $headers .= "Subject: " . $subject . $newLine;

        $message = str_replace("\n.", "\n..", $message);


        fputs($smtpConnect, $headers . $newLine . $message . "\n.\n");
        $logArray['data2'] = fgets($smtpConnect, 515);
        if (false === strpos($logArray['data2'], "250")) {
            $logArray['SUCCESS'] = "FALSE";
            fclose($smtpConnect);
            return $logArray;
        }

        //--- Say Bye to SMTP --------
        fputs($smtpConnect, "QUIT" . $newLine);
        $logArray['quit'] = fgets($smtpConnect, 515);

        //fclose($smtpConnect);
        $logArray['SUCCESS'] = "TRUE";

        return $logArray;
    }

}

?>