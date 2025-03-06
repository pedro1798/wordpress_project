<?php
if (!class_exists('PADMA_DARK_WELCOME')) :

    class PADMA_DARK_WELCOME {

        public $theme_name = ''; // For storing Theme Name
        public $theme_version = ''; // For Storing Theme Current Version Information

        /**
         * Constructor for the Welcome Screen
         */

        public function __construct() {

            /** Useful Variables */
            $theme = wp_get_theme();
            $this->theme_name = $theme->Name;
            $this->theme_version = $theme->Version;

            /* Enqueue Styles & Scripts for Welcome Page */
            add_action('admin_enqueue_scripts', array($this, 'welcome_styles_and_scripts'));

            /* Hide Notice */
            add_filter('wp_loaded', array($this, 'hide_admin_notice'), 10);

            /* Create a Welcome Page */
            add_action('wp_loaded', array($this, 'admin_notice'), 20);

            add_action('after_switch_theme', array($this, 'erase_hide_notice'));

        }

        /** Trigger Welcome Message Notification */
        public function admin_notice() {
            $hide_notice = get_option('padma_hide_notice4');
            if (!$hide_notice) {
                add_action('admin_notices', array($this, 'admin_notice_content'));
            }
        }

        /** Welcome Message Notification */
        public function admin_notice_content() {
            $screen = get_current_screen();

            if ('appearance_page_padma-welcome' === $screen->id || (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) || 'theme-install' === $screen->id) {
                return;
            }

            ?>
            <div class="updated notice padma-welcome-notice">
                <div class="padma-welcome-notice-wrap">
                    <h2><?php esc_html_e('Congratulations!', 'padma'); ?></h2>
                    <p><?php printf(esc_html__('%1$s is now installed and ready to use. You can create your dream website by using padma theme. Now you are using free version of Padma Theme. If you want a Bootstrap based create with Elementor Modern, Creative, Personal, Portfolio, Secure, Beautiful, Resume / CV, SEO friendly, Full functional Premium WordPress Blog or Protfolio Theme for your site. Build Your Dream Website With Pro Version of Padma Theme.', 'padma'), $this->theme_name); ?></p>

                    <div class="padma-welcome-info">
                        <div class="padma-welcome-import">
                            <p><a class="button button-primary" target="_blank" href="<?php echo esc_url( __( 'http://wpashathemes.com/padma-dark/', 'padma' ) ); ?>"><?php esc_html_e( 'View Demo', 'padma' ); ?></a></p>
                        </div>
                        <div class="padma-welcome-getting-started">
                            <p><a href="<?php echo esc_url( __( 'https://ashathemes.com/index.php/cart/?add-to-cart=326', 'padma' ) ); ?>" class="button button-primary"><?php esc_html_e('Buy Pro', 'padma'); ?></a></p>
                        </div>
                    </div>

                    <a href="<?php echo wp_nonce_url(add_query_arg('padma_hide_notice4', 1), 'padma_hide_notice4_nonce', 'padma_notice_panel'); ?>" class="notice-close"><?php esc_html_e('Dismiss', 'padma'); ?></a>
                </div>

            </div>
            <?php
        }

        /** Hide Admin Notice */
        public function hide_admin_notice() {
            if (isset($_GET['padma_hide_notice4']) && isset($_GET['padma_notice_panel']) && current_user_can('manage_options')) {
                if (!wp_verify_nonce(wp_unslash($_GET['padma_notice_panel']), 'padma_hide_notice4_nonce')) {
                    wp_die(esc_html__('Action Failed. Something is Wrong.', 'padma'));
                }

                update_option('padma_hide_notice4', true);
            }
        }
        /** Enqueue Necessary Styles and Scripts for the Welcome Page */
        public function welcome_styles_and_scripts($hook) {
            if ('theme-install.php' !== $hook) {
                wp_enqueue_style('padma-welcome', get_template_directory_uri() . '/welcome/css/welcome.css', array(), $this->theme_version);
            }
        }

        public function erase_hide_notice() {
            delete_option('padma_hide_notice4');
        }
    }

    new PADMA_DARK_WELCOME();
    
endif;