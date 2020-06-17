$(document).on('click', '#myTab li a', function(e){
    e.preventDefault();
    var t = $(this).attr('href');
    //debugger;
    var bools = $(this).hasClass('active');
    setCookie('active-tab',t, 1);
    if(bools === false)
    { //this is the start of our condition 
        $('#myTab li a').removeClass('active');           
        $(this).addClass('active');

        $('.tab-pane').hide();
        $(t).fadeIn('slow');
    }
});

$(document).ready(function(){
    var getActiveTab = getCookie('active-tab');
   // debugger;
    if(getActiveTab != '' && getActiveTab != undefined){
        $('#myTab li a').removeClass('active');
        $('#myTab li a[href="' + getActiveTab + '"]').addClass('active');
        //$(this).addClass('active');
        $('.tab-pane').hide();
        $(getActiveTab).fadeIn('slow');
    }
    
})




function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}

$(document).on('click', '.d-year', function(){
    if($(this).parents('ul.filter').hasClass('filter-inactive')){
        $(this).parents('ul.filter').removeClass('filter-inactive').addClass('filter-active');
    }
    else{
        $(this).parents('ul.filter').removeClass('filter-active').addClass('filter-inactive');
    }
});

$(document).on('click', '.current-year-month a', function(){
    $('.custom-calender').toggleClass('dd-active');
})

