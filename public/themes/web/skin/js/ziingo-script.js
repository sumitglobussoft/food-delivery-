
var Ziingo = function(){
    var headerFunctions = function(){
        $(window).scroll(function (event) {
            var scrolled = $(window).scrollTop();
            (scrolled > 50) ? $('body').addClass('scrolled') : $('body').removeClass('scrolled') ;
        });
        $('#forgotBtn').on('click',function(){
            $('#loginContent').addClass('hide');
            $('#passwordResetContent').removeClass('hide');
        });
    };

    var parallelxFunction = function(){
        $('.parallax').parallax();
    };
    var modalFunction = function(){
        $('.modal-trigger').leanModal();
    };

    var materialSelectFun = function () {
        $('select.material-select').material_select();
    };

    var tooltipFunction = function () {
        $('.tooltipped').tooltip({delay: 50});
    };

    var tabsFunction = function(){
        $('ul.tabs').tabs();
    };

    var dropdownFunction= function () {
        $(".dropdown-button").dropdown();
    };


    return{
        initComponents: function () {
            headerFunctions();
            parallelxFunction();
            modalFunction();
            materialSelectFun();
            tooltipFunction();
            tabsFunction();
            dropdownFunction();
        },
        initTooltipFunction:function(){
            tooltipFunction();
        }




    }
}(jQuery);


var Layout = function () {

    var countUpFunction = function(){
        var options = {
            useEasing : true,
            useGrouping : false,
            separator : ',',
            decimal : '.',
            prefix : '',
            suffix : ''
        };
        var restaurantCount = new CountUp("restaurantCount", 0, 2688, 0, 2.5, options);
        restaurantCount.start();

        var orderCount = new CountUp("orderCount", 0, 6050, 0, 3, options);
        orderCount.start();

        var usersCount = new CountUp("usersCount", 0, 15000, 0, 3.5, options);
        usersCount.start();

    };

    var popularRestaurantSlider = function(){
        var slider = $('#popularRestaurants');
        slider.owlCarousel({
            loop:true,
            nav:false,
            margin:10,
            autoWidth:true,
            items:4,
            autoplay:true,
            autoplayTimeout:2500,
            autoplayHoverPause:true
        });
    };

    var restaurantRatings = function () {
        $.fn.raty.defaults.path = 'assets/plugins/raty-jquery/images';

        $('.restaurant-rating').raty({
            numberMax : 5,
            score: function() {
                return $(this).attr('data-score');
            },
            readOnly   : true,
            half: true,
            hints: ['Bad', 'Poor', 'Regular', 'Good', 'Gorgeous'],
            noRatedMsg : "I haven't rated yet!",
        });

    };

    var restaurantGridFunction = function () {
        $('.restaurantList').isotope({
            // options
            itemSelector: '.item',
            layoutMode: 'fitRows',
            percentPosition: true,
        });

    };

    var restaurantFilterOption = function (){

        $(window).scroll(function (event) {
            var topScroll = $(window).scrollTop();

            if(topScroll > 180){
                $('#filterOptionsRestaurantLists').addClass('fixed-filter z-depth-1');
            }else{
                $('#filterOptionsRestaurantLists').removeClass('fixed-filter z-depth-1');
            }

        });
    };

    var userRatingFunction = function () {
        $.fn.raty.defaults.path = 'assets/plugins/raty-jquery/images';

        $('.userRating').raty({
            numberMax : 5,
            score: function() {
                return $(this).attr('data-score');
            },
            readOnly   : true,
            half: false,
            hints: ['Bad', 'Poor', 'Regular', 'Good', 'Gorgeous'],
            noRatedMsg : "I haven't rated yet!",
        });

    };
    var addUserRating = function () {
        $.fn.raty.defaults.path = 'assets/plugins/raty-jquery/images';

        $('.addYourRating').raty({
            numberMax : 5,
            click: function(score, evt) {
                console.log(evt);
                alert('ID: ' + this.id + "\nscore: " + score);

            },
            readOnly   : false,
            half: false,
            hints: ['Bad', 'Poor', 'Regular', 'Good', 'Gorgeous'],
            noRatedMsg : "I haven't rated yet!",
        });

    };

    return{

        initLayoutComponents : function () {
            countUpFunction();
            popularRestaurantSlider();
            restaurantRatings();
        },

        initRestaurantGrid: function () {
            restaurantGridFunction();
            restaurantRatings();
            restaurantFilterOption();
        },

        initRestaurantRating : function () {
            restaurantRatings();
        },

        initUserRatings: function () {
            userRatingFunction();
        },

        initAddYourRating: function () {
            addUserRating();
        },



    }

}(jQuery);


