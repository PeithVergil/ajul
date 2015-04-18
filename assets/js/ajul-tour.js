(function($, global) {
    function AjulTour(tour) {
        this.tour = tour;
    }

    AjulTour.prototype.start = function() {
        // Start the tour!
        hopscotch.startTour(this.tour);
    };

    global.ajulTour = new AjulTour(AjulTourSettings.tour);
}(jQuery, this));

(function($, global) {
    $(function() {
        var $startTourButton = $('#ajul-tour-start').click(function(e) {
            e.preventDefault();

            ajulTour.start();
        });

        if (AjulTourSettings.start)
            $startTourButton.click();
    });
}(jQuery, this));