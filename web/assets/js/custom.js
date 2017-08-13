$(function() {
   $('.item-add-btn').click(function(event) {
       event.preventDefault();

       $('#dropdown_cart').load(this.href);
   });
});
