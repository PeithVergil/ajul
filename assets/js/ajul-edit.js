(function($, global) {
    global.Ajul = global.Ajul || {};
}(jQuery, this));

//////////////////////////////////////////////////
// MODELS
//////////////////////////////////////////////////

(function($, global) {
    var Models = Ajul.Models = {};

    Models.Destination = Backbone.Model.extend({});
}(jQuery, this));

//////////////////////////////////////////////////
// VIEWS
//////////////////////////////////////////////////

(function($, global) {
    var Views = Ajul.Views = {};

    Views.DestinationsMetaboxView = Backbone.View.extend({
        events: {
            'click #destinationCreate': 'handleDestinationCreate',
        },

        initialize: function() {
            this.$('#destinationCreate').button({
                icons: {
                    primary: 'ui-icon-plusthick'
                }
            });
        },

        handleDestinationCreate: function() {
            var formView = new Views.DestinationsFormView();
        },
    });

    Views.DestinationsFormView = Backbone.View.extend({
        id: 'destinationFormDialog',

        events: {
            'submit form': 'handleSubmit'
        },

        template: _.template($('script#ajulDestinationFormTemplate').html()),

        initialize: function() {
            _.bindAll(this, 'handleClick', 'handleClose');

            this.render();
        },

        render: function() {
            this.$el.html(this.template());

            // Just append the dialog to the root.
            $('body').append(this.$el);

            this.$el.dialog({
                fluid    : true,
                modal    : true,
                width    : '400',
                height   : 'auto',
                minWidth : 400,
                maxWidth : 600,
                minHeight: 400,
                maxHeight: 600,
                buttons: [
                    {
                        text: AjulSettings.texts.formCreateButton,
                        icons: {
                            primary: 'ui-icon-plusthick'
                        },
                        click: this.handleClick
                    }
                ],
                close: this.handleClose
            });

            return this;
        },

        handleClick: function() {
            var $target = this.$('input#target');
            var $prev   = this.$('input#prev');
            var $next   = this.$('input#next');

            var destination = new Ajul.Models.Destination({
                target: $target.val(),
                prev  : $prev.val(),
                next  : $next.val(),
            });

            destination.save(null, {
                success: function(response) {
                    console.log('success...');
                    console.log(response);
                },
            });

            this.$el.dialog('close');
        },

        handleClose: function() {
            this.remove();
        },

        handleSubmit: function(e) {
            e.preventDefault();

            this.handleClick();
        },
    });
}(jQuery, this));

//////////////////////////////////////////////////
// MAIN
//////////////////////////////////////////////////

(function($, global) {
    $(function() {
        new Ajul.Views.DestinationsMetaboxView({
            el: $('div#ajulMetaboxDestinations')
        });
    });
}(jQuery, this));