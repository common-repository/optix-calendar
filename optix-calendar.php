<?php
/*
Plugin Name: Optix calendar
Plugin URI: https://optix.cloud/integrazioni/
Description: Integra il calendario di Optix nel tuo sito web per permettere ai tuoi clienti di prenotare appuntamenti in pochi click.
Version: 24.09.47
Author: Optix
Author URI: https://optix.cloud/
Requires at least: 4.0
Tested up to: 6.6.2
Stable tag: 24.09.47
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://optix.cloud/terms/
Text Domain: optix-calendar
*/

// IMPORTA JS E CSS
add_action('wp_enqueue_scripts', 'optix_calendar_import_scripts');

// CREA LA VOCE DEL MENŮ IN IMPOSTAZIONI
add_action('admin_menu', 'optix_calendar_menu');

// ABILITA IL SALVATAGGIO DELLE IMPOSTAZIONI
add_action('admin_init', 'optix_calendar_update_settings');

// CREA LO SHORTCODE
add_shortcode('optix-calendar', 'optix_calendar_shortcode');

// IMPORTA JS E CSS
function optix_calendar_import_scripts()
{
    wp_enqueue_script('optix-calendar', 'https://calendar.optix.cloud/optix-calendar.js', array() , null, true);
}

// CREA LA VOCE DEL MENŮ IN IMPOSTAZIONI
function optix_calendar_menu()
{
    $parent_slug = 'options-general.php';
    $page_title = 'Optix calendar impostazioni';
    $menu_title = 'Optix calendar';
    $capability = 'manage_options';
    $menu_slug = 'optix-calendar';
    $function = 'optix_calendar_settings_page'; // CONTENUTO DELLA PAGINA
    $icon_url = 'dashicons-calendar-alt';
    add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function, null);
}

// CONTENUTO DELLA PAGINA IMPOSTAZIONI
function optix_calendar_settings_page()
{ ?>
     <h1>Optix calendar impostazioni</h1>
     <p>Inserisci la tua Api-key (la trovi nel tuo account Optix, nel moduli di integrazione).</p>
	<form method="post" action="options.php">
     <?php settings_fields('optix_calendar_info_settings'); ?>
     <?php do_settings_sections('optix_calendar_info_settings'); ?>
     <table class="form-table">
     <tr>
       <th scope="row">Api-key:</th>
       <td>
       <textarea style="width:100%;max-width:500px;min-height:150px" type="text" name="optix_calendar_apikey" value="<?php echo get_option('optix_calendar_apikey'); ?>"><?php echo get_option('optix_calendar_apikey'); ?>				</textarea>
       </td>
     </tr>


     <tr>
       <th scope="row"></th>
       <td>
       Per poter utilizzare questo plugin devi avere un account Optix. Non ce l&lsquo;hai ancora? Registrati gratuitamente <a href="https://optix.cloud/">qui</a>.
       </td>
     </tr>
   </table>
   <?php submit_button(); ?>
 </form>
    <?php
}

// ABILITA IL SALVATAGGIO DELLE IMPOSTAZIONI
function optix_calendar_update_settings()
{
    register_setting('optix_calendar_info_settings', 'optix_calendar_apikey');
}

// SHORTCODE
function optix_calendar_shortcode($atts)
{
    // Imposta i valori predefiniti degli attributi
    $atts = shortcode_atts(
        array(
            'storeid' => '1', // valore predefinito
        ), 
        $atts, 
        'optix-calendar'
    );

    $api = esc_attr(get_option('optix_calendar_apikey'));
    $store_id = esc_attr($atts['storeid']);

    return '<optix-calendar apikey="' . $api . '" storeid="' . $store_id . '"></optix-calendar>';
}
?>