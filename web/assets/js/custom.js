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

   $('#order_settlement').select2({
       ajax: {
           url: "http://api.novaposhta.ua/v2.0/json/",
           type: 'POST',
           dataType: 'json',
           delay: 250,
           data: function (params) {
               // Отправляем параметры в формате, который ожидает API новой почты
               // (https://devcenter.novaposhta.ua/docs/services/556d7ccaa0fe4f08e8f7ce43/operations/58e5ebeceea27017bc851d67).
               var data = {
                   apiKey: '6ac8e137ab778e000b0b387c51613ff0',
                   modelName: 'Address',
                   calledMethod: 'searchSettlements',
                   methodProperties: {
                       CityName: params.term || 'Киї',
                       Limit: 20
                   }
               };

               return JSON.stringify(data);
           },
           processResults: function (data, params) {
               // Преобразуем полученные от API НП данные в формат, который понимает select2
               var items = [];

               // Проверка на отсутствие ошибок
               if (!data.success) {
                   // Возвращаем пустой список
                   return {
                       results: []
                   }
               }

               // Идем по данным из новой почты. Пример на https://my.novaposhta.ua/settings/index
               // в результате выполнения запроса с параметрами, описанными выше в data: function (params)
               for (var index in data.data[0].Addresses) {
                   var address = data.data[0].Addresses[index];

                   if (address.Warehouses !== 0) {
                       items.push({
                           id: address.Ref,
                           text: address.MainDescription
                       });
                   }
               }

               return {
                   results: items
               };
           },
           cache: true,
           minimumInputLength: 3
       }
   });
});
