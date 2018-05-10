<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class InstaTagForm extends Model
{
	public $insta_tag;
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['insta_tag'], 'required', 'message' => 'Введіть #тег! Наприклад: cars']
		];
	}

	function instaResult($insta_tag) {
    $insta_source = file_get_contents('https://www.instagram.com/explore/tags/'.$insta_tag.'/'); // instagrame tag url
    $shards = explode('window._sharedData = ', $insta_source);
    $insta_json = explode(';</script>', $shards[1]); 
    return json_decode($insta_json[0], TRUE); // this return a lot things print it and see what else you need
  }

  function getPhoto(array $insta_json){
  	$result = [];
  	$last = count($insta_json['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges']);
  	for ($i=0;$i<$last;$i++) {
  		$result[$i] = $insta_json['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['display_url'];
  		$name = __DIR__.'/../web/img/bytag/original'.$i.'.jpg';
      //$name = 'http://instadownloader2.xyz\\frontend\\web\\img\\bytag\\original'.$i.'.jpg';
  		file_put_contents($name, file_get_contents($result[$i]));
  	}

  	return $result;
  }
}