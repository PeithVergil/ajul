(function($, global) {
    function AjulTour() {
        this.tour = {
            id   : AjulTourSettings.tourName,
            steps: AjulTourSettings.steps,
        };
    }

    AjulTour.prototype.start = function() {
        // Start the tour!
        hopscotch.startTour(this.tour);
    };

    global.ajulTour = new AjulTour();
}(jQuery, this));

(function($, global) {
    $(function() {console.log(AjulTourSettings);
        if (AjulTourSettings.start) {
            ajulTour.start();
        } else {
            $('#ajul-tour-start').click(function(e) {
                e.preventDefault();

                ajulTour.start();
            });
        }

    });
}(jQuery, this));