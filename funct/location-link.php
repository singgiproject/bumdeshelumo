<?php 

// CHECK LOCATION LINK
if( isset($_POST["product"]) ){
	header("Location:http://bumdeshelumo.online#product");
	// header("Location:http://localhost/bumdes#product");
}

if( isset($_POST["sejarah-desa"]) ){
	header("Location:http://bumdeshelumo.online#sejarah-desa");
	// header("Location:http://localhost/bumdes#sejarah-desa");
}

if( isset($_POST["visi-misi"]) ){
	header("Location:http://bumdeshelumo.online#visi-misi");
	// header("Location:http://localhost/bumdes#visi-misi");
}

if( isset($_POST["struktur-bumdes"]) ){
	header("Location:http://bumdeshelumo.online#struktur-bumdes");
	// header("Location:http://localhost/bumdes#struktur-bumdes");
}

if( isset($_POST["struktur-kades"]) ){
	header("Location:http://bumdeshelumo.online#struktur-kades");
	// header("Location:http://localhost/bumdes#struktur-kades");
}

if( isset($_POST["faq"]) ){
	header("Location:http://bumdeshelumo.online#faq");
	// header("Location:http://localhost/bumdes#faq");
}

if( isset($_POST["tutorial"]) ){
	header("Location:http://bumdeshelumo.online#tutorial");
	// header("Location:http://localhost/bumdes#tutorial");
}

if( isset($_POST["logout"]) ){
	header("Location:http://bumdeshelumo.online/auth/logout");
	// header("Location:http://localhost/bumdes/auth/logout");
}

 ?>