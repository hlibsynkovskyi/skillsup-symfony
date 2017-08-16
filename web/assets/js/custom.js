$(function() {
   $('body').on('click', '.js-cart-btn', function(event) {
       event.preventDefault();

       $('#dropdown_cart').load(this.href);
   });
});
