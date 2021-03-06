
<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">

    <h1><?php _e( 'Redis Object Cache', 'redis-cache' ); ?></h1>

    <?php if ( ! defined( 'WP_REDIS_DISABLE_BANNERS' ) || ! WP_REDIS_DISABLE_BANNERS ) : ?>
        <div class="card">
            <h2 class="title">
                <?php _e( 'Redis Cache Pro', 'redis-cache' ); ?>
            </h2>
            <p>
                <?php _e( '<b>A business class object cache backend.</b> Truly reliable, highly-optimized and fully customizable, with a <u>dedicated engineer</u> when you most need it.', 'redis-cache' ); ?>
            </p>
            <ul>
                <li>Rewritten for raw performance</li>
                <li>WordPress object cache API compliant</li>
                <li>Easy debugging &amp; logging</li>
                <li>Cache analytics and preloading</li>
                <li>Fully unit tested (100% code coverage)</li>
                <li>Secure connections with TLS</li>
                <li>Health checks via WordPress, WP CLI &amp; Debug Bar</li>
                <li>Optimized for WooCommerce, Jetpack & Yoast SEO</li>
            </ul>
            <p>
                <a class="button button-primary" target="_blank" rel="noopener" href="https://wprediscache.com/?utm_source=wp-plugin&amp;utm_medium=settings">
                    <?php _e( 'Learn more', 'redis-cache' ); ?>
                </a>
            </p>
        </div>
    <?php endif; ?>

    <div class="section-overview">

        <h2 class="title"><?php _e( 'Overview', 'redis-cache' ); ?></h2>

        <table class="form-table">

            <tr>
                <th><?php _e( 'Status:', 'redis-cache' ); ?></th>
                <td><code><?php echo $this->get_status(); ?></code></td>
            </tr>

            <?php $redisClient = $this->get_redis_client_name(); ?>
            <?php $redisPrefix = $this->get_redis_cachekey_prefix(); ?>
            <?php $redisMaxTTL = $this->get_redis_maxttl(); ?>

            <?php if ( ! is_null( $redisClient ) ) : ?>
                <tr>
                    <th><?php _e( 'Client:', 'redis-cache' ); ?></th>
                    <td><code><?php echo esc_html( $redisClient ); ?></code></td>
                </tr>
            <?php endif; ?>

            <?php if ( ! is_null( $redisPrefix ) && trim( $redisPrefix ) !== '' ) : ?>
                <tr>
                    <th><?php _e( 'Key Prefix:', 'redis-cache' ); ?></th>
                    <td>
                        <code><?php echo esc_html( $redisPrefix ); ?></code>

                        <?php if ( strlen( (string) $redisPrefix ) > 20 || ! ctype_alnum( $redisPrefix ) ) : ?>
                            <p class="description" style="color: #d54e21;"><?php _e( 'Consider using a shorter, alphanumeric prefix.', 'redis-cache' ); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ( ! is_null( $redisMaxTTL ) ) : ?>
                <tr>
                    <th><?php _e( 'Max. TTL:', 'redis-cache' ); ?></th>
                    <td>
                        <code><?php echo esc_html( $redisMaxTTL ); ?></code>

                        <?php if ( ! ctype_digit( $redisMaxTTL ) !== 0 ) : ?>
                            <p class="description" style="color: #d54e21;"><?php _e( 'This doesn’t appear to be a valid number.', 'redis-cache' ); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>

        </table>

        <p class="submit">

            <?php if ( $this->get_redis_status() ) : ?>
                <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'flush-cache', $this->page ) ), 'flush-cache' ); ?>" class="button button-primary button-large"><?php _e( 'Flush Cache', 'redis-cache' ); ?></a> &nbsp;
            <?php endif; ?>

            <?php if ( ! $this->object_cache_dropin_exists() ) : ?>
                <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'enable-cache', $this->page ) ), 'enable-cache' ); ?>" class="button button-primary button-large"><?php _e( 'Enable Object Cache', 'redis-cache' ); ?></a>
            <?php elseif ( $this->validate_object_cache_dropin() ) : ?>
                <a href="<?php echo wp_nonce_url( network_admin_url( add_query_arg( 'action', 'disable-cache', $this->page ) ), 'disable-cache' ); ?>" class="button button-secondary button-large delete"><?php _e( 'Disable Object Cache', 'redis-cache' ); ?></a>
            <?php endif; ?>

        </p>

    </div>

    <br class="clearfix">

    <h2 class="title">
        <?php _e( 'Servers', 'redis-cache' ); ?>
    </h2>

    <?php $this->show_servers_list(); ?>

    <?php if ( isset( $_GET[ 'diagnostics' ] ) ) : ?>

        <h2 class="title"><?php _e( 'Diagnostics', 'redis-cache' ); ?></h2>

        <textarea class="large-text readonly" rows="20" readonly><?php include dirname( __FILE__ ) . '/diagnostics.php'; ?></textarea>

    <?php else : ?>

        <p><a href="<?php echo network_admin_url( add_query_arg( 'diagnostics', '1', $this->page ) ); ?>"><?php _e( 'Show Diagnostics', 'redis-cache' ); ?></a></p>

    <?php endif; ?>

</div>
