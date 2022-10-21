
$(document).ready(function(){

    $('.flash-msg .close').click(function(event){

        event.preventDefault();
        event.stopPropagation();
        $(this).parent().fadeOut(700, function(){ $(this).remove();});
    });





    //$('input.cb-value').prop("checked", true);
    $('.cb-value').click(function() {
        var mainParent = $(this).parent('.toggle-btn');

        if($(mainParent).find('input.cb-value').is(':checked')) {
            $(mainParent).addClass('active');
            $(this).attr("checked", "checked");
            //alert('ss')
        } else {
            $(mainParent).removeClass('active');
            $(this).removeAttr('checked');
        }
    });


    // Show/Hide password field
    $('.pw-toggle').click(function(event){
        let icon          = $(this).children('i');
        let passwordInput = $(this).parent().find('input.password_field');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.prop('type', 'text');
            icon.addClass("fa-eye-slash");
        } else {
            passwordInput.prop('type', 'password');
            icon.removeClass("fa-eye-slash");
        }
        //icon.addClass('aa');
        //passwordInput.addClass('bb');
    });


    $('form.logout-form a').click(function(event){
        //$(this).parent().addClass('aahidden');
        $(this).parent().submit();
        //onclick="document.getElementById('logout-form').submit();"
        event.preventDefault();
    });




    $(".btn-add-new-section").click(function(e) {
        e.preventDefault();
        var order = $(".accordion-sec-item").length + 1,
            startingId = parseInt($(".starting-id").text());
        createNewSecItem(order);
    });

    function createNewSecItem(order) {
        var newItem = `            
            <div class="accordion-sec-item">
                <div class="flex justify-between">
                    <label class="mb-0 text-base">Section ${order} Title</label>
                    <a href="#" class="delete-section text-lg text-blue-500 ">
                        <ion-icon name="delete-item" class="font-semibold icon-feather-x-circle"></ion-icon>
                    </a>
                </div>
                
                    
                <div class="form-group">                                                                                
                    <input class="shadow-none with-border bg-gray-100 h-12 mt-1 px-3 rounded-md w-full" type="text" />
                </div>
            </div>`;
        $(".accordion-sec-item-wrapper").append(newItem);
    }





    //delete item
    $(".accordion-sec-item-wrapper").on("click",".delete-section",function(event) {
        if ($(".accordion-sec-item").length > 1) {
            if (confirm("Are you sure you want to delete this accordion item?")) {
                $(this).closest(".accordion-sec-item").remove();
            }
        } else {
            alert("Nice try, but you cannot delete the only accordion item available!");
        }
        event.stopPropagation();
        event.preventDefault();
    });



    $(".btn-add-new-link").click(function(e) {
        e.preventDefault();
        var l_order = $(".accordion-link-item").length + 1,
            startingId = parseInt($(".starting-id").text());
        createNewLinkItem(l_order);
    });

    function createNewLinkItem(order) {
        var newItem = `          
            <div class="accordion-link-item">                                                                            
                <div class="flex justify-between">
                    <label class="mb-0 text-base">Link ${order} Title</label>
                    <a href="#" class="delete-link text-lg text-blue-500 ">
                        <ion-icon class="font-semibold icon-feather-x-circle"></ion-icon>
                    </a>
                </div>
                                    
                <div class="form-group">                                                                                
                    <input class="shadow-none with-border bg-gray-100 h-12 mt-1 px-3 rounded-md w-full" type="text" />
                </div>

                <div class="flex justify-end mt-1 pt-1">
                    <div class="checkbox">
                        <input type="checkbox" id="chekcbox1">
                        <label for="chekcbox1" class="font-semibold text-sm">
                            <span class="border border-blue-600 rounded-none checkbox-icon"></span>Free</label>
                    </div>                                                                            
                    <div class="checkbox ml-5">
                        <input type="checkbox" id="chekcbox2">
                        <label for="chekcbox2" class="font-semibold text-sm">
                            <span class="border border-blue-600 rounded-none checkbox-icon"></span>Donload link</label>
                    </div>
                </div>
            </div>`;
        $(".accordion-sec-link-item-wrapper").append(newItem);
    }





    //delete item
    $(".accordion-sec-link-item-wrapper").on("click",".delete-link",function(event) {
        if ($(".accordion-link-item").length > 1) {
            if (confirm("Are you sure you want to delete this accordion item?")) {
                $(this).closest(".accordion-link-item").remove();
            }
        } else {
            alert("Nice try, but you cannot delete the only accordion item available!");
        }
        event.stopPropagation();
        event.preventDefault();
    });



    
    


    

});




var getLastPartOfUrl = function($url) {
    var url = $url;
    var urlsplit = url.split("/");
    var lastpart = urlsplit[urlsplit.length - 1];
    if (lastpart === '') {
        lastpart = urlsplit[urlsplit.length - 2];
    }
    return lastpart;
}


