<?php
define( "SEMALT_NAME", "Semalt Redirect Manager" );
define( "SEMALT_TAGLINE", "Redirects all Semalt traffic away from your site!" );
define( "SEMALT_URL", "http://peadig.com/wordpress-plugins/semalt/" );
define( "SEMALT_EXTEND_URL", "http://wordpress.org/extend/plugins/semalt/" );
define( "SEMALT_AUTHOR_TWITTER", "alexmoss" );
define( "SEMALT_DONATE_LINK", "https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WFVJMCGGZTDY4" );

add_action( 'admin_init', 'semalt_init' );
function semalt_init() {
    register_setting( 'semalt_options', 'semalt' );
    $new_options = array(
        'enabled' => 'on',
        'url' => 'http://google.com/',
        'domains' => 'semalt.com'. PHP_EOL .'buttons-for-websites.com',
        );
    add_option( 'semalt', $new_options );
}


add_action( 'admin_menu', 'show_semalt_options' );
function show_semalt_options() {
    add_options_page( 'Semalt Redirect Manager Options', 'Semalt Redirect Manager', 'manage_options', 'semalt', 'semalt_options' );
}


function semalt_fetch_rss_feed() {
    include_once ABSPATH . WPINC . '/feed.php';
    $rss = fetch_feed( "http://peadig.com/feed" );
    if ( is_wp_error( $rss ) ) { return false; }
    $rss_items = $rss->get_items( 0, 3 );
    return $rss_items;
}

