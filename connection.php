<?php

try{
	return new PDO("mysql:host=localhost;dbname=demoarticles", "root", "");
} catch (PDOExption $e ){
	echo $e->message();
}

