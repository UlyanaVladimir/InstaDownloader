<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class InstaUrlForm extends Model
{
	public $insta_url;
	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['insta_url'], 'required', 'message' => 'Введіть url поста! Наприклад: https://www.instagram.com/p/Bed_w1sFw0Y/']
		];
	}

	function instaResult($insta_url) {
    $ch = curl_init(); # initialize curl object
    curl_setopt($ch, CURLOPT_URL, $insta_url); # set url
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); # receive server response
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); # do not verify SSL
    $data = curl_exec($ch); # execute curl, fetch webpage content
    echo curl_error($ch);
    $httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); # receive http response status
    curl_close($ch);  # close curl

    $begin = strpos($data, '<script type="text/javascript">window._sharedData =') + strlen('<script type="text/javascript">window._sharedData ='); 
    $end   = strpos($data, ';</script>');

    //substr() function to get only JSON data from whole source code
    $text = substr($data, $begin, ($end - $begin));
    return json_decode($text,true);
  }

  function getPhoto(array $insta_json){
  	$result = [];
    if(isset($insta_json['entry_data']['PostPage']))
    {
      $caption = (isset($insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_caption']['edges'][0]['node']['text'])) ? $jsonobj['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_caption']['edges'][0]['node']['text'] : null;
      $username = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['owner']['username'];
      $full_name = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['owner']['full_name'];
      $userid = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['owner']['id'];
      $likes = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_preview_like']['count'];
      $comments = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_comment']['count'];
      $arrusersphoto = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_media_to_tagged_user']['edges'];

      $img = array(); // array for storing user photos
      $video = array();

      //check if the instagram post have multiple photos or not and store into var
      if(isset($insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_sidecar_to_children']))
      {
        $index=0;
        foreach($insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['edge_sidecar_to_children']['edges'] as $images) 
        {
          $img[] = $images['node']['display_url'];
          $name = __DIR__.'\\..\\web\\img\\byurl\\original'.$index.'.jpg';
          file_put_contents($name, file_get_contents($img[$index]));

          if($images['node']['is_video'] == true)
            $video[] = $images['node']['video_url'];
          $index++;
        }
      }
      else
      {
        $img[] = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['display_url'];
        $name = __DIR__.'\\..\\web\\img\\byurl\\original0.jpg';
        file_put_contents($name, file_get_contents($img[0]));
        if($insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['is_video'] == true)
        {
          $video[] = $insta_json['entry_data']['PostPage'][0]['graphql']['shortcode_media']['video_url'];
        }
      }
    }

    //store data
    $result['user_id'] = $userid;
    $result['username'] = $username;
    $result['full_name'] = $full_name;
    $result['image_url'] = $img;
    $result['video_url'] = $video;
    $result['caption'] = $caption;
    $result['likes'] = $likes;
    $result['comments'] = $comments;
    $result['tagged_users'] = array();

    //loop array to get list of users_in_photo
    for($i=0;$i<count($arrusersphoto);$i++)
    {
      $jsondata['data']['tagged_users'][] = $arrusersphoto[$i]['node']['user']['username'];
    }

    return $result;
  }

}