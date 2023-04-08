$.validator.addMethod('filesize', function(value, element, param) {
  return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0} MB');



$.validator.addMethod("minutes", function(value, element) {
	return this.optional(element) || /^(0?[0-9]|[1-5][0-9])$/.test(value);
}, "Please enter a valid number between 0 and 59.");