<div id="ajulMetaboxDestinations">
    <div id="ajulMetaboxHeader">
        <button type="button" id="destinationCreate"><?php _e('Add Destination', AJUL_I18N); ?></button>
    </div>

    <div id="ajulMetaboxContent">
    </div>
</div>

<!--
==================================================
UNDERSCORE TEMPLATES
==================================================
-->
<script type="text/template" id="ajulDestinationEmptyTemplate">
    <p><?php _e('There are currently now destinations for this tour.', AJUL_I18N); ?></p>
</script>

<script type="text/template" id="ajulDestinationItemTemplate">
    <h3><%= title %></h3>
    <div class="content">
        <%= content %>
    </div>
    <div class="page">
        <?php _e('Page', AJUL_I18N); ?>: <%= page %>
    </div>
</script>

<script type="text/template" id="ajulDestinationFormTemplate">
    <form>
        <div class="field">
            <label for="page">Page</label>
            <select id="page" name="page" class="text ui-widget-content ui-corner-all">
                <?php foreach (get_pages() as $page): ?>
                    <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="text ui-widget-content ui-corner-all">
        </div>
        <div class="field">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="text ui-widget-content ui-corner-all"></textarea>
        </div>

        <hr />

        <div class="field">
            <label for="element">Element ID</label>
            <input type="text" id="element" name="element" class="text ui-widget-content ui-corner-all">
            <p class="help">
                <?php _e('To target a specific element on the page, provide the element\'s ID. Leave it blank if there is no target.', AJUL_I18N); ?>
            </p>
        </div>

        <!-- Allow form submission by pressing the ENTER key. -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</script>