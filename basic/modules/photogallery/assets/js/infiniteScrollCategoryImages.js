var loadImage = false;
//var documentUrl = location.href;
//var url = documentUrl.replace("web/page/category/"+categorySlug,"");
//alert(url);
window.addEventListener('load', function () {
    $(window).scroll(function () {
        if ($(window).height() + $(window).scrollTop() >= $(".image-grid").height() - 170 && !loadImage) {
            loadImage = true;
            if (typeof categorySlug !== "undefined") {
                infiniteScroll(categorySlug);
            }
        }
    });
});
function infiniteScroll() {

    CategoryUrl = window.location.href;
    protocol = CategoryUrl.split('/')[0];
    siteNameUrl = CategoryUrl.split('/')[2];
    siteUrl = protocol + "//" + siteNameUrl;
    CuttedCategoryUrl = CategoryUrl.substring(CategoryUrl.lastIndexOf('/') + 1);
    if (CuttedCategoryUrl == categorySlug) {
        pageNumber = 1;
    } else {
        pageNumber = CuttedCategoryUrl.substring(0, CuttedCategoryUrl.indexOf('?'));
    }

    $.ajax({
        url: categorySlug,
        data: {
            pageNumber: pageNumber,
        },
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
            viewNextImages(data['NextImages']);
            history.pushState(null, null, '/web/page/category/' + categorySlug + '/' + data['nextPage'] + '?per-page=' + imagesLimit);
            loadImage = false;
            if ($(window).height() + $(window).scrollTop() >= $(".image-grid").height() - 170 && !loadImage) {
                loadCategory = true;
                infiniteScroll();
            }
        },
        error: function () {
            alert("error");
        }
    });
}

function viewNextImages(data) {
    data.forEach(function (image) {
        imageElement = '<a class="image-container" href="' + siteUrl + '/' + image['image'].substr(1) + '" data-caption="' + image['title'] + '"><img class="image-grid-element" src="http://yii2-photogallery-module/' + image['image'].substr(1) + '"/></a>';
        $(".image-grid").append(imageElement);
        setTimeout(function () {
            $(".image-grid").masonry('appended', imageElement).masonry();
        }, 200);
    });
    $(".image-grid").masonry('reloadItems');
    baguetteBox.run('.image-grid');

}