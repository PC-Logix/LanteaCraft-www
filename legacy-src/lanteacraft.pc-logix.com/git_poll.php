<?php
# Jockey script to pull down git changes from repo
# given service-hooks from github. This script
# isn't updated by itself, to prevent explosions;
# you'll have to do a custom git pull & copy.

if (ini_get("register_globals") == 1)
	die("Herp derp, the server administrator doesn't understand why register_globals is bad.");

$rangeValid = array("192.30.252.0/22");
$usrPath = "/home/sgcraft";
$gitPath = $usrPath . "/site_git/LanteaCraft-www";
$srcPath = $gitPath . "/src/lanteacraft.pc-logix.com/metrics";
$dstPath = $usrPath . "/sgcraft.pc-logix.com";
$flagUpdate = $dstPath . "/.update-running";
$gitCmd = "git pull";
$copyCmd = "cp -r " . $srcPath . " " . $dstPath . "";
$touchCmd = "touch ";
$deleteCmd = "rm ";

function cidr_match($target, $crange) {
	list($subnet, $mask) = explode('/', $crange);
    return ((ip2long($target) & ~((1 << (32 - $mask)) - 1) ) == ip2long($subnet));
}

$hostOf = $_SERVER["REMOTE_ADDR"];
$hostValid = false;
foreach ($rangeValid as $key => $range) {
	if (cidr_match($hostOf, $range)) {
		$hostValid = true;
		break;
	}
}

if (!$hostValid)
	die("Address " . $hostOf . " not a legal address!");

$result = shell_exec($touchCmd . $flagUpdate);
$result .= shell_exec("cd " . $gitPath . " && " . $gitCmd);
$result .= shell_exec($copyCmd);
$result .= shell_exec($deleteCmd . $flagUpdate);
die("Success!");