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
        <h3><%= data.title %></h3>

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
        <%= data.content %>
    </div>
    <div class="page">
        <?php _e('Target', AJUL_I18N); ?>: <%= data.target %>
    </div>
</script>

<script type="text/template" id="ajulDestinationFormTemplate">
    <form>
        <div class="field">
            <label for="destTitle">Title</label>
            <input type="text" id="destTitle" name="title" <% if (data) { %>value="<%= data.title %>"<% } %> class="text ui-widget-content ui-corner-all">
        </div>
        <div class="field">
            <label for="destContent">Content</label>
            <textarea id="destContent" name="content" class="text ui-widget-content ui-corner-all"><% if (data) { %><%= data.content %><% } %></textarea>
        </div>
        <div class="field">
            <label for="destTarget">Element ID</label>
            <input type="text" id="destTarget" name="target" <% if (data) { %>value="<%= data.target %>"<% } %> class="text ui-widget-content ui-corner-all">
            <p class="help">
                <?php _e('Target a specific element on the page by providing the element\'s ID.', AJUL_I18N); ?>
            </p>
        </div>
        <div class="field">
            <label for="destPlacement">Placement</label>
            <?php

            $placements = array(
                'top' => __('Top', AJUL_I18N),
                'left' => __('Left', AJUL_I18N),
                'right' => __('Right', AJUL_I18N),
                'bottom' => __('Bottom', AJUL_I18N),
            );

            ?>
            <select id="destPlacement" name="placement">
                <?php foreach ($placements as $value => $text): ?>
                    <option value="<?php echo $value; ?>" <% if (data && data.placement === "<?php echo $value; ?>") { %>selected<% } %>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
            <p class="help">
                <?php _e('Select the placement of the content bubble.', AJUL_I18N); ?>
            </p>
        </div>

        <!-- Allow form submission by pressing the ENTER key. -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</script>

<script type="text/template" id="ajulDestinationDeleteTemplate">
    <h3><%= data.title %></h3>
    <p><%= data.content %></p>
</script>