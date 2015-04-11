<div id="ajulMetaboxDestinations">
    <div id="ajulMetaboxHeader">
        <button type="button" id="destinationCreate"><?php _e('Add Destination', AJUL_I18N); ?></button>
    </div>

    <div id="ajulMetaboxContent">
        <p><?php _e('There are currently now destinations for this tour.', AJUL_I18N); ?></p>
    </div>
</div>

<!--
==================================================
UNDERSCORE TEMPLATES
==================================================
-->
<script type="text/template" id="ajulDestinationFormTemplate">
    <form>
        <div class="field">
            <label for="target">Element ID</label>
            <input type="text" id="target" name="target" class="text ui-widget-content ui-corner-all">
        </div>
        <div class="field">
            <label for="prev">Previous Page</label>
            <input type="text" id="prev" name="prev" class="text ui-widget-content ui-corner-all">
        </div>
        <div class="field">
            <label for="next">Next Page</label>
            <input type="text" id="next" name="next" class="text ui-widget-content ui-corner-all">
        </div>

        <!-- Allow form submission with keyboard without duplicating the dialog button -->
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</script>