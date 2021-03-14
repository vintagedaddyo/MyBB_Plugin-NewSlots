<?php 

/**
 * MyBB 1.2
 * Copyright © 2007 Jesse Labrocca
 *
 * Website: http://www.mybbcentral.com
 *
 * $Id: slots.php 2702 2007-10-07 09:48:14 Labrocca $ */

define("IN_MYBB", 1);

$templatelist = "slots, error";
require_once "./global.php";

if ($mybb->user['uid'] == 0){ 

error_no_permission();
 }


  $credit = $mybb->settings['slots_credit'];
  $money = $mybb->user['newpoints'];

if ($money <= "0" || $mybb->user['newpoints'] < $credit ) {
	add_breadcrumb("Slots Error");
	$title = "Cryptx Slot Machine";
	$error = "Sorry but you do not have enough ". $mybb->settings['newpoints_name']." to play.";
	eval("\$error = \"".$templates->get("error")."\";");
	output_page($error);
	exit();
}


  $slot1 = rand(1,5);
  $slot2 = rand(1,5);
  $slot3 = rand(1,5);

  if ($slot1 == 1 && $slot2 == 1 && $slot3 == 1) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 1 && $slot2 == 1 && $slot3 == 5) {
   $money = $money+($credit*5);
	$win = "yes";
	}
	  if ($slot1 == 2 && $slot2 == 2 && $slot3 == 5) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 3 && $slot2 == 3 && $slot3 == 5) {
   $money = $money+($credit*15);
	$win = "yes";
	}
	  if ($slot1 == 5 && $slot2 == 1 && $slot3 == 1) {
   $money = $money+($credit*5);
	$win = "yes";
	}
	  if ($slot1 == 5 && $slot2 == 2 && $slot3 == 2) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 5 && $slot2 == 3 && $slot3 == 3) {
   $money = $money+($credit*15);
	$win = "yes";
	}
  if ($slot1 == 1 && $slot2 == 5 && $slot3 == 1) {
   $money = $money+($credit*5);
	$win = "yes";
	}
	  if ($slot1 == 2 && $slot2 == 5 && $slot3 == 2) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 3 && $slot2 == 5 && $slot3 == 3) {
   $money = $money+($credit*15);
	$win = "yes";
	}
  if ($slot1 == 2 && $slot2 == 2 && $slot3 == 2) {
 	  $money = $money+($credit*25);
      $win = "yes";
	}
  if ($slot1 == 4 && $slot2 == 5 && $slot3 == 4) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 4 && $slot2 == 4 && $slot3 == 5) {
   $money = $money+($credit*10);
	$win = "yes";
	}
	  if ($slot1 == 5 && $slot2 == 4 && $slot3 == 4) {
   $money = $money+($credit*10);
	$win = "yes";
	}
  if ($slot1 == 3 && $slot2 == 3 && $slot3 == 3) {

	$odds = rand(1,3);
		if ($odds != '1') {
	   $money = $money+($credit*50);
	   $win = "yes";
		} else {
		  $slot1 = '5';
		  $slot2 = '6';
          $slot3 = '5';
		}
	}
  if ($slot1 == 4 && $slot2 == 4 && $slot3 == 4) {

	$odds = rand(1,1);
		if ($odds == '1') {
		   $money = $money + ($credit*100);
    	   $win = "yes";
		} else {
		  $slot1 = '6';
		  $slot2 = '5';
          $slot3 = '6';
		}

	}

if ($_POST['play'] == "1"){

  if ($win != "yes"){
   $marquee = "AHAHAHA, Good Try.";
   $money = $money-$credit;
   $db->query("UPDATE ".TABLE_PREFIX."users SET newpoints='".$money."' WHERE uid='".$mybb->user['uid']."'");

	} else {
   $marquee = "WINNER - WINNER - WINNER <embed src=\"{$theme['imgdir']}/slots/win.wav\" width=\"0\" height=\"0\" autostart=\"true\" repeat=\"false\">";
   $db->query("UPDATE ".TABLE_PREFIX."users SET newpoints='".$money."' WHERE uid='".$mybb->user['uid']."'");

	}
}else{
   $marquee = "Press SPIN to risk your cash.";
}
   
	add_breadcrumb("Slots");
	$title = "xTreme Slot Machine";
	eval("\$slots = \"".$templates->get("slots")."\";");
	output_page($slots);

   
?>
