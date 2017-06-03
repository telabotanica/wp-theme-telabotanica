<?php

return [
  'Confirmation' => [
        'type'  => 'confirm',
        'title' => 'Well done!',
        'text'  => 'You successfully read this important alert message.',
    ],
  'Info' => [
        'type'  => 'info',
        'title' => 'Heads up!',
        'text'  => "This alert needs your attention, but it's not super important. This alert needs your attention, but it's not super important.",
    ],
  'Avertissement' => [
        'type'  => 'warning',
        'title' => 'Warning!',
        'text'  => "Better check yourself, you're not looking too good.",
    ],
  'Alerte' => [
        'type'  => 'alert',
        'title' => 'Oh snap!',
        'text'  => 'Change a few things up and try submitting again.',
    ],
    'Confirmation (fermable)' => [
        'type'     => 'confirm',
        'title'    => 'Well done!',
        'text'     => 'You successfully read this important alert message. You successfully read this important alert message.',
        'closable' => true,
    ],
];
