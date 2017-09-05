$(function () {
    $('body').on('click','.js-cart-btn', function(event){ // вешаем на боди что бы при перезагрузке фрамента наши скрипты не переставали работать
        event.preventDefault();

        var url = this.href;
        $('#dropdown_cart').load(url);
    });

   // debugger;   эта строка останавливает выполнение скрипта

    $('.js-item-count').on('change',function(event){  // change говорит каким образом проводить активацию скрипта   js-item-count  говорит о том что скрипт действует на все елементы у которых класс -  js-item-count
        var $me =$(this);   // this - то что мы нажимаем, определяет наше поле

        $.post($me.data('update-url'), {count: $me.val()}, function(data, status){   // count - значение что надо передать data - массив что мы отпрвили с контроллера status выполнено или нет
        $me.closest('tr').find('.js-item-cost').html(data.itemCost); // me - это наш импут ищем ближайший класс js-item-cost и в нем прописываем itemCost
        $('.js-cart-cost').html(data.cartCost);
        $('.js-cart-count').html(data.cartCount);
        });
    });


    $('#order_settlment').select2({
        ajax: {
            url: "https://api.novaposhta.ua/v2.0/json/",
            type:'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                //отправляем наш запрос на нов почту для получения данных об адресах из их базы данных
                var data= {
                    apiKey: NOV_POSHTA_API_KEY,
                    modelName: 'Address',
                    calledMethod: 'searchSettlements',
                    methodProperties: {
                        CityName: params.term || 'Кие',
                        Limit: 20
                    }
                };
                return JSON.stringify(data);
            },
            processResults: function (data, params) {
                var items = [];

                // рпроверка на отсутствие ошибок
                if (!data.success) {
                    // alert('ошибка в получении городов');
                    // возвращяем пустой список
                    return {
                        results: []
                    }
                }
                //выборка данных с новой почты
                for (var index in data.data[0].Addresses) {
                    var address = data.data[0].Addresses[index];
                  //добав поле в массив

                    if (address.Warehouses !==0){
                        items.push({
                            id:address.DeliveryCity,
                            text:address.MainDescription
                        })
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




    // ставим обработчик собития чендже
    $('#order_settlment').on('change',function(){

        var request= {
            apiKey: NOV_POSHTA_API_KEY,
            modelName: 'Address',
            calledMethod: 'getWarehouses',
            methodProperties: {
                CityName: $(this).find('option:selected').html(),
                CityRef: $(this).val()

            }
        };
        // получаем селект с выбором отделения
        var $warehouseSelect = $('#order_warehouse');
        //очищаем опции селекта с отделениями
        $warehouseSelect.html('');

        $.post("https://api.novaposhta.ua/v2.0/json/", JSON.stringify(request), function(response){
            if (!response.success) {
                // alert('ошибка в получении городов');
                // возвращяем пустой список
                return {

                }
            }
            //выборка данных с новой почты
            for (var index in response.data) {
                var warehouse = response.data[index];
                //созд опцию для селекта
                    $option = $('<option/>');
                    // указываем ид отделения в опции
                    $option.attr('value', warehouse.Ref);
                    // указываем содержимое опции назв отделения
                $option.html(warehouse.Description);
                // добавляем опцию в селект
                $warehouseSelect.append($option);
            }
        });
    });
});