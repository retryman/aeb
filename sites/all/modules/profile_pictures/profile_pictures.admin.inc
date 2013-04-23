<?php
// $Id: profile_pictures.admin.inc,v 1.3 2010/05/17 09:02:09 yeputons Exp $
/**
 * @file
 *   Handlers for field edit form
 */

/**
 * Add/edit field form callback. 
 * Calls profile_field_form for default field types,
 * Or adds specific options for image fields (base field type - textfield)
 */
function profile_pictures_field_form(&$form_state, $path, $arg = NULL) {
  require_once $path;
  
  // First we need determine field type
  if ((arg(3) == 'edit') && is_numeric($arg)) {
    $fld = db_fetch_object(db_query('SELECT type FROM {profile_fields} WHERE (fid=%d)', $arg));
    $type = $fld->type;
    drupal_set_title(t('edit %title', array('%title' => $fld->title)));
  }
  else {
    $type = $arg;
    if ($type == 'picture') $arg = 'textfield';
  }
  // Call core form function to get base fields
  $form = profile_field_form($form_state, $arg);
  if ($type != 'picture') {
    drupal_alter('form', $form, $form_state, 'profile_field_form');
    return $form;
  }

  if (!is_numeric($arg)) {
    drupal_set_title(t('add new %type', array('%type' => 'picture')));
  }

  // Copy-paste from profile.module
  if (isset($form['type'])) $form['type']['#value'] = 'picture';
  unset($form['fields']['page']);

  // Adding image options (dimensions, size)
  if (is_numeric($arg)) {
    $opts = unserialize(db_result(db_query('SELECT options FROM {profile_fields} WHERE (fid=%d)', $arg)));
  }
  $form['fields']['image'] = array(
    '#type' => 'fieldset',
    '#title' => t('Image properties'),
    'image_maxsize' => array(
      '#type' => 'textfield',
      '#title' => t('Maximum size of uploaded image (in KiB, zero if none)'),
      '#default_value' => $opts['maxsize'],
      '#weight' => 0,
    ),
    'image_maxdim' => array(
      '#type' => 'textfield',
      '#prefix' => '<div class="profile_pictures_max_dims">',
      '#suffix' => '</div>',
      '#title' => t('Maximum dimensions of uploaded image (WxH, in pixels)'),
      '#default_value' => $opts['maxw'] . 'x' . $opts['maxh'],
      '#weight' => 1,
    ),
  );

  // Add ImageCache preset settings
  if (module_exists('imagecache')) {
    $presets = array();
    $presets[''] = t('--- No postprocessing ---');
    foreach (imagecache_presets() as $preset) {
      $presets[$preset['presetname']] = t($preset['presetname']);
    }

    $form['fields']['image']['image_imagecache_preset'] = array(
      '#type' => 'select',
      '#attributes' => array(
        'class' => 'profile_pictures_imagecache_preset',
      ),
      '#title' => t('ImageCache preset'),
      '#default_value' => isset($opts['imagecache_preset']) ? $opts['imagecache_preset'] : '',
      '#options' => $presets,
      '#weight' => 0.5,
    );
  }

  // Add custom path field
  if (module_exists('token')) {
    // It is either editable
    $form['fields']['image']['image_path'] = array(
      '#type' => 'textfield',
      '#title' => t('File saving path'),
      '#default_value' => isset($opts['path']) ? $opts['path'] : PROFILE_PICTURES_DEFAULT_SAVE_PATH,
      '#weight' => 3,
    );
    $form['fields']['image']['image_path_tokens'] = array(
      '#type' => 'fieldset',
      '#title' => t('Available tokens'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      'content' => array(
        '#theme' => 'profile_pictures_token_list',
      ),
      '#weight' => 4,
    );
  }
  else {
    // Or read-only
    $dest = file_check_path(variable_get('user_picture_path', 'pictures'));
    $form['fields']['image']['image_path'] = array(
      '#type' => 'textfield',
      '#title' => t('File saving path'),
      '#value' => $dest,
      '#attributes' => array('readonly' => 'readonly'),
      '#description' => t('You can change this path at !url', array(
        '!url' => l(t('User settings page'), 'admin/user/settings'),
      )),
      '#weight' => 3,
    );
  }
  drupal_alter('form', $form, $form_state, 'profile_field_form');
  return $form;
}

/**
 * Calls profile_field_form_validate and validate 'max. dimensions' field format
 * for image fields
 */
function profile_pictures_field_form_validate($form, &$form_state) {
  $type = $form['#parameters'][3];
  if (is_numeric($type)) {
    $type = db_fetch_object(db_query('SELECT type, options FROM {profile_fields} WHERE (fid=%d)', $type));
    $opts = unserialize($type->options);
    $type = $type->type;
  }

  if ($type == 'picture') {
    if (!is_array($opts)) $opts = array();
    $maxsz = $form_state['values']['image_maxsize'];
    if (!is_numeric($maxsz) || ($maxsz < 0)) {
      form_set_error('image_maxsize', t('Please, enter an non-negative number'));
    }
    else {
      $opts['maxsize'] = $maxsz;
    }

    if (isset($form['fields']['image']['image_maxdim'])) {
      if (!preg_match('/^([0-9]+)x([0-9]+)$/', $form_state['values']['image_maxdim'], $dim)
          || !is_numeric($maxw = $dim[1]) || !is_numeric($maxh = $dim[2])) {
        form_set_error('image_maxdim', t('Please, input dimensions in format WxH'));
      }
      else {
        $opts['maxw'] = $maxw;
        $opts['maxh'] = $maxh;
      }
    }

    foreach (array('imagecache_preset', 'path') as $t)
      if (isset($form['fields']['image']['image_'. $t])) {
        $opts[$t] = $form_state['values']['image_' . $t];
      }
    $form_state['values']['options'] = serialize($opts);
  }
  profile_field_form_validate($form, $form_state);
}

/**
 * Just calls profile_field_form_submit to save changes
 */
function profile_pictures_field_form_submit($form, &$form_state) {
  profile_field_form_submit($form, $form_state);
}
