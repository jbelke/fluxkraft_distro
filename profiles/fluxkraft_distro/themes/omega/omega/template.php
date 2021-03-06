<?php

/**
 * @file
 * Template overrides and (pre-)process hooks for the Omega base theme.
 */

require_once dirname(__FILE__) . '/includes/omega.inc';
require_once dirname(__FILE__) . '/includes/scripts.inc';

// Include the main extension file for every enabled extension.
foreach (omega_extensions() as $extension => $info) {
  if (omega_extension_enabled($extension) && ($file = $info['path'] . '/' . $extension . '.inc') && is_file($file)) {
    require_once $file;
  }
}

/**
 * Implements hook_element_info_alter().
 */
function omega_element_info_alter(&$elements) {
  $elements['scripts'] = array(
    '#items' => array(),
    '#pre_render' => array('omega_pre_render_scripts'),
    '#group_callback' => 'omega_group_js',
    '#aggregate_callback' => 'omega_aggregate_js',
  );
}

/**
 * Implements hook_css_alter().
 */
function omega_css_alter(&$css) {
  $omega = drupal_get_path('theme', 'omega');

  // The CSS_SYSTEM aggregation group doesn't make any sense. Therefore, we are
  // pre-pending it to the CSS_DEFAULT group. This has the same effect as giving
  // it a separate (low-weighted) group but also allows it to be aggregated
  // together with the rest of the CSS.
  foreach ($css as &$item) {
    if ($item['group'] == CSS_SYSTEM) {
      $item['group'] = CSS_DEFAULT;
      $item['weight'] = $item['weight'] - 100;
    }
  }

  // Clean up core and contrib module CSS.
  $overrides = array(
    'aggregator' => array(
      'aggregator.css' => array(
        'theme' => 'aggregator.theme.css',
      ),
      'aggregator-rtl.css' => array(
        'theme' => 'aggregator.theme-rtl.css',
      ),
    ),
    'block' => array(
      'block.css' => array(
        'admin' => 'block.admin.css',
        'demo' => 'block.demo.css',
      ),
    ),
    'book' => array(
      'book.css' => array(
        'theme' => 'book.theme.css',
        'admin' => 'book.admin.css',
      ),
      'book-rtl.css' => array(
        'theme' => 'book.theme-rtl.css',
      ),
    ),
    'color' => array(
      'color.css' => array(
        'admin' => 'color.admin.css',
      ),
      'color-rtl.css' => array(
        'admin' => 'color.admin-rtl.css',
      ),
    ),
    'comment' => array(
      'comment.css' => array(
        'theme' => 'comment.theme.css',
      ),
      'comment-rtl.css' => array(
        'theme' => 'comment.theme-rtl.css',
      ),
    ),
    'contextual' => array(
      'contextual.css' => array(
        'base' => 'contextual.base.css',
        'theme' => 'contextual.theme.css',
      ),
      'contextual-rtl.css' => array(
        'base' => 'contextual.base-rtl.css',
        'theme' => 'contextual.theme-rtl.css',
      ),
    ),
    'field' => array(
      'theme/field.css' => array(
        'theme' => 'field.theme.css',
      ),
      'theme/field-rtl.css' => array(
        'theme' => 'field.theme-rtl.css',
      ),
    ),
    'field_ui' => array(
      'field_ui.css' => array(
        'admin' => 'field_ui.admin.css',
      ),
      'field_ui-rtl.css' => array(
        'admin' => 'field_ui.admin-rtl.css',
      ),
    ),
    'file' => array(
      'file.css' => array(
        'theme' => 'file.theme.css',
      ),
    ),
    'filter' => array(
      'filter.css' => array(
        'theme' => 'filter.theme.css',
      ),
    ),
    'forum' => array(
      'forum.css' => array(
        'theme' => 'forum.theme.css',
      ),
      'forum-rtl.css' => array(
        'theme' => 'forum.theme-rtl.css',
      ),
    ),
    'image' => array(
      'image.css' => array(
        'theme' => 'image.theme.css',
      ),
      'image-rtl.css' => array(
        'theme' => 'image.theme-rtl.css',
      ),
      'image.admin.css' => array(
        'admin' => 'image.admin.css',
      ),
    ),
    'locale' => array(
      'locale.css' => array(
        'admin' => 'locale.admin.css',
      ),
      'locale-rtl.css' => array(
        'admin' => 'locale.admin-rtl.css',
      ),
    ),
    'openid' => array(
      'openid.css' => array(
        'base' => 'openid.base.css',
        'theme' => 'openid.theme.css',
      ),
      'openid-rtl.css' => array(
        'base' => 'openid.base-rtl.css',
        'theme' => 'openid.theme-rtl.css',
      ),
    ),
    'poll' => array(
      'poll.css' => array(
        'admin' => 'poll.admin.css',
        'theme' => 'poll.theme.css',
      ),
      'poll-rtl.css' => array(
        'theme' => 'poll.theme-rtl.css',
      ),
    ),
    'search' => array(
      'search.css' => array(
        'theme' => 'search.theme.css',
      ),
      'search-rtl.css' => array(
        'theme' => 'search.theme-rtl.css',
      ),
    ),
    'system' => array(
      'system.base.css' => array(
        'base' => 'system.base.css',
      ),
      'system.base-rtl.css' => array(
        'base' => 'system.base-rtl.css',
      ),
      'system.theme.css' => array(
        'theme' => 'system.theme.css',
      ),
      'system.theme-rtl.css' => array(
        'theme' => 'system.theme-rtl.css',
      ),
      'system.admin.css' => array(
        'admin' => 'system.admin.css',
      ),
      'system.admin-rtl.css' => array(
        'admin' => 'system.admin-rtl.css',
      ),
      'system.menus.css' => array(
        'theme' => 'system.menus.theme.css',
      ),
      'system.menus-rtl.css' => array(
        'theme' => 'system.menus.theme-rtl.css',
      ),
      'system.messages.css' => array(
        'theme' => 'system.messages.theme.css',
      ),
      'system.messages-rtl.css' => array(
        'theme' => 'system.messages.theme-rtl.css',
      ),
    ),
    'taxonomy' => array(
      'taxonomy.css' => array(
        'admin' => 'taxonomy.admin.css',
      ),
    ),
    'user' => array(
      'user.css' => array(
        'base' => 'user.base.css',
        'admin' => 'user.admin.css',
        'theme' => 'user.theme.css',
      ),
      'user-rtl.css' => array(
        'admin' => 'user.admin-rtl.css',
        'theme' => 'user.theme-rtl.css',
      ),
    ),
  );

  // Check if we are on an admin page. Otherwise, we can skip admin CSS.
  $path = current_path();
  $types = path_is_admin($path) ? array('base', 'theme', 'admin') : array('base', 'theme');
  // Add a special case for the block demo page.
  $types = strpos($path, 'admin/structure/block/demo') === 0 ? array_merge($types, array('demo')) : $types;

  // Override module provided CSS with clean and modern alternatives provided
  // by Omega.
  foreach ($overrides as $module => $files) {
    // We gathered the CSS files with paths relative to the providing module.
    $path = drupal_get_path('module', $module);

    foreach ($files as $file => $items) {
      if (isset($css[$path . '/' . $file])) {
        // Keep a copy of the original file array so we can merge that with our
        // overrides in order to keep the 'weight' and 'group' declarations.
        $original = $css[$path . '/' . $file];
        unset($css[$path . '/' . $file]);

        // Omega 4.x tries to follow the pattern described in
        // http://drupal.org/node/1089868 for declaring CSS files. Therefore, it
        // may take more than a single file to override a .css file added by
        // core. This gives us better granularity when overriding .css files
        // in a sub-theme.
        foreach ($types as $type) {
          if (isset($items[$type])) {
            $css[$omega . '/css/modules/' . $module . '/' . $items[$type]] = array(
              'data' => $omega . '/css/modules/' . $module . '/' . $items[$type],
            ) + $original;
          }
        }
      }
    }
  }

  // Exclude CSS files as declared in the theme settings.
  if (omega_extension_enabled('assets') && $regex = omega_theme_get_setting('omega_css_exclude_regex')) {
    // Make sure that RTL styles are excluded as well when a file name has been
    // specified with it's full .css file extension.
    $regex = preg_replace('/\\\.css$/', '(\.css|-rtl\.css)', $regex);
    omega_exclude_assets($css, $regex);
  }

  // Allow themes to specify no-query fallback CSS files.
  $mapping = omega_generate_asset_mapping($css);
  foreach (preg_grep('/\.no-query(-rtl)?\.css$/', $mapping) as $key => $fallback) {
    // Don't modify browser settings if they have already been modified.
    if ($css[$key]['browsers']['IE'] === TRUE && $css[$key]['browsers']['!IE'] === TRUE) {
      $css[$key]['browsers'] = array(
        '!IE' => FALSE,
        'IE' => 'lte IE 8',
      );

      // Make sure that we don't break any CSS aggregation groups.
      $css[$key]['weight'] += 100;
    }
  }
}

