(function($) {

    var GeoResultParser = {

        getCity: function(result) {
            return this._search(result, 'locality');
        },

        getCountry: function(result) {
            return this._search(result, 'country');
        },

        _search: function(result, attribute) {
            var value = '';
            $.each(result.address_components, function(i, address) {
                if (value) return;
                if ($.inArray(attribute, address.types) !== -1)
                    value = address.long_name;
            });
            return value;
        }
    };
    
    var $profileForm = $('#profile'),
        $city = $('#profileform-city', $profileForm),
        $country = $('#profileform-country', $profileForm),
        $location = $("#profileform-address", $profileForm);
    
    $location.geocomplete().bind('geocode:result', function (event, result) {
        $city.val(GeoResultParser.getCity(result));
        $country.val(GeoResultParser.getCountry(result));
    });

    
})(jQuery);