<?php defined('_JEXEC') or die('Restricted access'); ?>
<!--[if gt IE 5.5]>
<script type="text/javascript">
window.addEvent('domready', function() {
	for(var i=0;i<$$('select').length;i++) {
		$$('select')[i].addEvent('focus', function () {
			$('area').setStyle('width', '140px');
			this.setProperty('rel',this.getStyle('width'));
			this.setStyle('width','auto');
			this.setStyle('min-width','138px');
			$('area').setStyle('border-right', '1px solid silver');
		});
		$$('select')[i].addEvent('click', function () {
			this.setProperty('rel',this.getStyle('width'));
			this.setStyle('width','auto');
			this.setStyle('min-width','138px');
			$('area').setStyle('border-right', '1px solid silver');
			$('area').setStyle('max-width', '150px');
		});
		$$('select')[i].addEvent('blur', function () {
			this.setStyle('width',this.getProperty('rel'));
		});
	}}
)
</script>
<![endif]-->
<table width="100%">
	<tr>
		<td width="140px" valign="top">
		<div id="element-box">
			<div class="t"><div class="t"><div class="t">&nbsp;</div></div></div>
			<div class="m">
			<div id="navbar" style="margin-top:-10px;"> 
				<p class='hasTip' title='<?php echo JText::_('JoomLeague Version');?>::<?php echo JText::_('Your joomleague installation is up-to-date'); ?>'>
					<a href='#' style='text-decoration: none; color: green;'>JoomLeague - v<?php echo $this->version; ?></a></p>
			<form action="index.php?option=com_joomleague" method="post" name="adminForm1">
				<div id="area" style="overflow:hidden; width:100%; max-width: 150px;">
				<?php echo $this->lists['sportstypes']; ?>
				<?php if ($this->sports_type_id): ?>
				<?php echo $this->lists['seasons']; ?><br />
				<?php echo $this->lists['projects']; ?><br />
				<?php endif; ?>
				<?php
				// Project objects
				if ($this->project->id && $this->sports_type_id)
				{
					echo $this->lists['projectteams'];
					?><br /><?php echo $this->lists['projectrounds'];
				}
				?><br />
				</div>
				<input type="hidden" name="option" value="com_joomleague" />
				<input type="hidden" name="act" value="" id="jl_short_act" />
				<input type="hidden" name="task" value="selectws" />
				<?php echo JHTML::_('form.token')."\n"; ?>
			</form><br>
			<?php
				$n=0;
				$tabs=$this->tabs;
				$link=$this->link;
				$label=$this->label;
				$limage=$this->limage;
				$pane =& JPane::getInstance('sliders', 
											array(
												'allowAllClose' => true,
												'startOffset' => $this->active,
												'startTransition' => true, 
											true));
				echo $pane->startPane("content-pane");
				foreach ($tabs as $tab)
				{
					$title=JText::_($tab->title);
					echo $pane->startPanel($title,'jfcpanel-panel-'.$tab->name);
					?>
					<div style="float: left;">
						<table><?php
							for ($i=0;$i < count($link[$n]); $i++)
							{
								?><tr><td><b><a href="<?php echo $link[$n][$i]; ?>" title="<?php echo JText::_($label[$n][$i]); ?>">
										<?php echo $limage[$n][$i].' '.JText::_($label[$n][$i]); ?>
								</a></b></td></tr><?php
							}
							?></table>
					</div>
					<?php
					echo $pane->endPanel();
					$n++;
				}
				echo $pane->endPane();
				$extensions=JoomleagueHelper::getExtensions(1);
				foreach ($extensions as $e => $extension) {
					$JLGPATH_EXTENSION= JPATH_COMPONENT_SITE.DS.'extensions'.DS.$extension;
					$menufile = $JLGPATH_EXTENSION . DS . 'admin' .DS .'views'.DS.'adminmenu'.DS.'tmpl'.DS.'default_'.$extension.'.php';
					if(JFile::exists($menufile )) {
						echo $this->loadTemplate($extension);
					} else {
					}
				}
				?>
			<div style="text-align: center;"><br />
			<?php
			echo JHTML::_('image','administrator/components/com_joomleague/assets/images/jl.png',JText::_('JoomLeague'),array("title" => JText::_('JoomLeague')));
			?></div>
			</div>
			</div>
			<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
		</td>
		<td valign="top">
