$(function () {
    $('body').on('click','.quantity-input-down', function(event){
        event.preventDefault();

        var url = this.href;
        $('#dropdown_cart').load(url);

    });
});