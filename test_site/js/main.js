(function() {
	'use strict';
	$(document).ready(function() {

		var libphp = 'lib/lib.php';

		// This is where we include any files found in the html/handlebars folder
		var hb_directory = 'html/handlebars';
		var hb_files     = [];

		$.ajax({
			url: libphp,
			data: {
				functionname: 'gethandlebars',
				dir: hb_directory
			},
			type: 'post',
			success: function(output) {
				hb_files = JSON.parse(output);
			}
		}).then(function() {
			var source   = '{{#each handlebar}}\n<script id="hb_{{template_name}}" type="text/x-handlebars-template">{{{html}}}</script>{{/each}}';
			var template = Handlebars.compile(source);
			var $html    = template({handlebar : hb_files});
			$('div.handlebar-templates').html($html);
		}).then(function() {
			// Wait until previous $.ajax call is done so that we know any handlebars we
			// would need in a js file is already loaded for use

			// This is where we include any files found in the js folder
			var js_directory = 'js';
			var js_files     = [];

			$.ajax({
				url: libphp,
				data: {
					functionname: 'getjs',
					dir: js_directory
				},
				type: 'post',
				success: function(output) {
					js_files = JSON.parse(output);
				}
			}).then(function() {
				var source   = '{{#each jsinfo}}\n<script id="js_{{js_id}}" src="' + js_directory + '/{{name}}"></script>{{/each}}';
				var template = Handlebars.compile(source);
				var $html    = template({jsinfo : js_files});
				$('div.js-includes').html($html);
			});
		});
	});
})(window)
