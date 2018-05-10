<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Пошук по url';
?>
<div class="jumbotron">
	<h1><?= Html::encode($this->title) ?></h1>
	<p class="lead">Завантажити картинку або відео по силці поста !</p>
</div>
<div class="insta-main">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<?php $f = ActiveForm::begin(); ?>
			<?=$f->field($form, 'insta_url')->textInput(['autofocus' => true, 'class' => 'form-control insta-text-field'])->label(false);?>
			<div class="col-sm-offset-4">
				<?= Html::submitButton('Вивести пости', ['class' => 'btn btn-primary insta-text-field']);?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>

		<div class="col-sm-10 col-sm-offset-1">
			<div class="insta-gallery-tag">
				<?php if ($insta_url) {?>
				<div class="row">
					<?php for ($i=0;$i<count($insta_photo['image_url']);$i++) {
						$activetag = "";
						if($i == 0)
							$activetag = "active";

						$carouselimgs .= "<div class='item $activetag'>
						<div class='insta-downloads'>
						<div class='insta-btn'>
						<div class='dws'>
						<a href='/img/byurl/original$i.jpg' download>
						<div class='pulse'>
						<div class='bloc'></div>
						<div class='download'><i class='fa fa-cloud-download' aria-hidden='true'></i></div>
						<div class='text'>Зберегти</div>
						</div>
						</a>
						</div>
						</div>
						</div>
						<img class='insta-img-url' src='".$insta_photo['image_url'][$i]."' alt='Photo #".($i+1)."' height='450px' class='img-responsive img-thumbnail'/>
						</div>";

						$carouselindphoto .= "<li data-target='#carouselPhotos' data-slide-to='$i' class='$activetag'></li>";
					}

					$video = false;
					for ($i=0;$i<count($insta_photo['video_url']);$i++) {
						if(!empty($insta_photo['video_url']))
						{
							$video = true;
							$activetag2 = "";
							if($i == 0)
								$activetag2 = "active";

							$carouselvids .= "
							<center>
							<div class='item $activetag2'>
							<video height='450px' controls class='img-responsive img-thumbnail'>
							<source src='".$insta_photo['video_url'][$i]."' type='video/mp4'>
							Your browser does not support the video tag.
							</video>
							</div>
							</center>
							";

							$carouselindvid .= "<li data-target='#carouselVideos' data-slide-to='".($i)."' class='$activetag2'></li>";
						}
					}

					?>
					<div class="insta-photo">
						<div id='carouselPhotos' class='carousel slide' data-ride='carousel'>
							<!-- Carousel indicators -->
							<ol class='carousel-indicators'>
								<?=$carouselindphoto?>
							</ol>   
							<!-- Wrapper for carousel items -->
							<div class='carousel-inner'>

								<?=$carouselimgs?>

							</div>
							<!-- Carousel controls -->
							<a class='carousel-control left' href='#carouselPhotos' data-slide='prev'>
								<span class='glyphicon glyphicon-chevron-left'></span>
							</a>
							<a class='carousel-control right' href='#carouselPhotos' data-slide='next'>
								<span class='glyphicon glyphicon-chevron-right'></span>
							</a>
						</div>
					</div>
					<?php if($video) { ?>
					<div class="insta-photo">
						<div id='carouselVideos' class='carousel slide' data-ride='carousel'>
							<!-- Carousel indicators -->
							<ol class='carousel-indicators'>
								<?=$carouselindphoto?>
							</ol>   
							<!-- Wrapper for carousel items -->
							<div class='carousel-inner'>
								<?=$carouselvids?>
							</div>
							<!-- Carousel controls -->
							<a class='carousel-control left' href='#carouselVideos' data-slide='prev'>
								<span class='glyphicon glyphicon-chevron-left'></span>
							</a>
							<a class='carousel-control right' href='#carouselVideos' data-slide='next'>
								<span class='glyphicon glyphicon-chevron-right'></span>
							</a>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<br>
		<!--
			<?php //if ($insta_url) {?>
			<pre>
				<?php //print_r($insta_photo['video_url']); ?>
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