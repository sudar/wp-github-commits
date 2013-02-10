<?php
/**
 * Abstracts interaction with Github API
 *
 * @package WP Github Commits
 * @subpackage default
 * @author Sudar
 */
class Github_API {
    
    const SERVER = "https://api.github.com";

    function __construct() {
        // left intentionally blank
    }

    /**
     * Get the commits of a repo
     *
     * @return array - list of commits
     */
    public function get_repo_commits($user, $repo) {
        $path = "/repos/$user/$repo/commits";
        $response = $this->make_request($path);
        $commits = array();

        if ($response['status'] == 'success') {
            $commits = json_decode($response['body']);
        } else {
            error_log('Unable to retrieve github commits. ERROR: ' . $response['msg']);
        }

        return $commits;
    }

    /**
     * make request to github server
     *
     * @return void
     * @author Sudar
     */
    private function make_request($path) {
        $url = self::SERVER . $path;
        $response = wp_remote_get($url);
        $result = array();

        if( is_wp_error( $response ) ) {
            $result['status'] = 'error';
            $result['msg'] = $response->get_error_message();
        } else {
            $result['status'] = 'success';
            $result['body'] = $response['body'];
        }

        return $result;
    }
} // END class Github_API
?>
