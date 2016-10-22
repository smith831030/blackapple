<?php
$this->set('channelData', array(
	'title' => __("Most Recent Posts"),
	'link' => $this->Html->url('/', true),
	'description' => __("Most recent posts."),
	'language' => 'ko'
));

foreach ($posts as $post) {
	$postTime = strtotime($post['BaPost']['created']);

	$postLink = array(
		'controller' => 'posts',
		'action' => 'view',
		$post['BaPost']['id']
	);

	// Remove & escape any HTML to make sure the feed content will validate.
	$bodyText = h(strip_tags($post['BaPost']['body']));
	$bodyText = $this->Text->truncate($bodyText, 400, array(
					'ending' => '...',
					'exact'  => true,
					'html'   => true,
				));

	echo  $this->Rss->item(array(), array(
		'title' => $post['BaPost']['title'],
		'link' => $postLink,
		'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
		'description' => "<img src='/upload/".$post['BaPost']['img']."' alt='".$post['BaPost']['title']."' /><br />".$bodyText,
		'pubDate' => $post['BaPost']['created']
	));
}
?>