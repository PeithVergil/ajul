(function($, global) {
    global.Ajul = global.Ajul || {};
}(jQuery, this));

//////////////////////////////////////////////////
// MODELS
//////////////////////////////////////////////////

(function($, global) {
    var Models = Ajul.Models = {};

    Models.Destination = Backbone.Model.extend({
        url: function() {
            return AjulSettings.ajax;
        },

        sync: function(method, model, options) {
            switch(method) {
                case 'create':
                    var data = _.extend({
                        action: AjulSettings.actions.destinationCreate,
                        nonce: AjulSettings.nonces.destinationCreate,
                        post: AjulSettings.post,
                    }, model.toJSON());
                    break;

                case 'delete':
                    var data = _.extend({
                        action: AjulSettings.actions.destinationDelete,
                        nonce: AjulSettings.nonces.destinationDelete,
                        post: AjulSettings.post,
                    }, model.toJSON());
                    break;

                default:
                    return Backbone.sync.call(this, method, model, options);
            }

            var $request = $.post(this.url(), data);

            if (!_.isUndefined(options.success))
                $request.done(options.success);

            if (!_.isUndefined(options.error))
                $request.fail(options.error);

            return $request;
        },
    });
}(jQuery, this));

//////////////////////////////////////////////////
// COLLECTIONS
//////////////////////////////////////////////////

(function($, global) {
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
            var formView = new Views.DestinationsFormView({
                title: AjulSettings.texts.formCreateTitle
            });

            formView.render();
        },
    });

    Views.DestinationsFormView = Backbone.View.extend({
        id: 'destinationFormDialog',

        events: {
            'submit form': 'handleSubmit'
        },

        template: _.template($('script#ajulDestinationFormTemplate').html()),

        initialize: function(options) {
            this.title = '';

            if (!_.isUndefined(options) && !_.isUndefined(options.title)) {
                this.title = options.title;
            }

            _.bindAll(this, 'handleClick', 'handleClose');
        },

        render: function() {
            this.$el.html(this.template());

            // Just append the dialog to the root.
            $('body').append(this.$el);

            this.$el.dialog({
                title    : this.title,
                fluid    : true,
                modal    : true,
                width    : '500',
                height   : 'auto',
                draggable: false,
                resizable: false,
                buttons: [
                    {
                        text: AjulSettings.texts.formSaveButton,
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
            var destination = new Ajul.Models.Destination({
                page   : this.$('#page').val(),
                element: this.$('#element').val(),
                content: this.$('#content').val(),
            });

            destination.save(null, {
                success: function(model, response) {
                    console.log('success...');
                    console.log(response);
                    console.log(model);
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