(function($, global) {
    $(function() {
        var tour = {
            id: 'hello-hopscotch',
            steps: AjulTourSettings.steps,
        };

        // Start the tour!
        hopscotch.startTour(tour);
    });
}(jQuery, this));