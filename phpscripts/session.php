<?
session_start();
if ($_GET['logout']=='1') {
	unset($_SESSION['authorizedUser']);
	unset($_SESSION['result']);
} 
?>