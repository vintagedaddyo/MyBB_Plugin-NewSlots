<?php
/*
Plugin Slots
(c) 2007 by Jesse Labrocca
Website: http://www.mybbcentral.com
*/

// Make sure we can't access this file directly from the browser.
if(!defined('IN_MYBB'))
{
	die('This file cannot be accessed directly.');
}

//PLUGIN HOOKS
// $plugins->add_hook("postbit", "slots");

// The information that shows up on the plugin manager
function slots_info()
{

	return array(
		'name'			=> 'Slots',
		'description'	=> 'Adds a fun slot machine to your site using NewPoints.',
		'website'		=> 'http://www.talkvideogames.com',
		'author'		=> 'Jesse Labrocca & edits by Vintagedaddyo',
		'authorsite'	=> 'http://www.mybbcentral.com',
		'version'		=> '1.1',
		'compatibility'	=> '18*',
		'codename'		=> ''
	);
}

// This function runs when the plugin is activated.
function slots_activate()
{

global $db, $mybb, $cache, $templates;

    $slots_group = array(
        "gid" => intval($gid),
        "name" => "Slots",
        "title" => "Slots",
        "description" => "Controls the Slots settings.",
        "disporder" => "66",
        "isdefault" => "0"
        );

    $db->insert_query("settinggroups", $slots_group);

    $gid = $db->insert_id();

    $slots_1 = array(
        "sid" => "0",
        "name" => "slots_credit",
        "title" => "Credit Per Spin",
        "description" => "This determines how many myps it takes per spin.",
        "optionscode" => "text",
        "value" => "10",
        "disporder" => "1",
        "gid" => intval($gid)
        );

    $db->insert_query("settings", $slots_1);

	$slots_template_1 = array(
		"tid"		=> "0",
		"title"		=> 'slots',
		"template"	=> "<html>
<head>
<meta http-equiv=\"Pragma\" content=\"no-cache\" />
<meta http-equiv=\"expires\" content=\"0\" />
<title>{\$mybb->settings[\'bbname\']} - Slots</title>
{\$headerinclude}
</head>
<body>
{\$header}
<br />
<form action=\"slots.php\" method=\"post\">
<input type=\"hidden\" name=\"action\" value=\"send\" />
<table border=\"0\" cellspacing=\"{\$theme[\'borderwidth\']}\" cellpadding=\"{\$theme[\'tablespace\']}\" class=\"tborder\">
<tr>
<td class=\"thead\"><strong>Slots</strong></td>
</tr>
<tr>
<td class=\"trow1\" width=\"100%\"> 
<div align=\"center\">
<div style=\"background: #fff url({\$mybb->settings[\'bburl\']}/images/slots/slotback.png);width:300px; height:280px;\">
	<div style=\"position:relative; top: 200px; width: 300px;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot1}.png\" style=\"margin:5px 0;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot2}.png\" style=\"margin:5px 20px;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot3}.png\" style=\"margin:5px 0;\">
	</div>
</div>
	<div style=\"font-weight: bold; width: 300px;\">
	     <marquee>{\$marquee}</marquee>
	You have {\$money} {\$mybb->settings[\'newpoints_main_curname\']}.	
	</div>
<div style=\"background: #999999; width:280px; height:80px; border: 2px solid #666666;\">
	<form method=\"post\" action=\"slots.php\">
		<div style=\"margin-top:10px;\">
			<input type=\"hidden\" name=\"play\" value=\"1\" />
			<input type=\"image\" src=\"{\$mybb->settings[\'bburl\']}/images/slots/spin.gif\" value=\"submit\" />
<br />
Each spin costs {\$mybb->settings[\'slots_credit\']} {\$mybb->settings[\'newpoints_main_curname\']}.
		</div>
	</form>
</div>
</td>
</tr>
<tr>
</table>
</form>
{\$footer}
</body>
</html>",
		"sid"		=> "-1",
		"version"	=> "1.0",
		"dateline"	=> time()
	);

	$db->insert_query("templates", $slots_template_1);

	require "../inc/adminfunctions_templates.php";

	find_replace_templatesets("header", '#toplinks_help}</a></li>#', 'toplinks_help}</a></li> <li><a href="{$mybb->settings[\'bburl\']}/slots.php" class="slots">Slots</a></li><style>#logo ul.top_links a.slots {background: url(\'images/toplinks/slots.png\') no-repeat;}</style>');

    rebuild_settings();

}

// This function runs when the plugin is deactivated.
function slots_deactivate()
{
	global $db, $mybb, $templates;

    $query = $db->query("SELECT gid FROM ".TABLE_PREFIX."settinggroups WHERE name='Slots'");
    $g = $db->fetch_array($query);

    $db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE gid='".$g['gid']."'");
    $db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE gid='".$g['gid']."'");

	$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE title = 'slots'");

	require "../inc/adminfunctions_templates.php";

	find_replace_templatesets("header", '#'.preg_quote(' <li><a href="{$mybb->settings[\'bburl\']}/slots.php" class="slots">Slots</a></li><style>#logo ul.top_links a.slots {background: url(\'images/toplinks/slots.png\') no-repeat;}</style>').'#', '',0);

    rebuild_settings();
}

function slots()
{
	global $db, $mybb;

}

?>