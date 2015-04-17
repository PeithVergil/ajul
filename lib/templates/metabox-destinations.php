<?php
// Prevent direct access.
if (!defined('ABSPATH'))
    exit;
?>
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
    <header>
        <h3><%= title %></h3>

        <ul class="links">
            <li>
                <a class="edit" href="javascript:;"><?php _e('edit', AJUL_I18N); ?></a>
            </li>
            <li>
                <a class="delete" href="javascript:;"><?php _e('delete', AJUL_I18N); ?></a>
            </li>
        </ul>
    </header>
    <div class="content">
        <%= content %>
    </div>
    <div class="page">
        <?php _e('Target', AJUL_I18N); ?>: <%= target %>
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
        <div class="field">
            <label for="target">Element ID</label>
            <input type="text" id="target" name="target" class="text ui-widget-content ui-corner-all">
            <p class="help">
                <?php _e('Target a specific element on the page by providing the element\'s ID.', AJUL_I18N); ?>
            </p>
        </div>
        <div class="field">
            <label for="placement">Placement</label>
            <select id="placement" name="placement">
                <option value="top"><?php _e('Top', AJUL_I18N); ?></option>
                <option value="left"><?php _e('Left', AJUL_I18N); ?></option>
                <option value="right"><?php _e('Right', AJUL_I18N); ?></option>
                <option value="bottom"><?php _e('Bottom', AJUL_I18N); ?></option>
            </select>
            <p class="help">
                <?php _e('Select the placement of the content.', AJUL_I18N); ?>
            </p>
        </div>

        <!-- Allow form submission by pressing the ENTER key. -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</script>

<script type="text/template" id="ajulDestinationDeleteTemplate">
    <h3><%= title %></h3>
    <p><%= content %></p>
</script>