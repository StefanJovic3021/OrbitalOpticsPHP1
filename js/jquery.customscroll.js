$(window).on("scroll", function() {
    const height = $(window).height();
    let newHeight = (height / 2);
    const scrollTop = $(window).scrollTop();
    if (scrollTop >= newHeight)
    {
        $('#header').removeClass('alt');
        $('#header').addClass('reveal');
    }
    else
    {
        $('#header').addClass('alt');
        $('#header').removeClass('reveal');
    }
} );