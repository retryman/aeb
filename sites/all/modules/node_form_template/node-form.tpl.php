<?php
// $Id: node-form.tpl.php,v 1.1.2.1 2009/03/17 22:51:37 effulgentsia Exp $

/**
 * @file node-form.tpl.php
 *
 * Theme implementation to display a node editing form.
 * 
 * You can copy this file to your theme's folder, and modify it in order to
 * customize all node editing forms. In that same folder, you can also
 * create a node-form-TYPE.tpl.php, where TYPE is the node type (e.g., story).
 * This lets you customize the node editing form in a different way for a specific
 * content type.
 *
 * Primary variables:
 * - $author: The rendered field for assigning the author of the node
 * - $options: The rendered field for assigning administrative options on the 
 *   node, such as whether it's published or not.
 * - $buttons: The rendered buttons (save, preview, delete).
 * - $title: The rendered field for entering the node's title.
 * - $XXXX, $YYYY, ...: The rendered output for each top-level field or fieldset.
 *   These depend on the node type and installed modules. For example, if the CCK
 *   module is being used, and a field 'field_xyz' is part of the node being edited,
 *   then the variable $field_xyz would contain the html code for entering data into
 *   that field.
 * - $form_ids: HTML code needed for the internal functioning of the form. If not 
 *   outputting $standard (see notes below), then this variable needs to be output,
 *   or else the form won't function correctly.
 * 
 * Combination variables:
 * - $standard: Combines $form_ids, $title, and node-type and module-specific 
 *   entry fields. Essentially, everything on the form except the author field,
 *   the options field, and the buttons.
 * - $admin: Combines $author and $options (see note about this variable below).
 * 
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $form: The FormsAPI array defining this form. Contains data that may not be safe.
 * - $form['#rendered_content_children']: (see note about this variable below).
 * 
 * Note about the $admin variable:
 * The $admin variable combines the author and options fields.
 * Depending on your theming needs, you can either output
 *      <?php print $admin; ?>
 * OR
 *      <?php if (isset($author) || isset($options)) { ?>
 *        <div class="admin">
 *          <?php if (isset($author)) { ?>
 *            <div class="authored"><?php print $author; ?></div>
 *          <?php } ?>
 *          <?php if (isset($options)) { ?>
 *            <div class="options"><?php print $options; ?></div>
 *          <?php } ?>
 *        </div>
 *      <?php } ?>
 * The latter gives you more fine-grained control if you need it.
 * 
 * Note about the $standard variable:
 * The $standard variable combines the id fields needed for the form to function,
 * the title field, and the other fields that depend on node type and installed 
 * modules. Depending on your theming needs, you can either output
 *      <?php print $standard; ?>
 * OR
 *      <?php print $form_ids; ?>
 *      <?php print $title; ?>
 *      <?php print $XXXX; ?>
 *      <?php print $YYYY; ?>
 *      ...
 * The latter gives you more fine-grained control if you need it. If you use the
 * latter approach, it's essential that you output the $form_ids variable; otherwise
 * submitting the form will not work.
 * 
 * Note about the $form['#rendered_content_children'] variable:
 * The $form['#rendered_content_children'] variable is an array containing the title
 * field and the other fields that depend on node type and installed modules. Most of 
 * the time, you do not need to do anything with this variable. However, if instead of
 * outputting $standard, you decide to output each field explicitly, and if one of those
 * fields is named the same as a reserved variable (e.g., $admin), then
 * you can output it using $form['#rendered_content_children']['FIELDNAME'] (e.g., 
 * $form['#rendered_content_children']['admin']).
 */
?> 
<div class="node-form">
  <div class="standard">
    <?php print $standard; ?>
  </div>
  <?php print $admin; ?>
  <?php print $buttons; ?>
</div>
