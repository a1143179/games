<?php
require_once('lib/TwitterAPIExchange.php');
class Twitter{

	private $username = null;
	private	$settings = array(
			'oauth_access_token' => "156564619-h8ZX4brjSJsQboWpclQ4wnSQcuCGu7lREB3g9cNs",
			'oauth_access_token_secret' => "W6diYPyWQtClWYVPsG3N6h2jmJgaSuL30DzG86HskiHg7",
			'consumer_key' => "2SBHCWp29LzxmbEmX2JkAi2w7",
			'consumer_secret' => "mcfAiKFvRAheBwb0NduAcgUX16uwBvX36phZO3EdJXVtccRBEM"
	);
	private $twitter = null;

	public function validateAndAssignInput($argv){
		if(!isset($argv[1])){
			die('Usage: php Twitter.php [twitter_username]');
		}
		$this->username = $argv[1];
		$this->twitter = new  TwitterAPIExchange($this->settings);
	}

	/**
	 * Get twitter response 
	 * @param TwitterAPIExchange $twitter
	 * @param unknown $username
	 * @param unknown $apiUrl
	 * @return mixed
	 */
	private function getTwitterResponse(TwitterAPIExchange $twitter, $username, $apiUrl, $count = null){
		$countUrl = '';
		if(!empty($count)){
			$countUrl = '&count=' . $count;
		}
		$response = $twitter->setGetField('?screen_name=' . $username . $countUrl)
		->buildOauth($apiUrl, 'GET')
		->performRequest(true);
		$response = json_decode($response, true);
		return $response;
	}
	
	/**
	 * Get the tweets from the username provided.
	 * @param TwitterAPIExchange $twitter
	 * @param unknown $username
	 * @param unknown $apiUrl
	 */
	public function getTwitts(TwitterAPIExchange $twitter, $username, $apiUrl){
		$response = $this->getTwitterResponse($twitter, $username, $apiUrl, 5);
		echo '==========================Last 5 Tweets==========================' . "\n";
		$i = 1;
		foreach($response as $r){
			echo $i . '. ' . (!empty($r['text']) ? $r['text'] : '') . "\n";
			if($i>=5){
				break;
			}
			$i++;
		}
	}
	
	/**
	 * Get other statistics
	 * @param TwitterAPIExchange $twitter
	 * @param string $username
	 * @param string $apiUrl
	 */
	public function getOtherStat(TwitterAPIExchange $twitter, $username, $apiUrl){
		$response = $this->getTwitterResponse($twitter, $username, $apiUrl);
		echo '==========================Other Statics==========================' . "\n";
		echo 'Number of Tweets: ' . (!empty($response['statuses_count']) ? $response['statuses_count'] : '') . "\n";
		echo 'Number of followers: ' . (!empty($response['followers_count']) ? $response['followers_count'] : '') . "\n";
		echo 'Number of followings: ' . (!empty($response['friends_count']) ? $response['friends_count'] : '') . "\n";
	}
	

	/***
	 * Run the program using php Twitter.php [username]
	 */
	public function run($argv){
		$this->validateAndAssignInput($argv);
		$this->getTwitts($this->twitter, $this->username, 'https://api.twitter.com/1.1/statuses/user_timeline.json');
		$this->getOtherStat($this->twitter, $this->username, 'https://api.twitter.com/1.1/users/show.json');
	}
}
$twitter = new Twitter();
$twitter->run($argv);



