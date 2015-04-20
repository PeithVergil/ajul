(function($, global) {
    function AjulTour(tour) {
        this.tour = tour;
    }

    AjulTour.prototype.start = function() {
        // Start the tour!
        hopscotch.startTour(this.tour);
    };

    function AjulTourManager(tours) {
        var self = this;

        self.tours = {};

        $.each(tours, function(key, tour) {
            self.tours[key] = new AjulTour(tour);
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
        // var $startTourButton = $('#ajul-tour-start').click(function(e) {
        //     e.preventDefault();

        //     ajulTourManager.start();
        // });

        // if (AjulTourSettings.start)
        //     $startTourButton.click();
    });
}(jQuery, this));