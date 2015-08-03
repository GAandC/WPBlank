<?php
    if(!WP_DEBUG) return;

    $required_plugins = array(
        "better-wp-security/better-wp-security.php" => "iThemes Security",
        "wordpress-seo/wp-seo.php" => "Yoast SEO"
    );

    function my_admin_notice()
    {
        global $required_plugins;
        $ps = [];
        foreach($required_plugins as $p=>$name)
        {
            if(!is_plugin_active($p))
            {
                $ps[] = $name;
            }
        }
        if(count($ps)>0)
        {
        ?>
        <div class="error">
            <p>Attention ! Vous devez installer les plugins suivant : <strong><?php echo implode(', ',$ps) ?></strong>.</p>
        </div>
        <?php
        }
    }
    add_action( 'admin_notices', 'my_admin_notice' );