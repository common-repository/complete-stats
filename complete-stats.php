<?php
/* Plugin Name: Complete Site Stats
 * Version: 0.1
 * Plugin URI: http://www.gpearce.co.uk/plugins/complete-stats/
 * Description: Complete statistics for your blog.
 * Author: George Pearce
 * Author URI: http://www.gpearce.co.uk/
 */
// Some set variables for misc stuff.

// for the pagerank
function prchecker() {
echo 'The pagerank of this page is <img src="http://www.getseoresults.com/free-pagerank-display.php?a=getCode&s=Google" title="Free PageRank Display Code" border="0px" alt="Free PageRank Checker Display" /><br />'; 
}

// for the alexa rank
function getalexa() {
$homepageurl = get_bloginfo('home');
$request_url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$homepageurl;
$xml = simplexml_load_file($request_url) or die ("Feed not loading, sorry");
return $xml->SD->POPULARITY['TEXT'];
}
function showalexa() {
echo "The Alexa rank of this website is "; echo getalexa(); // this needs cleaning up in release version.
}

// checking backlinks
function yahoo_backlinks() {
?>
<br><center><!-- START CODE -->
<script type="text/javascript" src="https://sec.yimg.com/us.yimg.com/lib/s2/yschx_siteexplorer_badge_20070709.js"></script>
<div id="ybadge" style="position:relative;left:0px;top:0px;width:105px;height:35px;z-index:1;border: 1px solid #8ea9ba;background: url(https://sec.yimg.com/us.yimg.com/i/us/sch/el/siteex_badgesml_bg.gif) repeat-x;overflow: hidden;cursor:pointer;" onclick="GotoSiteUrl()">
<div id="ylogo" style="position:absolute;left:5px;top:11px;width:18px;height:10px;z-index:1;">
<img src="https://sec.yimg.com/us.yimg.com/i/us/sch/el/siteex_badgesml_logo.gif" alt="Yahoo!" width="18" height="10" />
</div>
<div id="ynum" style="position:absolute;left:30px;top:3px;width:75px;font:bold 11px Tahoma, Verdana, Arial;color: #2d2a25;height:15px;z-index:2;text-align: center;">
<script type="text/javascript">
<!--
document.write("<scr"+"ipt type=\"text/javascript\" src=\"http://search.yahooapis.com/SiteExplorerService/V1/inlinkCount?appid=YahooBadge&entire_site=1&query="+siteurl+"&output=json&callback=ws_results\"></scr"+"ipt\>");
// -->
</script></div>
<div id="ytxt" style="position:absolute;height:15px;z-index:3;font:normal 11px Tahoma, Verdana, Arial;left:30px;top:18px;width:75px;color: #1b1a17;">
Links to Site</div></div>
<!-- END CODE --></center><br />
<?php }

// Setting up the widget
function widget_css_launch() {
if ( function_exists('register_sidebar_widget') ) :
	function widget_complete_site_stats() {
echo $before_widget;
echo $before_title . $options['title'] . $after_title;

// The widget itself. Anything below here and above the next comment will be placed directly into the widget. ?><br />
<?php 	prchecker();  
	showalexa(); 
	yahoo_backlinks();?>
	

<?php
// please don't remove the following credits link, and if you really must, a donation would be appreciated. gpearce.co.uk/contribute.
echo "<small>Stats by <a href='http://www.gpearce.co.uk/plugins/complete-stats/'>Complete Stats</a></small>";
echo $after_widget;
// the widget ends here. The next bit is important, please don't edit it.
}

register_sidebar_widget('Complete Site Stats', 'widget_complete_site_stats', null, 'Complete_Site_Stats');
function widget_complete_site_stats_control() {
		$options = $newoptions = get_option('widget_complete_site_stats');
		if ( $_POST["complete_site_stats-submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["complete_site_stats-title"]));
			if ( empty($newoptions['title']) ) $newoptions['title'] = 'Stats';
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_complete_site_stats', $options);
		}
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
}
	endif;
}
add_action('init', 'widget_css_launch');

/* And we're finished. This plugin took about 5 hours of my work, and if you find any problems, post them on my bug tracker
 * http://bugs.gpearce.co.uk
*/
?>
