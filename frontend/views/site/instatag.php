<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Пошук по тегу';
?>
<div class="jumbotron">
	<h1><?= Html::encode($this->title) ?></h1>
	<p class="lead">Завантажити картинки по бажаному тегу !</p>
</div>
<div class="insta-main">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<?php $f = ActiveForm::begin(); ?>
			<?=$f->field($form, 'insta_tag')->textInput(['autofocus' => true, 'class' => 'form-control insta-text-field'])->label(false);?>
			<div class="col-sm-offset-4">
				<?= Html::submitButton('Вивести пости', ['class' => 'btn btn-primary insta-text-field']);?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>

		<div class="col-sm-10 col-sm-offset-1">
			<div class="insta-gallery-tag">
				<?php if ($insta_tag) {?>
				<div class="row">
					<?php for ($i=0;$i<count($insta_photo);$i++) {?>
					<div class="col-sm-4 col-xs-6">
						<div class="insta-photo">
							<div class="insta-downloads">
								<div class="insta-btn">
									<div class="dws">
										<a href="/img/bytag/original<?=$i?>.jpg" download>
											<div class="pulse">
												<div class="bloc"></div>
												<div class="download"><i class="fa fa-cloud-download" aria-hidden="true"></i></div>
												<div class="text">Зберегти</div>
											</div>
										</a>
									</div>
								</div>
						</div>
						<img class="insta-img" decoding="auto" style sizes="293px" srcset="<?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['0']['src']?> 150w, <?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['1']['src']?> 240w,<?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['2']['src']?> 320w, <?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['3']['src']?> 480w, <?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['4']['src']?> 640w" src="<?=$insta_result['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'][$i]['node']['thumbnail_resources']['4']['src']?>"/>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<br>
		<!--
		<?php //if ($insta_tag) {?>
		<pre>
			<?php //print_r($insta_result); ?>
		</pre>
	-->
		<!--
		<pre>
			<?php
			//$insta_json2 = file_get_contents('https://www.instagram.com/graphql/query/?query_hash=472f257a40c653c64c666ce877d59d2b&variables={"id":"1706775204","first":12,"after":"AQCPm3XgSDSXXMdZ93fC3hVKzuODLzq43CbsAjMupJpBsEc8kl1enwHU_Lkz40DBTR7I2qSZoVZxxETsPW72fY2T4NLZ-d90ng9qbd69dEnuvA"}');
			//print_r(json_decode($insta_json2, true));
			?>
		</pre>
	-->

	<?php //} ?>

</div>
</div>
</div>