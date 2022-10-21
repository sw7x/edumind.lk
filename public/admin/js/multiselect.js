/*This is from http://www.1stwebdesigns.com/blog/development/multiple-select-with-checkboxes-and-jquery*/

jQuery.fn.multiselect = function() {
	let checkboxContainers  =  $(this).find('.custom-checkbox-container')
	let allCheckboxes       =  checkboxContainers.find("input:checkbox");
	let selectAllCheckBox   =  checkboxContainers.filter('.select-all').find("input:checkbox");
	let normalCheckboxes    =  checkboxContainers.not('.select-all').find("input:checkbox");

	$(this).each(function() {
		let checkboxes = $(this).find("input:checkbox");

		checkboxes.each(function() {
			let checkbox = $(this);

			// Highlight pre-selected checkboxes
			if (checkbox.prop("checked")){
				checkbox.parent().addClass("multiselect-on");
			}

			// Highlight checkboxes that the user selects
			checkbox.change(function() {
				let state = $(this).prop('checked');

				if (checkbox.prop("checked")) {
					checkbox.parent().addClass("multiselect-on");
				}
				else {
					checkbox.parent().removeClass("multiselect-on");
				}

				if($(this).closest('label').hasClass('select-all')){
					normalCheckboxes.each(function(index, element) {
						if (state === true) {
							$(this).prop('checked', true);
							$(this).closest('label').addClass('multiselect-on');
						} else {
							$(this).prop('checked', false);
							$(this).closest('label').removeClass('multiselect-on');
						}
					});
				}else{
					let checkedNormalCheckboxes = normalCheckboxes.filter(':checked').length;
					let isAllChecked            = (checkedNormalCheckboxes == normalCheckboxes.length);

					selectAllCheckBox.prop("checked", isAllChecked);
					if(isAllChecked){
						selectAllCheckBox.closest('label').addClass('multiselect-on');
					}else{
						selectAllCheckBox.closest('label').removeClass('multiselect-on');
					}

				}
			});
		});
	});
};









