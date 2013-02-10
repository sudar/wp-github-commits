<?php
/**
Plugin Name: WP Github Commits
Plugin URI: http://sudarmuthu.com/wordpress/wp-github-commits
Description: Displays the latest commits of a github repo in the sidebar.
Author: Sudar
Version: 0.1
Author URI: http://sudarmuthu.com/
Text Domain: wp-github-commits

=== RELEASE NOTES ===
2013-02-11 – v0.1 – Initial Release
*/

/**
 * The main Plugin class
 *
 * @package default
 * @subpackage default
 * @author Sudar
 */
class WP_Github_Commits {

    /**
     * Initalize the plugin by registering the hooks
     */
    function __construct() {

        // Load localization domain
        load_plugin_textdomain( 'wp-github-commits', false, dirname(plugin_basename(__FILE__)) .  '/languages' );

        // Register hooks and filters
        add_filter('github-commits-title', array(&$this, 'filter_title'), 10, 3);
    }

    /**
     * filter title
     */
    function filter_title($title, $user, $repo) {
        $title = str_replace("[user]", $user, $title);
        $title = str_replace("[repo]", $repo, $title);
        return $title;
    }

    /**
     * Get the github commits of a repo
     *
     */
    public function get_github_commits($user, $repo, $count = 5) {

        $output = '';
        $counter = 0;

        if ($user == '' && $repo == '') {
            return $output;
        }

        $key = "github-commits-$user-$repo";

        if (false === ( $commits = get_transient( $key ) ) ) {
            if(!class_exists('Github_API')){
                require_once dirname(__FILE__) . '/include/class-github-api.php';
            }

            $github_api = new Github_API();
            $commits = $github_api->get_repo_commits($user, $repo);

            set_transient($key, $commits, 18000); // 60*60*1 - 5 hour
        }

        // TODO: Make it plugable
        $output = '<ul class = "github-commits">';
        foreach($commits as $commit) {
            $counter ++;
            $output .= '<li class = "github-commit">';
            $output .= "<a href = 'https://github.com/$user/$repo/commit/{$commit->sha}'>" . $commit->commit->message . '</a> ';
            $output .= __('by', 'wp-github-commits') . " <a href = 'https://github.com/{$commit->commit->author->name}'>" . $commit->commit->author->name . '</a> ';
            $output .= __('on', 'wp-github-commits') . ' ' . $commit->commit->author->date;
            $output .= '</li>';

            if ($count == $counter) {
                break;
            }
        }

        $output .= '</ul>';
        return $output;
    }
}

// Start this plugin once all other plugins are fully loaded
add_action( 'init', 'WP_Github_Commits' ); function WP_Github_Commits() { global $wp_github_commits; $wp_github_commits = new WP_Github_Commits(); }

// register WP_Github_Commits_Widget widget
add_action('widgets_init', create_function('', 'return register_widget("WP_Github_Commits_Widget");'));

/**
 * WP_Github_Commits_Widget Class
 *
 */
class WP_Github_Commits_Widget extends WP_Widget {
    /** constructor */
    function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'WP_Github_Commits_Widget', 'description' => __('Github commits for a user or repo', 'wp-github-commits'));

		/* Widget control settings. */
		$control_ops = array('id_base' => 'wp-github-commits' );

		/* Create the widget. */
		parent::__construct( 'wp-github-commits', __('WP Github Commits', 'wp-github-commits'), $widget_ops, $control_ops );
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Recent Commits', 'wp-github-commits'), 'user' => '', 'repo' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );

        $title = $instance['title'];
        $user = $instance['user'];
        $repo = $instance['repo'];
        $count = absint($instance['count']);

        $title = apply_filters('github-commits-title', $title, $user, $repo);

        echo $before_widget;
        echo $before_title;
        echo $title;
        echo $after_title;

        echo get_github_commits($user, $repo);

        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;

        // validate data
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['user'] = strip_tags($new_instance['user']);
        $instance['repo'] = strip_tags($new_instance['repo']);
        $instance['count'] = absint($new_instance['count']);

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Recent Commits', 'wp-github-commits'), 'user' => '', 'repo' => '', 'count' => 5);
		$instance = wp_parse_args( (array) $instance, $defaults );

        $title = esc_attr($instance['title']);
		$user = $instance['user'];
		$repo = $instance['repo'];
        $count = absint($instance['count']);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-github-commits'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('user'); ?>"><?php _e('User:', 'wp-github-commits'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo $user; ?>" /></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('repo'); ?>"><?php _e('Repo:', 'wp-github-commits'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('repo'); ?>" name="<?php echo $this->get_field_name('repo'); ?>" type="text" value="<?php echo $repo; ?>" /></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('No of commits to show:', 'wp-github-commits'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label>
        </p>

<?php
    }
} // class WP_Github_Commits_Widget

/**
 * Template function to display the badge
 * 
 * @param string $user
 * @param string $repo
 */
function get_github_commits($user, $repo, $count = 5) {
    global $wp_github_commits;
    return $wp_github_commits->get_github_commits($user, $repo, $count);
}
//adjustments to wp-includes/http.php timeout values to workaround slow server responses
add_filter('http_request_args', 'bal_http_request_args', 100, 1);
function bal_http_request_args($r) //called on line 237
{
	$r['timeout'] = 15;
	return $r;
}
 
add_action('http_api_curl', 'bal_http_api_curl', 100, 1);
function bal_http_api_curl($handle) //called on line 1315
{
	curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 15 );
	curl_setopt( $handle, CURLOPT_TIMEOUT, 15 );
}
?>
