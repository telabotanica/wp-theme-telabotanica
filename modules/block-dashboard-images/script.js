var PubSub = require('pubsub-js');

var Tela = window.Tela || {};
Tela.modules = Tela.modules || {};

Tela.modules.blockDashboardImages = (function(){

	function module(selector){
		var $el = $(selector),
			$titleSuffix,
			$content,
			apiUrl,
			maxItems = 8,
			data = {
				total: '',
				items: []
			};

		function init(){
			$titleSuffix = $el.find('.title-suffix');
			$content = $el.find('.block-dashboard-content');

			// Get the URL to the API from the data-* attribute
			apiUrl = $el.data('apiUrl');

			// Subscribe to the total of images that will be retrieved by block-dashboard-map
			PubSub.subscribe('block-dashboard-map.images', onTotalImages);

			loadData();
		}

		function loadData(){

			// Call the API
			$.ajax({
				type: "GET",
				url: apiUrl,
				dataType: "xml",
				success: function(xml){
					$(xml).find('entry').slice(0, maxItems).each(function(){
						var $this = $(this);
						data.items.push({
							href: $this.find('link').attr('href'),
							image: $this.find('id').text().replace('L.', 'CRXS.')
						});
					});

					renderContent();
				}
			});
		}

		function onTotalImages(e, images) {
			// images contains the total of images for this user
			data.total = images;
			updateSuffix();
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
			module(this);
		});
	};

})();

$(document).ready(function(){
	Tela.modules.blockDashboardImages('.block-dashboard-images');
});
