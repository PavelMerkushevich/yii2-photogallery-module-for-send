var loadCategory = false;

window.addEventListener('load', function () {
    $(window).scroll(function () {
        if ($(window).height() + $(window).scrollTop() >= $(".category-grid").height() - 200 && !loadCategory) {
            loadCategory = true;
            infiniteScroll();
        }
    });
});


function infiniteScroll() {

    CategoryUrl = window.location.href;
    protocol = CategoryUrl.split('/')[0];
    siteNameUrl = CategoryUrl.split('/')[2];
    siteUrl = protocol + "//" + siteNameUrl;
    CuttedCategoryUrl = CategoryUrl.substring(CategoryUrl.lastIndexOf('/') + 1);
    if (CuttedCategoryUrl == "") {
        pageNumber = 1;
    } else {
        pageNumber = CuttedCategoryUrl.substring(0, CuttedCategoryUrl.indexOf('?'));
    }
    if (pageNumber == "") {
        pageNumber = 1;
    }
    $.ajax({
        url: "",
        data: {
            pageNumber: pageNumber
        },
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
            viewNextCategories(data['NextCategories']);
            history.pushState(null, null, '/web/' + data['nextPage'] + '?per-page=' + categoriesLimit);
            loadCategory = false;
            if ($(window).height() + $(window).scrollTop() >= $(".category-grid").height() - 200 && !loadCategory) {
                loadCategory = true;
                infiniteScroll();
            }
        },
        error: function () {
            alert("error");
        }
    });
}

function viewNextCategories(data) {
    data.forEach(function (category) {
        if (typeof category['imagePath'] !== 'undefined') {
            let imagePath = siteUrl+category['imagePath'];
            categoryElement = '<a class="gallery-item" href="'+siteUrl+'/web/page/category/' + category['slug'] + '", style="text-decoration: none;"><div class="category-info-container">  <div class="small-image" style="background: url(\'' + imagePath + '\'); background-size: cover;">   <div style="display: flex; align-items: center; justify-content: center; background-color: rgba(0,0,0,.60); width:100%; height: 25%;">   <span style="color: whitesmoke;"><span class="category-title">' + category['title'] + '</span> <span class="badge bg-secondary category-count" style="opacity: 0.8; border-radius: 6px;">' + category['count'] + '</span></span></div></div></div></a>';

            $(".category-grid").append(categoryElement);
            setTimeout(function () {
                $(".category-grid").masonry('appended', categoryElement).masonry();
            }, 200);
        }
    });
    $(".category-grid").masonry('reloadItems');

}