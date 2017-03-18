<?php
return [
	'Standard' => [
		'title' => [
			'title' => "Mon flux d'activité",
			'level' => 2
		],
		'items' => [
			[
				'type' => 'feed-date',
				'text' => 'Hier'
			],
			[
				'type' => 'feed-item',
				'href' => '#',
				'image' => 'https://api.tela-botanica.org/img:001125636CRXS.jpg',
				'title' => 'Allium vineale ??',
				'text' => 'Nouvelle observation ajoutée au Carnet en Ligne',
				'meta' => [
					'place' => 'Saturargues (34)'
				]
			],
			[
				'type' => 'feed-item',
				'href' => '#',
				'images' => [
					'https://api.tela-botanica.org/img:001129797CRXS.jpg',
					'https://api.tela-botanica.org/img:001129789CRXS.jpg',
					'https://api.tela-botanica.org/img:001129777CRXS.jpg',
					'https://api.tela-botanica.org/img:001129768CRXS.jpg',
					'https://api.tela-botanica.org/img:001129757CRXS.jpg',
					'https://api.tela-botanica.org/img:001129710CRXS.jpg',
					'https://api.tela-botanica.org/img:001129705CRXS.jpg',
					'https://api.tela-botanica.org/img:001129701CRXS.jpg'
				],
				'title' => '11 photos ajoutées',
				'text' => 'Au Carnet en Ligne',
				'meta' => [
					'text' => 'Fontainebleau-01.jpg, Fontainebleau-02.jpg, Fontaine....'
				]
			],
			[
				'type' => 'feed-item',
				'article' => true,
				'href' => '#',
				'image' => 'https://api.tela-botanica.org/img:001129701CRXS.jpg',
				'title' => 'Chloris',
				'text' => "Quand l'art et la botanique se mêlent en un ouvrage, un magnifique volume...",
				'meta' => [
					'categories' => 'En kiosque'
				]
			],
			[
				'type' => 'feed-date',
				'text' => 'Il y a deux jours'
			],
			[
				'type' => 'feed-item',
				'href' => '#',
				'image' => 'https://api.tela-botanica.org/img:001125593CRXS.jpg',
				'title' => 'Acer campestre ?',
				'text' => 'Nouvelle observation ajoutée au Carnet en Ligne',
				'meta' => [
					'place' => 'Durtol (63)'
				]
			],
			[
				'type' => 'feed-item',
				'text' => 'Vous avez rejoint le projet <a href="#">Sauvages de ma rue</a> !'
			]
		]
	]
];
