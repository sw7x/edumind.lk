$.validator.addMethod('filesize', function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0} MB');



$.validator.addMethod("minutes", function(value, element) {
	return this.optional(element) || /^(0?[0-9]|[1-5][0-9])$/.test(value);
}, "Please enter a valid number between 0 and 59.");



jQuery.validator.addMethod("exactlength", function(value, element, param) {
    return this.optional(element) || value.length == param;
}, $.validator.format("Please enter exactly {0} characters."));


$.validator.addMethod("lettersAndNumbersOnly", function(value, element) {
	return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}, "Please enter letters and numbers only");


$.validator.addMethod('phone', function(value, element) {
    // Allow only digits, spaces, parentheses, hyphens, and plus sign
    return this.optional(element) || /^[\d\s()+-]+$/.test(value);
}, 'Please enter a valid phone number.');
