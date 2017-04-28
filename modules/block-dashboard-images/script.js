'use strict';

var Tela = window.Tela || {};

Tela.blockDashboardImages = (function(){

	function blockDashboardImages(selector){
		var $el = $(selector),
			$titleSuffix,
			$content,
			apiUrl,
			data = {
				total: '',
				items: []
			};

		function init(){
			$titleSuffix = $el.find('.title-suffix');
			$content = $el.find('.block-dashboard-content');

			// Get the URL to the API from the data-* attribute
			apiUrl = $el.data('apiUrl');

			loadData();
		}

		function loadData(){

			// Call the API
			$.ajax({
				type: "GET",
				url: apiUrl,
				dataType: "xml",
				success: function(xml){
					$(xml).find('entry').each(function(){
						var $this = $(this);
						data.items.push({
							href: $this.find('link').attr('href'),
							image: $this.find('id').text().replace('L.', 'CRXS.')
						});
					});

					// TODO: use the real number of images
					data.total = data.items.length;

					updateSuffix();
					renderContent();
				}
			});
		}

		function updateSuffix(){
			$titleSuffix.text(data.total);
		}

		function renderContent(){
			var content = '<div class="block-dashboard-content-images">';
			$.each(data.items, function(){
				content += '<a href="' + this.href + '"><img src="' + this.image + '" alt="" /></a>';
			})
			content += '</div>';
			$content.prepend(content);
		}


		init();

		return $el;
	}

	return function(selector){
		return $(selector).each(function(){
			blockDashboardImages(this);
		});
	};

})();

$(document).ready(function(){
	Tela.blockDashboardImages('.block-dashboard-images');
});