/**
 * Implements hook_js_alter().
 */
function omega_js_alter(&$js) {
  // If the AJAX.js isn't included... we don't need the ajaxPageState settings!
  if (!isset($js['misc/ajax.js']) && isset($js['settings']['data'])) {
    foreach ($js['settings']['data'] as $delta => $setting) {
      if (array_key_exists('ajaxPageState', $setting)) {
        if (count($setting) == 1) {
          unset($js['settings']['data'][$delta]);
        }
        else {
          unset($js['settings']['data'][$delta]['ajaxPageState']);
        }
      }
    }
  }

  if (!omega_extension_enabled('assets')) {
    return;
  }

  if ($regex = omega_theme_get_setting('omega_js_exclude_regex')) {
    omega_exclude_assets($js, $regex);
  }

  // Move the specified JavaScript files to the footer.
  if (($footer = omega_theme_get_setting('omega_js_footer')) && is_array($footer)) {
    $regex = omega_generate_path_regex($footer);
    $mapping = omega_generate_asset_mapping($js);

    foreach (preg_grep($regex, $mapping) as $key => $match) {
      $js[$key]['scope'] = 'footer';
    }
  }
}

/**
 * Implements hook_form_alter().
 */
function omega_form_alter(&$form, &$form_state, $form_id) {
  // Duplicate the form ID as a class so we can reduce specificity in our CSS.
  $form['#attributes']['class'][] = drupal_clean_css_identifier($form['#id']);
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function omega_form_field_ui_display_overview_form_alter(&$form, &$form_state, $form_id) {
  // Add a class to use as a styling hook, instead of the ID attribute.
  $form['fields']['#attributes']['class'][] = 'field-display-overview';
}

/**
 * Implements hook_theme().
 */
function omega_theme() {
  $info['omega_chrome'] = array(
    'render element' => 'element',
  );

  $info['omega_layout'] = array(
    'base hook' => 'page',
  );

  $info = array_merge($info, _omega_theme_layouts());

  return $info;
}

/**
 * Helper function for registering theme hooks for Omega layouts.
 */
function _omega_theme_layouts() {
  $info = array();

  foreach (omega_layouts_info() as $layout) {
    $hook = str_replace('-', '_', $layout['template']);
    $info[$hook] = array(
      'template' => $layout['template'],
      'path' => $layout['path'],
    );
  }

  return $info;
}

/**
 * Implements hook_theme_registry_alter().
 */
function omega_theme_registry_alter(&$registry) {
  require_once dirname(__FILE__) . '/includes/registry.inc';

  // Fix for integration with the theme developer module.
  if (module_exists('devel_themer')) {
    foreach ($registry as $hook => $data) {
      if (isset($data['original'])) {
        $registry[$hook] = $data['original'];
      }
    }
  }

  // For maintainability reasons, some of this code lives in a class.
  $handler = new OmegaThemeRegistryHandler($registry, $GLOBALS['theme']);

  // Allows themers to split preprocess / process / theme code across separate
  // files to keep the main template.php file clean. This is really fast because
  // it uses the theme registry to cache the paths to the files that it finds.
  $trail = omega_theme_trail($GLOBALS['theme']);
  foreach ($trail as $theme => $name) {
    $handler->registerHooks($theme);
    $handler->registerThemeFunctions($theme, $trail);
  }

  // Override the default 'template_process_html' hook implementation.
  $handler->overrideHook('html', 'template_process_html', 'omega_template_process_html_override');

  // We prefer the attributes array instead of the plain classes array used by
  // many core and contrib modules. In Drupal 8, we are going to convert all
  // occurrences of that into an attributes object. For now, we simply
  // synchronize our attributes array with the classes array to encourage
  // themers to use it.
  foreach ($registry as $hook => $item) {
    if (empty($item['base hook']) && empty($item['function'])) {
      if (($index = array_search('template_preprocess', $registry[$hook]['preprocess functions'], TRUE)) !== FALSE) {
        // Make sure that omega_initialize_attributes() is invoked first.
        array_unshift($registry[$hook]['process functions'], 'omega_cleanup_attributes');
        // Add omega_cleanup_attributes() right after template_preprocess().
        array_splice($registry[$hook]['preprocess functions'], $index + 1, 0, 'omega_initialize_attributes');
      }
    }
  }

  // Allow extensions to register hooks in the theme registry.
  foreach (omega_extensions() as $extension => $info) {
    // Invoke the according hooks for every enabled extension.
    if (omega_extension_enabled($extension)) {
      // Give every enabled extension a chance to alter the theme registry.
      $hook = $info['theme'] . '_extension_' . $extension . '_theme_registry_alter';

      if (function_exists($hook)) {
        $hook($registry);
      }
    }
  }

  // Fix for integration with the theme developer module.
  if (module_exists('devel_themer') && function_exists('devel_themer_theme_registry_alter')) {
    devel_themer_theme_registry_alter($registry);
  }
}

/**
 * Initializes the attributes array from the classes array.
 */
function omega_initialize_attributes(&$variables) {
  $variables['attributes_array']['class'] = &$variables['classes_array'];
}

/**
 * Processes the attributes and classes array.
 */
function omega_cleanup_attributes(&$variables, $hook) {
  // Break the reference between the classes array and the attributes array.
  $classes = !empty($variables['classes_array']) ? $variables['classes_array'] : array();
  unset($variables['attributes_array']['class'], $variables['classes_array']);

  // Clone the attributes array classes into the classes array for backwards
  // compatibility reasons. Note that we do not recommend using the classes in
  // classes array anyways.
  $variables['classes_array'] = $classes;

  if (!empty($classes)) {
    // Only write the 'class' attribute if it's not empty.
    $variables['attributes_array']['class'] = $classes;
  }
}

/**
 * Overrides template_process_html().
 */
function omega_template_process_html_override(&$variables) {
  // Render page_top and page_bottom into top level variables.
  $variables['page_top'] = drupal_render($variables['page']['page_top']);
  $variables['page_bottom'] = drupal_render($variables['page']['page_bottom']);
  // Place the rendered HTML for the page body into a top level variable.
  $variables['page'] = $variables['page']['#children'];
  $variables['page_bottom'] .= omega_get_js('footer');

  $variables['head'] = drupal_get_html_head();
  $variables['css'] = drupal_add_css();
  $variables['styles']  = drupal_get_css();
  $variables['scripts'] = omega_get_js();
}

/**
 * Implements hook_block_list_alter().
 */
function omega_block_list_alter(&$blocks) {
  if (omega_extension_enabled('layouts') && $layout = omega_layout()) {
    $callers = debug_backtrace();

    // Check if drupal_alter() was invoked from _block_load_blocks(). This is
    // required as we do not want to interfere with contrib modules like ctools.
    if ($callers['2']['function'] === '_block_load_blocks') {
      // In case we are currently serving a Omega layout we have to make sure that
      // we don't process blocks that will never be shown because the active layout
      // does not even have a region for them.
      foreach ($blocks as $id => $block) {
        if (!array_key_exists($block->region, $layout['info']['regions'])) {
          unset($blocks[$id]);
        }
      }
    }
  }

  // Hide the main content block on the front page if the theme settings are
  // configured that way.
  if (!omega_theme_get_setting('omega_toggle_front_page_content', TRUE) && drupal_is_front_page()) {
    foreach ($blocks as $key => $block) {
      if ($block->module == 'system' && $block->delta == 'main') {
        unset($blocks[$key]);
      }
    }

    drupal_set_page_content();
  }
}

/**
 * Implements hook_page_delivery_callback_alter().
 */
function omega_page_delivery_callback_alter(&$callback) {
  if (module_exists('overlay') && overlay_display_empty_page()) {
    $callback = 'omega_override_overlay_deliver_empty_page';
  }
}

/**
 * Delivery callback to display an empty page.
 *
 * This function is used to print out a bare minimum empty page which still has
 * the scripts and styles necessary in order to trigger the overlay to close.
 */
function omega_override_overlay_deliver_empty_page() {
  $empty_page = '<html><head><title></title>' . drupal_get_css() . omega_get_js() . '</head><body class="overlay"></body></html>';
  print $empty_page;
  drupal_exit();
}

/**
 * Implements hook_page_alter().
 */
function omega_page_alter(&$page) {
  // Place dummy blocks in each region if the 'demo regions' setting is active
  // to force regions to be rendered.
  if (omega_extension_enabled('development') && omega_theme_get_setting ('omega_demo_regions', TRUE) && user_access('administer site configuration')) {
    $item = menu_get_item();

    // Don't interfere with the 'Demonstrate block regions' page.
    if (strpos('admin/structure/block/demo/', $item['path']) !== 0) {
      $regions = system_region_list($GLOBALS['theme_key'], REGIONS_VISIBLE);
      $configured = omega_theme_get_setting('omega_demo_regions_list', array_keys($regions));

      // We don't explicitly load possible layout regions and instead really
      // just show demo regions for those regions that we can actually place
      // blocks in. Hence, there will only be demo regions for those regions
      // that have been declared through the theme's .info file.
      foreach (array_intersect_key($regions, array_flip($configured)) as $region => $name) {
        if (empty($page[$region])) {
          $page[$region]['#theme_wrappers'] = array('region');
          $page[$region]['#region'] = $region;
        }

        $page[$region]['#name'] = $name;
        $page[$region]['#debug'] = TRUE;
      }
    }
  }

  if (omega_extension_enabled('compatibility') && omega_theme_get_setting('omega_chrome_edge', TRUE) && omega_theme_get_setting('omega_chrome_notice', TRUE)) {
    $supported = omega_theme_get_setting('omega_internet_explorer_support', FALSE);

    $page['page_top']['omega_chrome'] = array(
      '#theme' => 'omega_chrome',
      '#pre_render' => array('drupal_pre_render_conditional_comments'),
      '#browsers' => array(
        'IE' => !$supported ? TRUE : 'lte IE ' . $supported,
        '!IE' => FALSE,
      ),
    );
  }
}

/**
 * Implements hook_html_head_alter().
 */
function omega_html_head_alter(&$head) {
  // Simplify the meta tag for character encoding.
  $head['system_meta_content_type']['#attributes'] = array('charset' => str_replace('text/html; charset=', '', $head['system_meta_content_type']['#attributes']['content']));
}

/**
 * Implements hook_omega_theme_libraries_info().
 */
function omega_omega_theme_libraries_info($theme) {
  $libraries['selectivizr'] = array(
    'name' => t('Selectivizr'),
    'description' => t('Selectivizr is a JavaScript utility that emulates CSS3 pseudo-classes and attribute selectors in Internet Explorer 6-8. Simply include the script in your pages and selectivizr will do the rest.'),
    'vendor' => 'Keith Clark',
    'vendor url' => 'http://selectivizr.com/',
    'package' => t('Polyfills'),
    'files' => array(
      'js' => array(
        omega_theme_trail_file('libraries/selectivizr/selectivizr.min.js') => array(
          'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
          'weight' => 110,
          'every_page' => TRUE,
        ),
      ),
    ),
    'variants' => array(
      'source' => array(
        'name' => t('Source'),
        'description' => t('During development it might be useful to include the source files instead of the minified version.'),
        'files' => array(
          'js' => array(
            omega_theme_trail_file('libraries/selectivizr/selectivizr.js') => array(
              'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
              'weight' => 110,
              'every_page' => TRUE,
            ),
          ),
        ),
      ),
    ),
  );

  $libraries['respond'] = array(
    'name' => t('Respond'),
    'description' => t('Respond is a fast & lightweight polyfill for min/max-width CSS3 Media Queries (for IE 6-8, and more). Note: This library requires <a href="!url">CSS aggregation</a> to be enabled for it to work properly.', array('!url' => url('admin/config/development/performance', array('alias' => TRUE)))),
    'vendor' => 'Scott Jehl',
    'vendor url' => 'http://scottjehl.com/',
    'package' => t('Polyfills'),
    'callbacks' => array('omega_extension_library_requirements_css_aggregation'),
    'files' => array(
      'js' => array(
        omega_theme_trail_file('libraries/respond/respond.min.js') => array(
          'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
          'weight' => 120,
          'every_page' => TRUE,
        ),
      ),
    ),
    'variants' => array(
      'source' => array(
        'name' => t('Source'),
        'description' => t('During development it might be useful to include the source files instead of the minified version.'),
        'files' => array(
          'js' => array(
            omega_theme_trail_file('libraries/respond/respond.js') => array(
              'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
              'weight' => 120,
              'every_page' => TRUE,
            ),
          ),
        ),
      ),
    ),
  );

  $libraries['css3pie'] = array(
    'name' => t('CSS3 PIE'),
    'description' => t('PIE makes Internet Explorer 6-9 capable of rendering several of the most useful CSS3 decoration features.'),
    'vendor' => 'Keith Clark',
    'vendor url' => 'http://css3pie.com/',
    'options form' => 'omega_library_pie_options_form',
    'package' => t('Polyfills'),
    'files' => array(),
    'variants' => array(
      'js' => array(
        'name' => t('JavaScript'),
        'description' => t('While the .htc behavior is still the recommended approach for most users, the JS version has some advantages that may be a better fit for some users.'),
        'files' => array(
          'js' => array(
            omega_theme_trail_file('libraries/pie/PIE.js') => array(
              'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
              'weight' => 100,
              'every_page' => TRUE,
            ),
          ),
        ),
      ),
    ),
  );

  $settings = omega_theme_get_setting('omega_libraries');
  if (!empty($settings['css3pie']['selectors'])) {
    // Add the generated .css file to the corresponding variant.
    $destination = file_create_url('public://omega/' . $theme );
    $destination = substr($destination, strlen($GLOBALS['base_url']) + 1);
    file_prepare_directory($destination, FILE_CREATE_DIRECTORY);

    // Save the generated CSS in the public file system.
    $file = $destination . '/pie-selectors.css';
    $htc = base_path() . omega_theme_trail_file('libraries/pie/PIE.htc');
    $contents = implode(",", $settings['css3pie']['selectors']) . "{behavior:url($htc)}";
    file_unmanaged_save_data($contents, $file, FILE_EXISTS_REPLACE);

    $libraries['css3pie']['files']['css'][$file] = array(
      'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
      'weight' => 100,
      'every_page' => TRUE,
    );

    // Save the generated JS in the public file system.
    $file = $destination . '/pie-selectors.js';
    $contents = '$(function(){Drupal.behaviors.css3pie={attach:function(context,settings){if(window.PIE){$("' . implode(",", $settings['css3pie']['selectors']) . '").each(function(){PIE.attach(this)})}}}})(jQuery);';
    file_unmanaged_save_data($contents, $file, FILE_EXISTS_REPLACE);

    $libraries['css3pie']['variants']['js']['files']['js'][$file] = array(
      'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
      'weight' => 100,
      'every_page' => TRUE,
    );
  }

  $libraries['html5shiv'] = array(
    'name' => t('HTML5 Shiv'),
    'description' => t('This script is the defacto way to enable use of HTML5 sectioning elements in legacy Internet Explorer, as well as default HTML5 styling in Internet Explorer 6 - 9, Safari 4.x (and iPhone 3.x), and Firefox 3.x.'),
    'vendor' => 'Alexander Farkas',
    'package' => t('Polyfills'),
    'files' => array(
      'js' => array(
        omega_theme_trail_file('libraries/html5shiv/html5shiv.js') => array(
          'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
          'weight' => 100,
          'every_page' => TRUE,
        ),
        omega_theme_trail_file('libraries/html5shiv/html5shiv-printshiv.js') => array(
          'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
          'weight' => 100,
          'every_page' => TRUE,
        ),
      ),
    ),
    'variants' => array(
      'source' => array(
        'name' => t('Source'),
        'description' => t('During development it might be useful to include the source files instead of the minified version.'),
        'files' => array(
          'js' => array(
            omega_theme_trail_file('libraries/html5shiv/html5shiv.min.js') => array(
              'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
              'weight' => 100,
              'every_page' => TRUE,
            ),
            omega_theme_trail_file('libraries/html5shiv/html5shiv-printshiv.min.js') => array(
              'browsers' => array('IE' => '(gte IE 6)&(lte IE 8)', '!IE' => FALSE),
              'weight' => 100,
              'every_page' => TRUE,
            ),
          ),
        ),
      ),
    ),
  );

  $libraries['messages'] = array(
    'name' => t('Discardable messages'),
    'description' => t("Adds a 'close' button to each message."),
    'package' => t('Goodies'),
    'files' => array(
      'js' => array(
        omega_theme_trail_file('js/omega.messages.min.js') => array(
          'weight' => -100,
          'every_page' => TRUE,
        ),
      ),
      'css' => array(
        omega_theme_trail_file('css/omega.messages.css') => array(
          'weight' => -100,
          'every_page' => TRUE,
        ),
      ),
    ),
  );

  return $libraries;
}

/**
 * Theme callback for rendering an Omega layout.
 */
function omega_omega_layout($variables) {
  drupal_process_attached(array('#attached' => $variables['omega_layout']['attached']));

  // Clean up the theme hook suggestion so we don't end up in an infinite loop.
  unset($variables['theme_hook_suggestion'], $variables['theme_hook_suggestions']);
  $hook = str_replace('-', '_', $variables['omega_layout']['template']);
  return theme($hook, $variables);
}

/**
 * Shows a notice when Google Chrome Frame is not installed.
 */
function omega_omega_chrome($variables) {
  $message = t('You are using an outdated browser! <a href="!upgrade">Upgrade your browser today</a> or <a href="!install">install Google Chrome Frame</a> to better experience this site.', array(
    '!upgrade' => url('http://browsehappy.com'),
    '!install' => url('http://www.google.com/chromeframe', array(
      'query' => array('redirect' => 'true')
    )),
  ));

  return '<p class="chromeframe">' . $message . '</p>';
}
