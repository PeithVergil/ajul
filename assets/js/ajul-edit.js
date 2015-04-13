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
    var Collections = Ajul.Collections = {};

    var Destinations = Backbone.Collection.extend({
        model: Ajul.Models.Destination
    });

    Collections.destinations = new Destinations([
        {
            page: 'Home',
            title: 'Lorem ipsum',
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque non orci sed lacus tempus venenatis eu vitae turpis. Suspendisse sit amet elit est.'
        },
        {
            page: 'Home',
            title: 'Vestibulum laoreet',
            content: 'Vestibulum laoreet fermentum libero id congue. Nunc accumsan massa vel sem ultrices faucibus. Quisque sollicitudin ipsum eu justo gravida dapibus.'
        },
        {
            page: 'About',
            title: 'Morbi lacus',
            content: 'Morbi lacus erat, mattis eget tincidunt vel, condimentum cursus lacus. Maecenas aliquam, est a auctor feugiat, dolor nisl accumsan leo, ut faucibus augue enim ac magna.'
        },
        {
            page: 'About',
            title: 'Phasellus sed lectus',
            content: 'Phasellus sed lectus ac augue faucibus bibendum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut vel sollicitudin dolor.'
        },
        {
            page: 'About',
            title: 'In nulla mi',
            content: 'In nulla mi, aliquet sit amet cursus ac, dignissim et urna. Fusce vehicula adipiscing blandit. Nulla lacinia, quam ac gravida dictum, elit purus pharetra mi, in venenatis sem purus convallis nisl.'
        },
    ]);
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

        render: function() {
            this.$('#destinationCreate').button({
                icons: {
                    primary: 'ui-icon-plusthick'
                }
            });

            var destinationListView = new Views.DestinationListView({
                collection: Ajul.Collections.destinations
            });

            this.$('#ajulMetaboxContent').append(destinationListView.render().$el);

            return this;
        },

        handleDestinationCreate: function() {
            var formView = new Views.DestinationFormView({
                title: AjulSettings.texts.formCreateTitle
            });

            formView.render();
        },
    });

    Views.DestinationListView = Backbone.View.extend({
        id: 'destinationList',

        tagName: 'ul',

        initialize: function() {
            // Child views
            this.views = null;

            this.listenTo(this.collection, 'add', this.render);
        },

        render: function() {
            this.removeViews();

            if (this.collection.isEmpty()) {
                this.createEmpty();
            } else {
                this.createItems();
            }

            this.$el.html(
                _.map(this.views, function(view) {
                    return view.render().$el;
                })
            );

            return this;
        },

        removeViews: function() {
            if (_.isNull(this.views))
                return;

            _.each(this.views, function(view) {
                view.remove();
            });

            this.views = null;
        },

        createEmpty: function() {
            this.views = [
                new Views.DestinationEmptyView()
            ];
        },

        createItems: function() {
            this.views = this.collection.map(function(item) {
                return new Views.DestinationItemView({
                    model: item
                });
            });
        },
    });

    Views.DestinationEmptyView = Backbone.View.extend({
        tagName: 'li',

        template: _.template($('script#ajulDestinationEmptyTemplate').html()),

        render: function() {
            this.$el.html(this.template());

            return this;
        },
    });

    Views.DestinationItemView = Backbone.View.extend({
        events: {
            'click a.edit'  : 'handleUpdate',
            'click a.delete': 'handleDelete',
        },

        tagName: 'li',

        template: _.template($('script#ajulDestinationItemTemplate').html()),

        className: 'destinationItem',

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));

            return this;
        },

        handleUpdate: function(e) {
            e.preventDefault();

            console.log({
                'update': this.model.get('title')
            });
        },

        handleDelete: function(e) {
            e.preventDefault();

            var deleteConfirmView = new Views.DestinationDeleteView({
                model: this.model
            });

            deleteConfirmView.render();
        },
    });

    Views.DestinationFormView = Backbone.View.extend({
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
            var self = this;

            var destination = new Ajul.Models.Destination({
                page   : self.$('#page').val(),
                title  : self.$('#title').val(),
                content: self.$('#content').val(),
                element: self.$('#element').val(),
            });

            destination.save(null, {
                success: function(model, response) {
                    if (response.success) {
                        Ajul.Collections.destinations.add(destination);
                    } else {
                        alert(response.data.message);
                    }

                    self.$el.dialog('close');
                },
                wait: true
            });
        },

        handleClose: function() {
            // Destroy the jQuery UI dialog object.
            this.$el.dialog('destroy');

            // Remove element from DOM.
            this.remove();
        },

        handleSubmit: function(e) {
            e.preventDefault();

            this.handleClick();
        },
    });

    Views.DestinationDeleteView = Backbone.View.extend({
        id: 'destinationDeleteDialog',

        template: _.template($('script#ajulDestinationDeleteTemplate').html()),

        attributes: {
            title: 'Confirm Delete'
        },

        initialize: function() {
            _.bindAll(this, 'handleDelete', 'handleCancel', 'handleClose');
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));

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
                        text: 'Delete',
                        click: this.handleDelete
                    },
                    {
                        text: 'Cancel',
                        click: this.handleCancel
                    },
                ],
                close: this.handleClose
            });

            return this;
        },

        remove: function() {
            // Destroy the jQuery UI dialog object.
            this.$el.dialog('destroy');

            // Remove the element from the DOM.
            Backbone.View.prototype.remove.call(this);
        },

        handleDelete: function() {
            this.remove();
        },

        handleCancel: function() {
            this.remove();
        },

        handleClose: function() {
            this.remove();
        },
    });
}(jQuery, this));

//////////////////////////////////////////////////
// MAIN
//////////////////////////////////////////////////

(function($, global) {
    $(function() {
        var destinationsMetaboxView = new Ajul.Views.DestinationsMetaboxView({
            el: $('div#ajulMetaboxDestinations')
        });

        destinationsMetaboxView.render();
    });
}(jQuery, this));