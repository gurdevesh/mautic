$(document).on('click', '#myTab li a', function(){
            
    var t = $(this).attr('href');
    var bools = $(this).hasClass('active');
    if(bools === false)
    { //this is the start of our condition 
        $('#myTab li a').removeClass('active');           
        $(this).addClass('active');

        $('.tab-pane').hide();
        $(t).fadeIn('slow');
    }
});