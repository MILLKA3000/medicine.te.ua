/*
 * tCollapse jQuery plugin
 * version 0.4b
 *
 * Copyleft  2010 Alexander Moskaliov (irker.net/tCollapse)
 *
 */



(function($) {

 

    // -- ресайз браузера
    // таймер отслеживания изменения размера window
    var resizeTimer = null;
    // отслеживаем изменение окна
    $(window).bind('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            //обновляем стили коллекции
            updateCollapse(collapseСollection);
        }, 100);
    });
    // -- ресайз браузера



    // -- превью ячейки
    // таймер показа ячейки
    var timerView=false;

    // скрытие превьюшки
    function canselView()
    {
        if (timerView) {
            clearTimeout(timerView);
            timerView=false;
        }
        $('#tCpsePreview').hide();
    
    }



    $('.tCpseTR .tCpseContainerCollapsed').
    
    live('mouseover',
        function() {
    
            var self=$(this);
            timerView=setTimeout(function(){
    
           
                timerView=false;
    
                $('#tCpsePreview').data('string',self.parent().parent()).html(self.html()).css(
                {
                    left:self.offset().left,
                    top:self.offset().top,
                    fontWeight:self.css('fontWeight'),
                    fontSize:self.css('fontSize'),
                    backgroundColor:self.css('background-color'),
                    display:'block'
                }
                ).
                width(self.width()).
                show();
    
    
            }, 100);
    
    
    
        }
        ).
    live('mouseout',
        function() {

            //  console.log(timerView);
            if (timerView){
                canselView();
            }


        }
        )
    ;
    // -- превью ячейки




    // -- основные функции
    //коллекция div  с классом indicator
    var collapseСollection= $([]);
    
    
    //функция удаляет класс collapsed тем дивам, которые не влезли в одну строку, и убирает у тех, которые влезли
    function updateCollapse(collapsingElements)
    {
        if (collapsingElements)
        {
            //отсеиваем только те, которым нужно переключить класс
            collapsingElements.filter(
                function ()
                {
                    var element=$(this);
                    var element2=$(this).children();
                    //  высотой больше stringsCountTable строк и не класса collapsed или высотой в stringsCountTable строк и класса collapsed
                    return (element2.height()>(element.data('height'))) ^ element.hasClass('tCpseContainerCollapsed');
                }
                ).
            // переключаем класс
            toggleClass('tCpseContainerCollapsed');



        }
    }

    //определение высоты 1 текстовой строки таблицы
    function heightTR(table)
    {
        var temp=$('<tr><td><div>A</div></td></td>').appendTo(table);
        var height=temp.find('div').height();
        temp.remove();
        return height;
    }

    // сворачиваем одну таблицу
    $.fn.tCollapseOne = function(stringsCount) {
        var table=$(this);
        if (table.is('table')) {
            
            // если содержит <tbody> переключаемся на него
            table=  $('tbody',this).lenght==0 ? table  : $('tbody',this) ;


            // высота 1 табличной строки
            var height=1*(stringsCount ? stringsCount : 1)*heightTR(table)+5;

            // переменная уникальная для каждой из таблиц - содержит развернутую строку
            var oldUnCollapse=null;

            // перебираем строки
            table.children('tr:not(.tCpseTR)').
            // добавляем класс
            addClass('tCpseTR').
            // по клику на строку разворачиваем ее
            bind('click.tCpse',
                function ()  {
                    canselView();

                    // получаем строку
                    var string=$(this).has('.tCpseContainerCollapsed');
                    // если строка содержит свернутые ячейки
                    if (string.length!=0) {
                        // развернута ли уже строка
                        var isUnCollapsed=string.data('uncollapsed');
                        // сворачиваем строку, которая уже была развернута
                        if (oldUnCollapse) {
                            oldUnCollapse.addClass('tCpseTR').data('uncollapsed','').find('.tCpseContainer').height(height);
                        }
                        // строка еще не развернута
                        if (!isUnCollapsed){
                            // разворачиваем строку путем удаления класса .tCpseTR и снятием height у свернутых дивов
                            string.data('uncollapsed',true).removeClass('tCpseTR').find('.tCpseContainer').height('');
                            // сохраняем строку
                            oldUnCollapse = string;
                        }
                    }
                }
                ).

            // берем все ячейки ( не берем th )
            children('td').
            each(
                function ()
                {
                    // вставляем два div внутрь каждой ячейки:
                    // первый div с помощью класса collapsing и свойства height обрезается до высоты stringsCountTable текстовыч строк
                    // второй div не обрезается и служит в дальнейшем индикатором высоты - его высоту сравниваем с высотой stringsCountTable текстовых строк в функции updateCollapse
                    $(this).html( "<div class='tCpseContainer' style='height:"+
                        (height)+"px;'><div class='tCpseIndicator'>"+
                        $(this).html() + "</div></div>");
                }
                );
            // добавляем к коллекции новые элементы
            collapseСollection = collapseСollection.
            add($('.tCpseContainer',this).
                // также указываем им данные о высоте, чтобы ускорить работу функции updateCollapse
                data('height',height));

        }
    };

    // сворачиваем набор таблиц
    $.fn.tCollapse = function(stringsCount) {

        if ($('#tCpsePreview').length==0) {
        
            $('<div id="tCpsePreview"></div>').
            appendTo('body').
            bind('mouseout',function(){
                canselView();
            }).click(
        function  () {
            $(this).data('string').click();
        }
    );
        
        }

        //пробегаемся по элементам
        $(this).each (
            function () {
                $(this).tCollapseOne(stringsCount);
                    
            }
            );

        updateCollapse(collapseСollection);


        return this;

    };

    // удаляет таблицу из управляемых плагином
    $.fn.removeCollapse = function() {
        //пробегаемся по элементам
        $(this).each (
            function () {
                if ($(this).is('table')) {
                    // ищем все строки, управляемые плагином
                    $('.tCpseTR',this).
                    removeClass('tCpseTR').
                    unbind('click.tCpse').
                    children('td').
                    each(
                        function()
                        {
                            //удаляем вспомогательные div
                            $(this).html($('.tCpseIndicator',this).html());
                        }
                        );
                            

                }
            }
            );
    };

})(jQuery);