$(document).on('click', '#myTab li a', function(e){
    e.preventDefault();
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

$(document).on('click', '.d-year', function(){
    if($(this).parents('ul.filter').hasClass('filter-inactive')){
        $(this).parents('ul.filter').removeClass('filter-inactive').addClass('filter-active');
    }
    else{
        $(this).parents('ul.filter').removeClass('filter-active').addClass('filter-inactive');
    }
});