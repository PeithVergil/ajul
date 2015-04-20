(function($, global) {
    function AjulTour(tour) {
        this.tour = tour;
    }

    AjulTour.prototype.start = function() {
        var state = hopscotch.getState();

        // End the previous tour that was started.
        if (state)
            hopscotch.endTour(true);

        // Start the tour!
        hopscotch.startTour(this.tour);
    };

    function AjulTourManager(tours) {
        var self = this;

        self.tours = {};

        $.each(tours, function(key, tour) {
            var ajulTour = new AjulTour(tour);

            if (tour.start)
                ajulTour.start();
            
            self.tours[key] = ajulTour;
        });
    }

    AjulTourManager.prototype.start = function(key) {
        var tour = this.tours[key];

        if (tour)
            tour.start();
    };

    global.ajulTourManager = new AjulTourManager(AjulTourSettings.tours);
}(jQuery, this));

(function($, global) {
    $(function() {
        $('.ajul-tour-start').click(function(e) {
            e.preventDefault();

            var tour = $(this).data('ajul-tour');

            if (tour)
                ajulTourManager.start(tour);
        });
    });
}(jQuery, this));