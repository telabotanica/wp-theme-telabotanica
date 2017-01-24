<?php function telabotanica_component_contact($data) {
  $contact = get_sub_field('contact');

  if ($contact !== false) {
    $contact = (object) $contact[0];
    if (!isset($data->image)) $data->image = $contact->image['sizes']['thumbnail'];
    if (!isset($data->name)) $data->name = $contact->name;
    if (!isset($data->description)) $data->description = $contact->description;
    if (!isset($data->phone)) $data->phone = $contact->phone;
    if (!isset($data->email)) $data->email = $contact->email;
    if (!isset($data->website)) $data->website = $contact->website;
    if (!isset($data->link)) $data->link = $contact->link;
  }

  echo '<div class="component component-contact">';

  echo '<div class="component-contact-image" style="background-image: url(' . (! empty($data->image) ? $data->image : '') . ')"></div>';

  echo '<div class="component-contact-text">';
    if (! empty($data->link)) :
		echo '<a href="' . $data->link . '">';
	endif;
    echo '<div class="component-contact-name">' . $data->name . '</div>';
    if (! empty($data->link)) :
		echo '</a>';
	endif;
    echo '<div class="component-contact-description">' . (! empty($data->description) ? $data->description : '') . '</div>';

    if (! empty($data->phone) || ! empty($data->email) || ! empty($data->website)) :

      echo '<ul class="component-contact-details">';
        if (! empty($data->phone)) echo '<li><a href="tel:' . str_replace(' ', '', $data->phone) . '" class="component-contact-phone">' . $data->phone . '</a></li>';
        if (! empty($data->email)) echo '<li><a href="mailto:' . $data->email . '" class="component-contact-email">' . $data->email . '</a></li>';
        if (! empty($data->website)) echo '<li><a href="' . $data->website . '" target="_blank" rel="noopener noreferrer" class="component-contact-website">' . $data->website . '</a></li>';
      echo '</ul>';

    endif;

    echo '</div>';
  echo '</div>';
}
