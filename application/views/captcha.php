<?php
		session_start();
		$str = "abcdefhjk2345678mnpqrstuvwxyz2345678ABCDEFHJKLMN2345678PQRSTUVWXYZ2345678";
		$random_word= str_shuffle($str);
		$random_word= substr($random_word,0,5);		
		$_SESSION["codigo"]=$random_word;
?>