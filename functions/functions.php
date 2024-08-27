<?php

    function sanitize_input($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }
    
    function authenticate_user($conn,$username,$password){
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows>0){
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if(password_verify($password,$hashed_password)){
                return true;
            }
        }
        return false;
    }

?>