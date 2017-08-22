$(function() {
   $('body').on('click', '.js-cart-btn', function(event) {
       event.preventDefault();

       $('#dropdown_cart').load(this.href);
   });

   $('.js-item-count').on('change', function() {
       var $me = $(this);

       $.post($me.data('update-url'), {count: $me.val()}, function(data, status){
            $me.closest('tr').find('.js-item-cost').html(data.itemCost);
            $('.js-cart-cost').html(data.cartCost);
            $('.js-cart-count').html(data.cartCount);
       })
   });
});
