(function($) {
	"use strict";
	var language = null;
	var currency = null;
	var data = null;
	$(document).on("click","#btn_add_country",function(e) {
		language = $('input[name="language"]').val();
		currency = $('input[name="currency"]').val();
		if(language == '' || currency == ''){
			alert('Please enter data');
			e.preventDefault();
		}else{
			$('.tb_no_item').remove();
			$('#the-list').append('<tr><td class="language">'+language+'</td><td class="currency">'+currency+'</td><td><a title="Click to edit this item" href="javascript:void(0)" class="tb_lang">Edit</a>|<a class="tb_lang_remove" href="javascript:void(0)">Remove</a></td></tr>');
			savedata();
		}
	})
	$(document).on("click",".tb_lang_remove",function(e) {
		removeItem(this);
		savedata(); 
	})
	$(document).on("click",".tb_lang",function(e) {
		var parent = $(this).closest('tr');
		var index = parent.index();
		var language = $('.language',parent).text();
		var currency = $('.currency',parent).text();
		$('.language_edit').val(language);
		$('.currency_edit').val(currency);
		$( "#edit_dialog" ).dialog({
			minWidth: 500,
			buttons: [
				{
				  text: "Save & Close",
				  click: function() {
					$('.language',parent).text($('.language_edit').val());
					$('.currency',parent).text($('.currency_edit').val());
					savedata();
					$( this ).dialog( "close" );
				  }
				},
				{
				  text: "Cancel",
				  click: function() {
					$( this ).dialog( "close" );
				  }
				}
			]
		});
	})
	function savedata(){
		data = new Object();
		$('#the-list tr').each(function(e){
			data[e] = new Object();
			data[e]['language'] = $('.language',this).text();
			data[e]['currency'] = $('.currency',this).text();
		})
		data = $.base64.encode(JSON.stringify(data));
		$('#tb_woo_countries').val(data);
		$('input[name="language"],input[name="currency"]').val('');
	}
	function removeItem(obj){
		$(obj).closest('tr').remove();
	}
})(jQuery);