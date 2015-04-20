(function($, global) {
    global.Ajul = global.Ajul || {};
}(jQuery, this));

(function($, global) {
    var Views = Ajul.Views = Ajul.Views || {};

    Views.TemplateView = Backbone.View.extend({
        render: function() {
            this.$el.html(this.template({ data: this.templateData() }));

            return this;
        },

        templateData: function() {
            if (_.isUndefined(this.model))
                return null;

            return this.model.toJSON();
        },
    });
    
    Views.DialogView = Views.TemplateView.extend({
        initialize: function(options) {
            this.title = '';

            if (!_.isUndefined(options) && !_.isUndefined(options.title)) {
                this.title = options.title;
            }

            _.bindAll(this, 'close');
        },

        render: function() {
            Views.TemplateView.prototype.render.call(this);

            // Just append the dialog to the root.
            $('body').append(this.$el);

            this.$el.dialog(_.extend({
                title    : this.title,
                close    : this.close,
                fluid    : true,
                modal    : true,
                width    : '500',
                height   : 'auto',
                draggable: false,
                resizable: false,
            }, this.dialogOptions()));

            return this;
        },

        remove: function() {
            // Destroy the dialog instance.
            this.$el.dialog('destroy');

            // Remove the element from the DOM.
            Backbone.View.prototype.remove.apply(this, arguments);
        },

        close: function() {
            this.remove();
        },

        dialogOpen: function() {
            this.$el.dialog('open');
        },

        dialogClose: function() {
            this.$el.dialog('close');
        },

        dialogOptions: function() {
            return {};
        },
    });

}(jQuery, this));