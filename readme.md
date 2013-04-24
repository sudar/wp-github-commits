# WP Github Commits #
**Contributors:** sudar 
**Tags:** github, commits, widget
**Requires at least:** 3.5
**Tested up to:** 3.5.1
**Stable tag:** 0.5

Displays the latest commits of a github repo in the sidebar.

## Description ##
Displays the latest commits of a github repo in the sidebar.

### Features

#### Sidebar Widget

The Plugin provides a sidebar widget which can be configured to display commits from a github repo in the sidebar. You can have multiple widgets with different repo configured for each one of them.

#### Template function

In addition to using the widget, you can also use the following template function to display the commits of a github repo, anywhere in the theme

`get_github_commits($user, $repo, $count);`

The following options can be passed in the $options array

- $user (string) - Github user name. 
- $repo (string) - Github repo name.
- count (int) - default 5 -  Number of recent commits to show

#### Custom field

You can also specify the repo for each post or page as a custom field. You can add it under the "WP Github Commits Page fields" section in the Add/Edit post screen.

#### Caching

The Plugin caches the commits that is retrieved from Github for 5 hours.

#### Styling using CSS

The Plugin adds the following CSS classes. If you want to customize the look of the widget then can change it by adding custom styles to these CSS classes.

- The outer `ul` tag has the class `github-commits`
- Every `li` tag has the class `github-commit`

### Troubleshooting

If you get timeouts or the error "WP HTTP Error: name lookup timed out" then it means that your server is not timing out before github can respond.

You can use the code from [this gist](https://gist.github.com/sudar/4945588) to increase the timeout.

### Translation

The pot file is available with the Plugin. If you are willing to do translation for the Plugin, use the pot file to create the .po files for your language and let me know. I will add it to the Plugin after giving credit to you.

### Development

The development of the Plugin happens over at [github](https://github.com/sudar/wp-github-commits). If you want to contribute to the Plugin, fork the [project at github](https://github.com/sudar/wp-github-commits) and send me a pull request.

If you are not familiar with either git or Github then refer to this [guide to see how fork and send pull request](http://sudarmuthu.com/blog/contributing-to-project-hosted-in-github).

Support for the Plugin is available from the [Plugin's home page][1]. If you have any questions or suggestions, do leave a comment there or contact me in [twitter][2].

If you are looking for ideas, then you can start with one of the following TODO items :)

### TODO

- Shortcode support
- Ability to hide author name
- Make the output of widget content plugable

### Support

- If you have found a bug/issue or have a feature request, then post them in [github issues](https://github.com/sudar/wp-github-commits/issues)
- If you have a question about usage or need help to troubleshoot, then post in WordPress forums or leave a comment in [Plugins's home page][1]
- If anything else, then contact me in [twitter][2].

### Stay updated

I would be posting updates about this Plugin in my [blog][4] and in [Twitter][2]. If you want to be informed when new version of this Plugin is released, then you can either subscribe to this [blog's RSS feed][3] or [follow me in Twitter][2].

Also checkout [other Plugins by the author][5].

 [1]: http://sudarmuthu.com/wordpress/wp-github-commits
 [2]: http://twitter.com/sudarmuthu
 [3]: http://sudarmuthu.com/feed
 [4]: http://sudarmuthu.com/blog
 [5]: http://sudarmuthu.com/wordpress

## Installation ##

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page. You should see a new widget called "Github commits" in the widgets pages, which you can drag and drop in the sidebar of your theme.

## Changelog ##

### v0.1 - (2013-02-11) - (Dev time: 3 hour) ###
*   Initial Release

### v0.2 - (2013-02-13) - (Dev time: 1 hour) ###
* Added option to take repo name from custom field in a post

### v0.3 - (2013-02-14) - (Dev time: 1 hour) ###
* Use custom field for widget title only if it non-blank
* Formatted the date into a human readable format

### v0.4 - (2013-02-16) - (Dev Time: 1 hour) ###
* Changed custom field names to make it compatible with other Plugins
* Generated pot file for translation

### v0.5 - (2013-04-24) - (Dev Time: 1 hour) ###
* Added documentation

## Upgrade Notice ##

### 0.2 ###
Added option to take repo name from custom field in a post

### 0.3 ###
Formatted the date into human readable format

### 0.4 ###
Changed custom field names to make it compatible with other Plugins

## Readme Generator ##

This Readme file was generated using <a href = 'http://sudarmuthu.com/wordpress/wp-readme'>wp-readme</a>, which generates readme files for WordPress Plugins.
