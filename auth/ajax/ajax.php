<?php
ob_start();
$action = $_GET['action'];
include 'actions.php';
$act = new Action();

if($action == 'login'){
	$login = $act->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $act->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $act->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $act->delete_user();
	if($save)
		echo $save;
}
/*
if($action == 'signup'){
	$save =
    $act->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save =
    $act->save_settings();
	if($save)
		echo $save;
}
if($action == "save_venue"){
	$save =
    $act->save_venue();
	if($save)
		echo $save;
}
if($action == "save_book"){
	$save =
    $act->save_book();
	if($save)
		echo $save;
}
if($action == "delete_book"){
	$save =
    $act->delete_book();
	if($save)
		echo $save;
}

if($action == "save_register"){
	$save =
    $act->save_register();
	if($save)
		echo $save;
}
if($action == "delete_register"){
	$save =
    $act->delete_register();
	if($save)
		echo $save;
}
if($action == "delete_venue"){
	$save =
    $act->delete_venue();
	if($save)
		echo $save;
}
if($action == "update_order"){
	$save =
    $act->update_order();
	if($save)
		echo $save;
}
if($action == "delete_order"){
	$save =
    $act->delete_order();
	if($save)
		echo $save;
}
if($action == "save_event"){
	$save =
    $act->save_event();
	if($save)
		echo $save;
}
if($action == "delete_event"){
	$save =
    $act->delete_event();
	if($save)
		echo $save;
}
/*if($action == "save_artist"){
	$save =
    $act->save_artist();
	if($save)
		echo $save;
}
if($action == "delete_artist"){
	$save =
    $act->delete_artist();
	if($save)
		echo $save;
}
if($action == "get_audience_report"){
	$get =
    $act->get_audience_report();
	if($get)
		echo $get;
}
if($action == "get_venue_report"){
	$get =
    $act->get_venue_report();
	if($get)
		echo $get;
}
if($action == "save_art_fs"){
	$save =
    $act->save_art_fs();
	if($save)
		echo $save;
}
if($action == "delete_art_fs"){
	$save =
    $act->delete_art_fs();
	if($save)
		echo $save;
}
/*if($action == "get_pdetails"){
	$get =
    $act->get_pdetails();
	if($get)
		echo $get;
}*/