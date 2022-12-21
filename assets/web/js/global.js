$(function() {
    $('#mapModal, #streetModal').modal({
        backdrop: true,
        show: false
    }).css({
        width: '651px',
        height: '470px',
        'margin-left': function() {
            return -($(this).width() / 2);
        }
    });
    $('.dropdown-toggle').dropdown();
    $('.dropdown-menu input, .dropdown-menu label').click(function(e) {
        e.stopPropagation();
    });
    if ($('#showcase').length == 1) {
        $('#showcase-loader').hide();
        $('.showcase').show();
        $("#showcase").awShowcase({
            content_width: 620,
            content_height: 410,
            fit_to_parent: false,
            auto: false,
            interval: 3000,
            continuous: false,
            loading: true,
            tooltip_width: 200,
            tooltip_icon_width: 32,
            tooltip_icon_height: 32,
            tooltip_offsetx: 18,
            tooltip_offsety: 0,
            arrows: true,
            buttons: false,
            btn_numbers: false,
            keybord_keys: true,
            mousetrace: false,
            pauseonover: true,
            stoponclick: true,
            transition: 'hslide',
            transition_delay: 300,
            transition_speed: 500,
            show_caption: 'onhover',
            thumbnails: true,
            thumbnails_position: 'outside-last',
            thumbnails_direction: 'horizontal',
            thumbnails_slidex: 0,
            dynamic_height: false,
            speed_change: true,
            viewline: false
        });
        $("#showcase").hover(function() {
            $('.showcase-arrow-previous, .showcase-arrow-next').fadeIn();
        }, function() {
            $('.showcase-arrow-previous, .showcase-arrow-next').fadeOut();
        });
    }
    if ($('#carousel').length == 1) {
        $('#carousel-loader').hide();
        $('.showcase').show();
        $("#carousel").awShowcase({
            content_width: 590,
            content_height: 326,
            fit_to_parent: false,
            auto: true,
            interval: 3000,
            continuous: true,
            loading: true,
            tooltip_width: 200,
            tooltip_icon_width: 32,
            tooltip_icon_height: 32,
            tooltip_offsetx: 18,
            tooltip_offsety: 0,
            arrows: true,
            buttons: false,
            btn_numbers: false,
            keybord_keys: true,
            mousetrace: false,
            pauseonover: true,
            stoponclick: true,
            transition: 'hslide',
            transition_delay: 300,
            transition_speed: 500,
            show_caption: 'show',
            thumbnails: false,
            thumbnails_position: 'outside-last',
            thumbnails_direction: 'horizontal',
            thumbnails_slidex: 0,
            dynamic_height: false,
            speed_change: true,
            viewline: false
        });
        $("#carousel").hover(function() {
            $('.showcase-arrow-previous, .showcase-arrow-next').fadeIn();
        }, function() {
            $('.showcase-arrow-previous, .showcase-arrow-next').fadeOut();
        });
    }
    $('.property_sold').badger('Terjual');
    $('.property_most_viewed').badger('Most Viewed');
    $('.agent_verified').badger('Verified');
    if ($('#people_viewing').length > 0) {
        setTimeout(function() {
            $.sticky($('#people_viewing').html())
        }, 3000);
    }
    if ($('#contact_agent').length > 0) {
        $('#contact_agent').portamento();
    }
    $('#theme_switcher ul li a').bind('click', function(e) {
        $("#switch_style").attr("href", "css/" + $(this).data('rel') + ".css");
        return false;
    });
});

// var home_map;
//
// function initializeHomeMap() {
//     if ($('#home_map_canvas').length == 0)
//         return;
//     var myOptions = {
//         zoom: 5,
//         center: new google.maps.LatLng(54.5260, -4.2220),
//         mapTypeId: google.maps.MapTypeId.ROADMAP,
//         draggable: false,
//         disableDoubleClickZoom: false,
//         zoomControl: false,
//         overviewMapControl: false,
//         streetViewControl: false,
//         mapTypeControl: false,
//         scrollwheel: false,
//         disableDefaultUI: false
//     };
//     home_map = new google.maps.Map(document.getElementById('home_map_canvas'), myOptions);
//     google.maps.event.addListener(home_map, 'click', function() {
//         window.location.href = "map_properties.html";
//     });
// }
// google.maps.event.addDomListener(window, 'load', initializeHomeMap);
// var map;
//
// function initializePropertiesMap() {
//     if ($('#map_canvas').length == 0)
//         return;
//     var myLatlng = new google.maps.LatLng(51.461311, -0.303742);
//     var myOptions = {
//         zoom: 13,
//         center: myLatlng,
//         mapTypeId: google.maps.MapTypeId.ROADMAP
//     }
//     var infowindow = new google.maps.InfoWindow();
//     var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
//     $.each(map_locations, function(key, value) {
//         var marker = new google.maps.Marker({
//             position: new google.maps.LatLng(value['lat'], value['lng']),
//             map: map,
//             icon: 'css/images/marker.png',
//             scrollwheel: false,
//             streetViewControl: true,
//             title: value['title']
//         });
//         var link = "link";
//         google.maps.event.addListener(marker, 'click', function() {
//             var content = '<div id="info" class="span5"><div class="row">' + '<div class="span2"><img src="css/images/houses/house_' + (key + 1) + '.jpg" class="thumbnail" style="width:135px"/></div>' + '<div class="span3"><h3>' + value['title'] + '</h3><h6>' + value['street'] + '</h6>' + '<strong>&pound;' + value['price'] + '</strong>' + '<p><a href="property.html">Read More >></a></p>' + '</div></div></div>';
//             infowindow.setContent(content);
//             infowindow.open(map, marker);
//         });
//     });
// }
// google.maps.event.addDomListener(window, 'load', initializePropertiesMap);
