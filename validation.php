<?php
 $errors = array();

 // Validate the 'name' field
 if (empty($_POST["username"])) {
     $errors["username"] = "Name is required.";
 } elseif (!preg_match("/^[A-Za-z ]+$/", $_POST["username"])) {
     $errors["username"] = "Name should only contain letters or spaces.";
 }

 // Validate the 'email' field
 if (empty($_POST["email"])) {
     $errors["email"] = "Email is required.";
 } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
     $errors["email"] = "Invalid email format.";
 }

 // Validate the 'phone' field
 if (empty($_POST["phone"])) {
     $errors["phone"] = "Phone number is required.";
 } elseif (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
     $errors["phone"] = "Phone number should be a 10-digit number.";
 }

 // Validate the 'password' field
 if (empty($_POST["password"])) {
     $errors["password"] = "Password is required.";
 } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}$/", $_POST["password"])) {
     $errors["password"] = "Password must be at least 6 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
 }

?>