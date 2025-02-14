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

 $plugins->add_hook("global_start", "slots");

// The information that shows up on the plugin manager

function slots_info()
{

global $db, $mybb, $lang;

 $lang->load("slots");

	return array(
		'name'			=> $lang->slots_name,
		'description'	=> $lang->slots_description,
		'website'		=> $lang->slots_website,
		'author'		=> $lang->slots_author,
		'authorsite'	=> $lang->slots_authorsite,
		'version'		=> $lang->slots_version,
		'compatibility'	=> $lang->slots_compatibility,
		'codename'		=> $lang->slots_codename,
	);
}

// This function runs when the plugin is activated.

function slots_activate()
{

global $db, $mybb, $cache, $templates, $lang;

 $lang->load("slots");

    $slots_group = array(
        "gid" => intval($gid),
        "name" => "Slots",
        "title" => $lang->slots_settinggroup_title,
        "description" => $lang->slots_settinggroup_description,
        "disporder" => "66",
        "isdefault" => "0"
        );

    $db->insert_query("settinggroups", $slots_group);

    $gid = $db->insert_id();

    $slots_1 = array(
        "sid" => "0",
        "name" => "slots_credit",
        "title" => $lang->slots_setting_1_title,
        "description" => $lang->slots_setting_1_description,
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
<title>{\$mybb->settings[\'bbname\']} - {\$lang->slots_page_1}</title>
{\$headerinclude}
</head>
<body>
{\$header}
<br />
<form action=\"slots.php\" method=\"post\">
<input type=\"hidden\" name=\"action\" value=\"send\" />
<table border=\"0\" cellspacing=\"{\$theme[\'borderwidth\']}\" cellpadding=\"{\$theme[\'tablespace\']}\" class=\"tborder\">
<tr>
<td class=\"thead\"><strong>{\$lang->slots_page_2}</strong></td>
</tr>
<tr>
<td class=\"trow1\" width=\"100%\"> 
<div align=\"center\">
<div style=\"background: #fff url({\$mybb->settings[\'bburl\']}/images/slots/slotback.png);width:300px; height:280px;\">
	<div style=\"position:relative; top: 200px; width: 300px;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot1}.png\" style=\"margin:7px 0;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot2}.png\" style=\"margin:7px 20px;\">
	<img src=\"{\$mybb->settings[\'bburl\']}/images/slots/slot{\$slot3}.png\" style=\"margin:7px 0;\">
	</div>
</div>
	<div style=\"font-weight: bold; width: 300px; background: #000000;\">
	     <marquee onmouseover=\"this.setAttribute(\'scrollamount\', \'3\')\" onmouseout=\"this.setAttribute(\'scrollamount\', \'6\')\" scrolldelay=\"9\" direction=\"left\">{\$marquee}</marquee>
	<span style=\"color: #B5B5B5;font-weight: bold;\">{\$lang->slots_youhave}</span> <span style=\"color: #CD411B;font-weight: bold;\">{\$money}</span> <span style=\"color: #B5B5B5;font-weight: bold;\">{\$mybb->settings[\'newpoints_main_curname\']}.</span>	
	</div>
<div style=\"background: #303030; width:300px; height:80px; border-top: 2px solid #0F0F0F; border-bottom: 2px solid #0F0F0F;color: #E8E8E8;\">
	<form method=\"post\" action=\"slots.php\">
		<div style=\"margin-top:10px;\">
			<input type=\"hidden\" name=\"play\" value=\"1\" />

			<button style=\"background: #0f0f0f url(\'{\$mybb->settings[\'bburl\']}/images/slots/spin.png\')repeat-x;color:#fff;font-size:24px;font-weight:bold;text-transform:uppercase;margin-bottom:5px;\">{\$lang->slots_spin}</button>			
<br />
{\$lang->slots_spincost} <span style=\"color: #FDCE65;font-weight: bold;\">{\$mybb->settings[\'slots_credit\']}</span> {\$mybb->settings[\'newpoints_main_curname\']}.
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
		"version"	=> "1.1",
		"dateline"	=> time()
	);

	$db->insert_query("templates", $slots_template_1);

	require "../inc/adminfunctions_templates.php";

	find_replace_templatesets("header", '#toplinks_help}</a></li>#', 'toplinks_help}</a></li> <li><a href="{$mybb->settings[\'bburl\']}/slots.php" class="slots">{\$lang->slots_link}</a></li><style>#logo ul.top_links a.slots {background: url(\'images/toplinks/slots.png\') no-repeat;}</style>');

    rebuild_settings();

}

// This function runs when the plugin is deactivated.

function slots_deactivate()
{

	global $db, $mybb, $templates, $lang;

    $lang->load("slots");

    $query = $db->query("SELECT gid FROM ".TABLE_PREFIX."settinggroups WHERE name='Slots'");

    $g = $db->fetch_array($query);

    $db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE gid='".$g['gid']."'");

    $db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE gid='".$g['gid']."'");

	$db->query("DELETE FROM ".TABLE_PREFIX."templates WHERE title = 'slots'");

	require "../inc/adminfunctions_templates.php";

	find_replace_templatesets("header", '#'.preg_quote(' <li><a href="{$mybb->settings[\'bburl\']}/slots.php" class="slots">{$lang->slots_link}</a></li><style>#logo ul.top_links a.slots {background: url(\'images/toplinks/slots.png\') no-repeat;}</style>').'#', '',0);

    rebuild_settings();
}

function slots()
{
	
	global $db, $mybb, $lang;

    $lang->load("slots");
}

?>