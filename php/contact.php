<?php

    $array = array("firstname" => "", "name" => "", "message" => "", "email" => "", "phone" => "", "firstnameError" => "",
     "nameError" => "", "messageError" => "", "emailError" => "", "phoneError" => "", "isSuccess" => false);
    
    $emailTo = "pat_chiasson@yahoo.ca";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $array["firstname"] = verifyInput($_POST["firstname"]);
        $array["name"] = verifyInput($_POST["name"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["phone"] = verifyInput($_POST["phone"]);
        $array["message"] = verifyInput($_POST["message"]);
        $array["isSuccess"] = true;
        $emailText = "";

        if(empty($array["firstname"])){
            $array["firstnameError"] = "Je veux connaitre ton prenom !";
            $array['isSuccess'] = false;
        }
        else
            $emailText .= "First name: {$array["firstname"]}\n";

        if(empty($array["name"])){
            $array["nameError"] = "Je veux aussi connaitre ton nom !";
            $array["isSuccess"] = false;
        }
        else
            $emailText .= "Last name: {$array["name"]}\n\n";

        if(empty($array["message"])){
            $array["messageError"] = "Qu'est-ce que tu veux me dire ?";
            $array["isSuccess"] = false;
        }
        else
            $emailText .= "Message: {$array["message"]}\n\n";

        if(!isEmail($array["email"])){
            $array["emailError"] = "Mais c'est n'importe quoi cet email !?!";
            $array["isSuccess"] = false;
        }
        else
            $emailText .= "eMail: {$array["email"]}\n";

        if(!isPhone($array["phone"])){
            $array["phoneError"] = "Que des chiffres et des espaces, stp...";
            $array["isSuccess"] = false;
        }
        else
            $emailText .= "Phone: {$array["phone"]}\n";

        if($array["isSuccess"]){
            $headers = "From: {$array["firstname"]} {$array["name"]}<{$array["email"]}>\r\nReply-To: {$array["email"]}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
        }

        echo json_encode($array);
    }

    function verifyInput($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

    function isEmail($var){
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function isPhone($var){
        return preg_match("/^[0-9 ]*$/", $var);
    }
?>