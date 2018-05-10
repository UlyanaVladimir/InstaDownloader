<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Пошук по імені';
?>
<div class="jumbotron">
	<h1><?= Html::encode($this->title) ?></h1>
	<p class="lead">Завантажити картинки по імені користувача !</p>
</div>

<div class="insta-main">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<?php $f = ActiveForm::begin(); ?>
			<?=$f->field($form, 'insta_name')->textInput(['autofocus' => true, 'class' => 'form-control insta-text-field'])->label(false);?>
			<div class="col-sm-offset-4">
				<?= Html::submitButton('Вивести пости', ['class' => 'btn btn-primary insta-text-field']);?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
		
		<div class="col-sm-10 col-sm-offset-1">
			<div class="insta-user">
				<div class="row">
					<div class="col-sm-3 col-sm-offset-1 col-xs-4">
						<?php if ($insta_name) {?>
						<div class="insta-user-avatar">
							<img src="<?=$insta_avatar?>" style="height: 100%; width: 100%">
						</div>
					</div>
					<div class="col-sm-7 col-sx-8">
						<div class="insta-user-info">
							<h1 class="info-username"><?=$insta_username?></h1>
						</div>
						<div class="insta-user-info">
							<span class="info-bold"><?=$insta_posts?><span class="info-normal"> posts</span></span>
							<span class="info-bold"><?=$insta_followers?><span class="info-normal"> followers</span></span>
							<span class="info-bold"><?=$insta_following?><span class="info-normal"> following</span></span>
						</div>
						<div class="insta-user-info">
							<span class="info-bold"><?=$insta_fullname?><span class="info-normal"> <?=$insta_biography?></span></span>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="insta-gallery">
				<?php if ($insta_name) {?>
				<div class="row">
					<?php for ($i=0;$i<count($insta_photo);$i++) {?>
					<div class="col-sm-4 col-xs-6">
						<div class="insta-photo">
							<div class="insta-downloads">
								<div class="insta-btn">
									<div class="dws">
										<a href="/img/byusername/original<?=$i?>.jpg" download>
											<div class="pulse">
												<div class="bloc"></div>
												<div class="download"><i class="fa fa-cloud-download" aria-hidden="true"></i></div>
												<div class="text">Зберегти</div>
											</div>
										</a>
									</div>
								</div>

								<!--
								<div class="btn-group btn-group-sm">
									<a download href="<?=$insta_result['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['0']['src']?>" class="btn btn-primary">150w</a>
									<a download href="<?=$insta_result['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['1']['src']?>" class="btn btn-primary">240w</a>
									<a download href="<?=$insta_result['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['2']['src']?>" class="btn btn-primary">320w</a>
									<a download href="<?=$insta_result['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['3']['src']?>" class="btn btn-primary">480w</a>
									<a download href="<?=$insta_result['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['4']['src']?>" class="btn btn-primary">640w</a>
								</div>
							-->
						</div>
						<img class="insta-img" decoding="auto" style sizes="293px" srcset="<?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['0']['src']?> 150w, <?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['1']['src']?> 240w,<?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['2']['src']?> 320w, <?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['3']['src']?> 480w, <?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['4']['src']?> 640w" src="<?=$insta_result['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']["$i"]['node']['thumbnail_resources']['4']['src']?>"/>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<br>

		<?php if ($insta_name) {?>
		<pre>
			<?php //print_r($insta_result); ?>
		</pre>

		<!--
		<pre>
			<?php
			//$insta_json2 = file_get_contents('https://www.instagram.com/graphql/query/?query_hash=472f257a40c653c64c666ce877d59d2b&variables={"id":"1706775204","first":12,"after":"AQCPm3XgSDSXXMdZ93fC3hVKzuODLzq43CbsAjMupJpBsEc8kl1enwHU_Lkz40DBTR7I2qSZoVZxxETsPW72fY2T4NLZ-d90ng9qbd69dEnuvA"}');
			//print_r(json_decode($insta_json2, true));
			?>
		</pre>
	-->

	<?php } ?>

</div>
</div>
</div>