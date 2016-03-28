function App() {
    this.map = new google.maps.Map(document.getElementsByClassName('map_canvas')[0], this.options.map);
    this.autocompleteService = new google.maps.places.AutocompleteService();
    this.placesService = new google.maps.places.PlacesService(this.map);
}

App.prototype = {

    map: undefined,
    autocompleteService: undefined,
    placesService: undefined,
    marker: undefined,

    autocompleteVariants: {},

    options: {
        autocompleteVariantsCount: 3,
        autocompleteService: {},
        map: {
            zoom: 15,
            minZoom: 2,
            maxZoom: 20,
            scrollwheel: true,
            panControl: true,
            mapTypeId: "roadmap"
        },
        appropriateAddressComponentsForPanel: [
            'street_number',
            'route',
            'locality',
            'country',
            'administrative_area_level_1',
            'postal_code'
        ]
    },

    showOnMap: function (latLng) {
        this.map.setCenter(latLng);
        if (this.marker) {
            this.marker.setPosition(latLng);
        } else {
            this.createMarker(latLng);
        }
    },

    createLatLng: function (lat, lng) {
        return new google.maps.LatLng(lat, lng);
    },

    createMarker: function (latLng) {
        this.marker = new google.maps.Marker({
            position: latLng,
            map: this.map,
            draggable: true
        });

        var App = this;
        this.marker.addListener('dragend', function () {
            App.findMeByCoordinates(App.marker.getPosition().lat(), App.marker.getPosition().lng())
        });

        return this.marker;
    },

    resetAutocompleteVariants: function () {
        this.autocompleteVariants = {};
    },

    addAutocompleteVariants: function (type, variants) {
        this.autocompleteVariants[type] = variants;
    },

    getAutocompleteVariants: function() {
        var autocomplete = [];
        for (key in this.autocompleteVariants) {
            autocomplete = autocomplete.concat(this.autocompleteVariants[key]);
        }
        return autocomplete;
    },

    getAutocompleteVariantsFromGoogle: function (search, autocompleteResponse) {
        var App = this;
        this.autocompleteService.getPlacePredictions({input: search}, function (data) {
            if (data === null) {
                return
            }

            data = data.slice(0, App.options.autocompleteVariantsCount);

            data.forEach(function (currentElement, index, array) {
                currentElement.value = currentElement.description;
                currentElement.itemIconClass = 'ui-menu-item-icon-google';
                currentElement.logoClass = index < array.length - 1 ? '' : 'pac-logo';
                currentElement.autocompleteType = 'google';
            });

            App.addAutocompleteVariants('google', data);
            autocompleteResponse(App.getAutocompleteVariants());
        });
    },

    getAutocompleteVariantsFromLocName: function (search, autocompleteResponse) {

        var App = this;

        $.ajax({
            url: "http://api-v2.locname.com/api/v2/autocomplete",
            dataType: "jsonp",
            data: {
                term: search
            },
            success: function (data) {

                var autocompleteData = [];
                for (key in data) {
                    if (key != parseInt(key, 10) || key >= App.options.autocompleteVariantsCount) {
                        break;
                    }
                    autocompleteData.push(data[key])
                }

                autocompleteData.forEach(function (currentElement, index, array){
                    currentElement.itemIconClass = 'ui-menu-item-icon';
                    currentElement.logoClass = index < array.length - 1 ? '' : 'locName-logo';
                    currentElement.autocompleteType = 'locName';
                });

                App.addAutocompleteVariants('locName', autocompleteData);
                autocompleteResponse(App.getAutocompleteVariants());
            }
        });
    },

    selectGoogleAutocompleteVariant: function (item) {
        var App = this;
        this.placesService.getDetails(item, function (place, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                var item = App.processGoogleAddress(place);
                item.late = place.geometry.location.lat();
                item.long = place.geometry.location.lng();
                App.showOnMap(place.geometry.location);
                App.showPlaceAttributesOnPanel(item);
            }
        });
    },

    selectLocNameAutocompleteVariant: function (item) {
        this.showOnMap(this.createLatLng(item.late, item.long));
        this.showPlaceAttributesOnPanel(item);
    },

    findMe: function () {
        var App = this;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                App.findMeByCoordinates(position.coords.latitude, position.coords.longitude)
            });
        }
    },

    findMeByCoordinates: function (lat, lng) {
        var App = this;
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json",
            data: {
                latlng: lat + ',' + lng
            },
            success: function (data) {
                if (data.status === "OK" && data.results.length) {
                    var place = data.results[0];
                    var item = App.processGoogleAddress(place);

                    item.late = place.geometry.location.lat;
                    item.long = place.geometry.location.lng;

                    App.showOnMap(place.geometry.location);
                    App.showPlaceAttributesOnPanel(item);
                }
            }
        });
    },

    processGoogleAddress: function (place) {
        var App = this;
        var item = {};
        place.address_components.forEach(function (curComponent) {
            curComponent.types.forEach(function (curType) {
                if (App.options.appropriateAddressComponentsForPanel.indexOf(curType) >= 0) {
                    item[curType] = curComponent.long_name;
                    return;
                }
            });
        });

        item.state = item.administrative_area_level_1;
        item.city = item.locality;
        item.street_name = item.route;

        return item;
    },

    showPlaceAttributesOnPanel: function (item) {
        $('.add-on').val('');
        $('#place_id').val(item.id);
        $('#street_number').val(item.street_number).removeAttr("disabled", "disabled");
        $('#route').val(item.street_name).removeAttr("disabled", "disabled");
        $('#locality').val(item.city).removeAttr("disabled", "disabled");
        $('#administrative_area_level_1').val(item.state).removeAttr("disabled", "disabled");
        $('#postal_code').val(item.postal_code).removeAttr("disabled", "disabled");
        $('#country').val(item.country).removeAttr("disabled", "disabled");
        $('#lat').val(item.late).removeAttr("disabled", "disabled");
        $('#lng').val(item.long).removeAttr("disabled", "disabled");
    }
};