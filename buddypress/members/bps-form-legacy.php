<?php

/*
 * BP Profile Search - form template 'bps-form-legacy'
 *
 * See http://dontdream.it/bp-profile-search/form-templates/ if you wish to modify this template or develop a new one.
 *
 */

	$F = bps_escaped_form_data ();

	$toggle_id = 'bps_toggle'. $F->id;
	$form_id = 'bps_'. $F->location. $F->id;

	if ($F->location != 'directory')
	{
		echo "<div id='buddypress'>";
	}
	else
	{
?>
	<div class="item-list-tabs bps_header">
		<ul>
			<li class="toc-item"><?php echo $F->header; ?></li>
<?php
			if ($F->toggle)
			{
?>
				<li class="last">
				  <input id="<?php echo $toggle_id; ?>" type="submit" value="<?php echo $F->toggle_text; ?>">
				</li>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var departement = $('#field_592').parent();
						var pays = $('#field_3');

						$('#<?php echo $form_id; ?>').hide();
						if(pays.val() !== "France") departement.hide();

						$('#<?php echo $toggle_id; ?>').click(function(){
							$('#<?php echo $form_id; ?>').toggle('slow');
						});

						pays.change(function() {
							($(this).val() === "France") ? departement.show() : departement.hide();
						});
					});
				</script>

<?php
			}
?>
		</ul>
	</div>
<?php
	}

	echo "<form action='$F->action' method='$F->method' id='$form_id' class='standard-form'>\n";

	$j = 0;
	foreach ($F->fields as $f)
	{
		if ($f->display == 'hidden')
		{
			echo "<input type='hidden' name='$f->code' value='$f->value'>\n";
			continue;
		}

		$name = sanitize_title ($f->name);
		$alt = ($j++ % 2)? 'alt': '';
		$class = "editfield $f->code field_$name $alt";
		$label_unslashed = wp_unslash($f->label);

		echo "<div class='$class'>\n";

		switch ($f->display)
		{
		case 'range':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<input style='width: 10%; display: inline;' type='text' name='{$f->code}_min' id='$f->code' value='$f->min'>";
			echo '&nbsp;-&nbsp;';
			echo "<input style='width: 10%; display: inline;' type='text' name='{$f->code}_max' value='$f->max'>\n";
			break;

		case 'textbox':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<input type='text' name='$f->code' id='$f->code' value='$f->value'>\n";
			break;

		case 'number':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<input type='number' name='$f->code' id='$f->code' value='$f->value'>\n";
			break;

		case 'url':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<input type='text' inputmode='url' name='$f->code' id='$f->code' value='$f->value'>\n";
			break;

		case 'textarea':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<textarea rows='5' cols='40' name='$f->code' id='$f->code'>$f->value</textarea>\n";
			break;

		case 'selectbox':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<select name='$f->code' id='$f->code'>\n";

			$no_selection = apply_filters ('bps_field_selectbox_no_selection', '', $f);
			if (is_string ($no_selection))
				echo "<option  value=''>$no_selection</option>\n";

			foreach ($f->options as $key => $label)
			{
				$selected = in_array ($key, $f->values)? "selected='selected'": "";
				echo "<option $selected value='$key'>" . wp_unslash($label) . "</option>\n";
			}
			echo "</select>\n";
			break;

		case 'multiselectbox':
			echo "<label for='$f->code'>" . $label_unslashed . "</label>\n";
			echo "<select name='{$f->code}[]' id='$f->code' multiple='multiple'>\n";

			foreach ($f->options as $key => $label)
			{
				$selected = in_array ($key, $f->values)? "selected='selected'": "";
				echo "<option $selected value='$key'>" . wp_unslash($label) . "</option>\n";
			}
			echo "</select>\n";
			break;

		case 'radio':
			echo "<div class='radio'>\n";
			echo "<span class='label'>" . $label_unslashed . "</span>\n";
			
			foreach ($f->options as $key => $label)
			{
				$checked = in_array ($key, $f->values)? "checked='checked'": "";
				echo "<label><input $checked type='radio' name='$f->code' value='$key'>" . wp_unslash($label) . "</label>\n";
			}
			echo "</div>\n";
			break;

		case 'checkbox':
			echo "<div class='checkbox'>\n";
			echo "<span class='label'>" . $label_unslashed . "</span>\n";

			foreach ($f->options as $key => $label)
			{
				$checked = in_array ($key, $f->values)? "checked='checked'": "";
				echo "<label><input $checked type='checkbox' name='{$f->code}[]' value='$key'>" . wp_unslash($label) . "</label>\n";
			}
			echo "</div>\n";
			break;

		default:
			echo "<p>BP Profile Search: don't know how to display the <em>$f->display</em> field type.</p>\n";
			break;
		}

		if (!empty ($f->description) && $f->description != '-')
			echo "<p class='description'>" . wp_unslash($f->description) . "</p>\n";

		echo "</div>\n";
	}

	echo "<div class='submit'>\n";
	echo "<input class='button' type='submit' value='". __('Search', 'buddypress'). "'>\n";
	echo "</div>\n";
	echo "</form>\n";

	if ($F->location != 'directory')  echo "</div>\n";

// BP Profile Search - end of template