// ADMIN PAGE
function semalt_options() {
    $domain = urlencode( home_url() );
    ?>
    <link href="<?php echo plugins_url( 'admin.css' , __FILE__ ); ?>" rel="stylesheet" type="text/css">
    <div class="pea_admin_wrap">
        <div class="pea_admin_top">
            <h1><?php echo SEMALT_NAME?> <small> - <?php echo SEMALT_TAGLINE?></small></h1>
        </div>

        <div class="pea_admin_main_wrap">
            <div class="pea_admin_main_left">
                <div class="pea_admin_signup">
                    Want to know about updates to this plugin without having to log into your site every time? Want to know about other cool plugins we've made? Add your email and we'll add you to our very rare mail outs.

                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                        <form action="http://peadig.us5.list-manage2.com/subscribe/post?u=e16b7a214b2d8a69e134e5b70&amp;id=eb50326bdf" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div class="mc-field-group">
                                <label for="mce-EMAIL">Email Address
                                </label>
                                <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" name="subscribe" id="mc-embedded-subscribe" class="pea_admin_green">Sign Up!</button>
                            </div>
                            <div id="mce-responses" class="clear">
                                <div class="response" id="mce-error-response" style="display:none"></div>
                                <div class="response" id="mce-success-response" style="display:none"></div>
                            </div>  <div class="clear"></div>
                        </form>
                    </div>

                    <!--End mc_embed_signup-->
                </div>

                <form method="post" action="options.php" id="options">
                   <?php settings_fields( 'semalt_options' );
                   $options = get_option( 'semalt' ); ?>
                   <table class="form-table">
                    <tr valign="top"><th scope="row"><label for="fbml">Enabled</label></th>
                     <td><input id="enabled" name="semalt[enabled]" type="checkbox" value="on" <?php checked( 'on', $options['enabled'] ); ?> /></td>
                 </tr>
                 <tr valign="top"><th scope="row"><label for="url">Domains to block</label></th>
                     <td>
                      <textarea rows="6" cols="50" id="domains" name="semalt[domains]"><?php echo $options['domains']; ?></textarea>
                      <p>Enter one domain per line, no need for http:// - eg <code>semalt.com</code>.</p><p>Also note that semalt.com and buttons-for-websites.com are listed above. <strong>Do not remove them</strong> from the list unless you want their crawlers to reach your site!</p>
                 </tr>
                 <tr valign="top"><th scope="row"><label for="url">URL to redirect to</label></th>
                     <td><input id="url" type="text" name="semalt[url]" value="<?php echo $options['url']; ?>" /></td>
                 </tr>
             </table>
             <p>This plugin was an idea by <a href="http://refugeeks.com/" target="_blank">Rishi Lakhani</a> and developed by <a href="http://firecask.com/" target="_blank">Alex Moss</a> and a little help from <a href="http://www.winwar.co.uk/" target="_blank">Rhys Wynne</a>. Please tweet about it!
                <br /><br /><a href="https://twitter.com/intent/tweet/update?text=I've%20just%20used%20the%20%23Semalt%20Redirect%20Manager%20to%20stop%20%23semaltspam%20from%20my%20site%3A%20http%3A%2F%2Fpeadig.com%2Fwordpress-plugins%2Fsemalt-blocker%2F%20via%20%40alexmoss%20%40rishil%20%23WordPress" class="twitter-hashtag-button" data-size="large" data-related="alexmoss">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            </p>
            <p class="submit">
               <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
           </p>
       </form>
   </div>
   <div class="pea_admin_main_right">
     <div class="pea_admin_box">

        <center><a href="http://peadig.com/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=Facebook%2BComments%2BAdmin" target="_blank"><img src="<?php echo plugins_url( 'images/peadig-landscape-300.png' , __FILE__ ); ?>" width="220" height="69" title="Peadig">
            <strong>Peadig: the WordPress framework that Integrates Bootstrap</strong></a><br /><br />
            <a href="https://twitter.com/peadig" class="twitter-follow-button">Follow @peadig</a>
            <div class="fb-like" data-href="http://www.facebook.com/peadig" data-layout="button_count" data-action="like" data-show-faces="false"></div>
            <div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/116387945649998056474" data-rel="publisher"></div>
            <br /><br /><br />


        </div>


        <center> <h2>Share the plugin love!</h2>
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));</script>
          <div class="fb-like" data-href="<?php echo SEMALT_URL; ?>" data-layout="button_count" data-show-faces="true"></div>

          <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo SEMALT_URL; ?>" data-text="Just been using <?php echo SEMALT_NAME; ?> #WordPress plugin" data-via="<?php echo SEMALT_AUTHOR_TWITTER; ?>" data-related="WPBrewers">Tweet</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

          <a href="http://bufferapp.com/add" class="buffer-add-button" data-text="Just been using <?php echo SEMALT_NAME; ?> #WordPress plugin" data-url="<?php echo SEMALT_URL; ?>" data-count="horizontal" data-via="<?php echo SEMALT_AUTHOR_TWITTER; ?>">Buffer</a><script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>
          <div class="g-plusone" data-size="medium" data-href="<?php echo SEMALT_URL; ?>"></div>
          <script type="text/javascript">
          window.___gcfg = {lang: 'en-GB'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
        </script>
        <su:badge layout="3" location="<?php echo SEMALT_URL?>"></su:badge>
        <script type="text/javascript">
        (function() {
            var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
            li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
        })();
        </script>
        <br /><br />
        <a href="<?php echo SEMALT_DONATE_LINK; ?>" target="_blank"><img class="paypal" src="<?php echo plugins_url( 'images/paypal.gif' , __FILE__ ); ?>" width="147" height="47" title="Please Donate - it helps support this plugin!"></a></center>

        <div class="pea_admin_box">
            <h2>About the Author</h2>

            <?php
            $default = "http://reviews.evanscycles.com/static/0924-en_gb/noAvatar.gif";
            $size = 70;
            $alex_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( "alex@peadig.com" ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
            ?>

            <p class="pea_admin_clear"><img class="pea_admin_fl" src="<?php echo $alex_url; ?>" alt="Alex Moss" /> <h3>Alex Moss</h3><br />Alex Moss is the Co-Founder of <a href="http://peadig.com/" target="_blank">Peadig</a>, a WordPress framework built with Bootstrap. He has also developed several WordPress plugins (which you can <a href="http://peadig.com/wordpress-plugins/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=Facebook%2BComments%2BPro%2BAdmin" target="_blank">view here</a>) totalling over 500,000 downloads.</p>
            <center><br><a href="https://twitter.com/alexmoss" class="twitter-follow-button">Follow @alexmoss</a>
                <div class="fb-subscribe" data-href="https://www.facebook.com/alexmoss1" data-layout="button_count" data-show-faces="false" data-width="220"></div>
                <div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/+AlexMoss" data-rel="author"></div>
            </div>

            <h2>More from Peadig</h2>
            <p class="pea_admin_clear">
                <?php
                $SEMALT_feed = semalt_fetch_rss_feed();
                echo '<ul>';
                foreach ( $SEMALT_feed as $item ) {
                    $url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls=null, 'display' ) );
                    echo '<li>';
                    echo '<a href="'.$url.'?utm_source='.$domain.'&utm_medium=RSS&utm_campaign=Semalt%2BAdmin" target="_blank">'. esc_html( $item->get_title() ) .'</a> ';
                    echo '</li>';
                }
                echo '</ul>';
                ?></p>


            </div>
        </div>
    </div>



    <?php
}

?>
