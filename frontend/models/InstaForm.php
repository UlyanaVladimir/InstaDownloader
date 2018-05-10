<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class InstaForm extends Model
{
	public $insta_name;
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['insta_name'], 'required', 'message' => 'Введіть нік користувача! Наприклад: apple']
		];
	}

	public function instaResult($insta_name){
		$insta_json = file_get_contents('https://www.instagram.com/'.$insta_name.'/'); // instagram user url
		$shards = explode('window._sharedData = ', $insta_json);
		$insta_json = explode(';</script>', $shards[1]); 
		return json_decode($insta_json[0], TRUE);
	}

	function getUsername(array $insta_json){
		$result = '';
		$data = $insta_json['entry_data']['ProfilePage'][0]['graphql']['user'];
		foreach($data as $name => $val){
			if($name == 'username')
				$result = $val;
		}
		return $result;
	}

	function getFullname(array $insta_json){
		$result = '';
		$data = $insta_json['entry_data']['ProfilePage'][0]['graphql']['user'];
		foreach($data as $name => $val){
			if($name == 'full_name')
				$result = $val;
		}
		return $result;
	}

	function getBiography(array $insta_json){
		$result = '';
		$data = $insta_json['entry_data']['ProfilePage'][0]['graphql']['user'];
		foreach($data as $name => $val){
			if($name == 'biography')
				$result = $val;
		}
		return $result;
	}

	function getAvatar(array $insta_json){
		$result = '';
		$data = $insta_json['entry_data']['ProfilePage'][0]['graphql']['user'];
		foreach($data as $name => $val){
			if($name == 'profile_pic_url')
				$result = $val;
		}
		return $result;
	}

	function getPosts(array $insta_json){
		return $insta_json['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'];
	}

	function getFollowers(array $insta_json){
		return $insta_json['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'];
	}

	function getFollowing(array $insta_json){
		return $insta_json['entry_data']['ProfilePage'][0]['graphql']['user']['edge_follow']['count'];
	}

	function getPhoto(array $insta_json){
		$result = [];
		$last = count($insta_json['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']);
		for ($i=0;$i<$last;$i++) {
			$result[$i] = $insta_json['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['display_url'];
			$name = __DIR__.'\\..\\web\\img\\byusername\\original'.$i.'.jpg';
			file_put_contents($name, file_get_contents($result[$i]));
		}
		
		return $result;
	}
}