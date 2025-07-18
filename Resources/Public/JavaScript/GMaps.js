require.config({
    paths: {
        'async': 'lib/requirejs-plugins/src/async'
    }
});

define(['https://maps.google.com/maps/api/js?key=AIzaSyAeFL1mw0cUjDZ5kSM7nTQiXgLTDZGJUwg'], function() {
    // Google Maps API and all its dependencies will be loaded here.
    var GMaps = GMaps || {
        init: function () {
            console.log("Gmaps Init");
            return GMaps;

        }
    };
    return GMaps.init();

});
