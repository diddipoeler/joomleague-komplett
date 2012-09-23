<?php
/**
 * @package		JoomLeague
 * @copyright	Copyright (C) 2005-2012 JoomLeague Developer. All rights reserved.
 *
 * Modelled after the work done by RocketWerx and Team JoomlaPack. Thank you JoomlaPack Developer Team!
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// This function calls the installation routine for Joomla
function com_install()
{
	return component_install();
}

function component_install()
{
	return true;
}
?>
<hr>
<h1>JoomLeague Installation</h1>
<?php
include_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'updates'.DS.'jl_install.php');
?>
<h2>Welcome to JoomLeague!</h2>
<p>Undoubtedly, you are about to embark on many joyous hours of managing your Sports League.</p>
<p>To get started, navigate to Components then click on JoomLeague or just click the JoomLeague button on your Joomla control panel.</p>
<p>Before doing anything more, please check this link for the <a href="http://wiki.joomleague.net/doku.php?id=faq:howto">First steps</a> or read the Wiki-Contens, available on-line on our official site's <a href="http://wiki.joomleague.net/" target="_blank">JoomLeague Wiki</a>.</p>
<hr>
<p>Should you have any questions, comments or need some help, do not hesitate to post on our <a href="http://forum.joomleague.net" target="_blank">support forum</a>. Please also visit our Website if you want to help us to make JoomLeague better than it is now !</p>
<p>But... Pleeeeaaaaase...</p>
<p>Search for your question first before you ASK!!!<br />Many problems have been answered yet and we are sure you will find a solution for them just by searching in our support forum.</p>
<p>If not in your case??? Please ask us... <img src="../images/smilies/wink.gif" /></p>
<p>Remember: You can always get on-line help for the JoomLeague page you are currently viewing by clicking on the help icon in the top right corner of all backend configuration pages of the JoomLeague component.</p>
<img src="../media/com_joomleague/jl_images/joomleague_logo.png" alt="JoomLeague" title="JoomLeague" />
<hr />