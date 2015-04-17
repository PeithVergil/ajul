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

    Collections.destinations = new Destinations(AjulSettings.destinations);
}(jQuery, this));

//////////////////////////////////////////////////
// VIEWS
//////////////////////////////////////////////////

(function($, global) {
    var Views = Ajul.Views = Ajul.Views || {};

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
            this.listenTo(this.collection, 'destroy', this.render);
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

    Views.DestinationItemView = Ajul.Views.TemplateView.extend({
        events: {
            'click a.edit'  : 'handleUpdate',
            'click a.delete': 'handleDelete',
        },

        tagName: 'li',

        template: _.template($('script#ajulDestinationItemTemplate').html()),

        className: 'destinationItem',

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

    Views.DestinationEmptyView = Ajul.Views.TemplateView.extend({
        tagName: 'li',
        template: _.template($('script#ajulDestinationEmptyTemplate').html()),
    });

    Views.DestinationFormView = Ajul.Views.DialogView.extend({
        id: 'destinationFormDialog',

        events: {
            'submit form': 'handleSubmit'
        },

        template: _.template($('script#ajulDestinationFormTemplate').html()),

        initialize: function(options) {
            Ajul.Views.DialogView.prototype.initialize.apply(this, arguments);

            _.bindAll(this, 'handleClick');
        },

        dialogOptions: function() {
            return {
                buttons: [
                    {
                        text: AjulSettings.texts.formSaveButton,
                        icons: {
                            primary: 'ui-icon-plusthick'
                        },
                        click: this.handleClick
                    }
                ]
            };
        },

        handleClick: function() {
            var self = this;

            var data = {
                page     : self.$('#page').val(),
                title    : self.$('#title').val(),
                target   : self.$('#target').val(),
                content  : self.$('#content').val(),
                placement: self.$('#placement').val(),
            };

            Ajul.Collections.destinations.create(data, {
                success: function(model, response) {
                    var data = response.data;

                    if (response.success) {
                        model.set({
                            id: data.id
                        });
                    } else {
                        alert(data.message);
                    }

                    self.dialogClose();
                },
                wait: true
            });
        },

        handleSubmit: function(e) {
            e.preventDefault();

            this.handleClick();
        },
    });

    Views.DestinationDeleteView = Ajul.Views.DialogView.extend({
        id: 'destinationDeleteDialog',

        template: _.template($('script#ajulDestinationDeleteTemplate').html()),

        attributes: {
            title: 'Confirm Delete'
        },

        dialogOptions: function() {
            return {
                buttons: [
                    {
                        text: 'Delete',
                        click: _.bind(this.handleDelete, this)
                    },
                    {
                        text: 'Cancel',
                        click: _.bind(this.handleCancel, this)
                    },
                ]
            };
        },

        handleDelete: function() {
            var self = this;

            self.model.destroy({
                success: function(model, response) {
                    if (!_.isUndefined(response) && !response.success) {
                        alert(response.data.message);
                    }

                    self.dialogClose();
                },
                wait: true
            });
        },

        handleCancel: function() {
            this.dialogClose();
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