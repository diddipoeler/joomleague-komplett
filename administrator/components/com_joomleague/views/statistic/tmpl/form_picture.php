<?php defined('_JEXEC') or die('Restricted access');
?>

		<fieldset class="adminform">
			<legend><?php echo JText::_( 'JL_ADMIN_STAT_PIC' );?>
			</legend>
			<table class="admintable">
				<!-- start image import -->
			    <tr>
			      <td width="250" align="right" class="key">
			        <label for="image">
			          <span class="hasTip" title='<?php echo JText::_( 'JL_ADMIN_STAT_ICON' ); ?>::<?php echo JText::_( 'JL_ADMIN_STAT_ICON' ); ?>'>
			            <?php echo JText::_( 'JL_ADMIN_STAT_ICON' ).':'; ?>
			          </span>
			        </label>
			      </td>
			      <td>
						<table>
							<tr>
								<td><?php echo $this->imageselect; ?></td>
								<img class="imagepreview" src="../media/com_joomleague/jl_images/spinner.gif" name="picture_preview" id="picture_preview" border="2" alt="<?php echo JText::_('JL_GLOBAL_PREVIEW').':'; ?>" />
							</tr>
						</table>					
			      </td>
			    </tr>
			    <!-- end image import -->
			</table>
		</fieldset>