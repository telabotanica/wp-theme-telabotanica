<?php

/*
 * BP Profile Search - filters template 'bps-filters'
 *
 * See http://dontdream.it/bp-profile-search/form-templates/ if you wish to modify this template or develop a new one.
 *
 */

	$F = bps_escaped_filters_data ();
	$filters = array();

	foreach ($F->fields as $f)
	{
		switch ($f->display)
		{
		case 'range':
			if ($f->min === '' && $f->max === '')  break;
			$filter = "<strong>$f->label:</strong>";
			if ($f->min !== '')
				$filter .= " <strong>". __('min', 'bp-profile-search'). "</strong> $f->min";
			if ($f->max !== '')
				$filter .= " <strong>". __('max', 'bp-profile-search'). "</strong> $f->max";
			$filters[] = $filter;
			break;

		case 'hidden':
			break;

		case 'textbox':
		case 'number':
		case 'textarea':
		case 'url':
			if ($f->value === '')  break;
		$filters[] = "<strong>$f->label:</strong> $f->value";
			break;

		case 'selectbox':
		case 'radio':
		case 'multiselectbox':
		case 'checkbox':
			$values = array ();
			foreach ($f->options as $key => $label)
				if (in_array ($key, $f->values))  $values[] = $label;
			$values = implode (', ', $values);
			if ($values === '')  break;
			$filters[] = "<strong>$f->label:</strong> $values";
			break;

		default:
			$filters[] = "<p>BP Profile Search: don't know how to display the <em>$f->display</em> filter type.</p>\n";
			break;
		}
	}

	if ($filters)
	{
		echo "<p class='bps_filters component-text'>\n";
		echo implode(' | ', $filters);
		echo "<br>";
		echo "<a href='$F->action'>". __('Réinitialiser les filtres', 'telabotanica'). "</a><br>\n";
		echo "</p>\n";
	}

// BP Profile Search - end of template
