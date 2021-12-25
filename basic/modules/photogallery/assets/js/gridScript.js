window.onload = function () {
    $('.category-grid').css({
        'display': 'flex'
    });

    $('.category-grid').masonry({
        itemSelector: '.gallery-item',
        transitionDuration: 0,
        columnWidth: 40,
        gutter: 2,
        percentPosition: true
    });

    $('.image-grid').css({
        'display': 'flex'
    });

    $('.image-grid').masonry({
        itemSelector: '.image-grid-element',
        transitionDuration: 0,
        columnWidth: 40,
        gutter: 2,
        percentPosition: true
    });

    $('.load-animation').css({
        'display': 'none'
    });
};

