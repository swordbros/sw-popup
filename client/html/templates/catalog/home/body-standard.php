<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2020-2021
 */

$enc = $this->encoder();
$pos = 0;

?>

<style>
body {font-family: Arial, Helvetica, sans-serif;}


.modal {
  display: block; 
  position: fixed; 
  z-index: 1; 
  padding-top: 200px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}


.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  max-width: 480px;
}


#close-button {
	color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  text-align: end;
}

#close-button:hover,
#close-button:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.popup-image{
	width: 200px;
    margin: auto;
	margin-bottom: 20px;
}
.popup-title{
	text-align: center;
    font-size: 20px;
}
.popup-short, .popup-long{
	text-align: center;
}
.popup-button {
	background-color: #8cb73d;
    border-color: #8cb73d;
    color: #fff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 1px solid transparent;
    cursor: pointer;
    font-size: 14px;
    text-align: center;
    text-transform: uppercase;
    line-height: 1.42857143;
    padding: 8px 24px;
    display: inline-block;
    letter-spacing: .3px;
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    -webkit-transition: all 0.3s cubic-bezier(.4,0,.2,1);
    -moz-transition: all 0.3s cubic-bezier(.4,0,.2,1);
    -o-transition: all 0.3s cubic-bezier(.4,0,.2,1);
    width: 28%;
    margin: 0 auto;
  
}
.popup-button a{
color:white!important;
  
}

</style>


<section class="aimeos catalog-home" data-jsonurl="<?= $enc->attr( $this->link( 'client/jsonapi/url' ) ) ?>">

	<?php if( isset( $this->homeErrorList ) ) : ?>
		<ul class="error-list">
			<?php foreach( (array) $this->homeErrorList as $errmsg ) : ?>
				<li class="error-item"><?= $enc->html( $errmsg ) ?></li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
	<?php $popup_data = \Aimeos\Shop\Facades\Shop::get('popup')->addData($this);?>

	<?php if(isset($popup_data->items) && !empty($popup_data->items) && $popup_data->items[0]['image_url'] ):?>
		
		<div id="myModal" class="modal">
			<div class="modal-content">

				<div id="close-button" class="close">  &times; </div>

				<?php if( $popup_data->items[0]['name']):?>
				<p class="popup-title"> <?=  $this->translate( 'client', $popup_data->items[0]['name'] )  ?> </p>
				<?php endif; ?>

				<img class="popup-image" src="/aimeos/<?= $popup_data->items[0]['image_url']; ?>" alt="">

				<?php if( $popup_data->items[0]['short']):?>
				<p class="popup-short"> <?=  $this->translate( 'client', $popup_data->items[0]['short'] ) ?> </p>
				<?php endif; ?>

				<?php if( $popup_data->items[0]['long']):?>
				<p class="popup-long">  <?=  $this->translate( 'client', $popup_data->items[0]['long'] ) ?> </p>
				<?php endif; ?>

				<?php if( $popup_data->items[0]['button_text']):?>
				<button  class="popup-button"> <?=  $this->translate( 'client', $popup_data->items[0]['button_text'] ) ?> </button>
				<?php endif; ?>
			</div>
		</div> 
	
	<?php endif; ?>




	<?php if( isset( $this->homeTree ) ) : ?>

		<div class="home-gallery <?= $enc->attr( $this->homeTree->getCode() ) ?>">

			<?php if( !( $mediaItems = $this->homeTree->getRefItems( 'media', 'stage', 'default' ) )->isEmpty() ) : ?>
				<div class="home-item home-image <?= $enc->attr( $this->homeTree->getCode() ) ?>">
					<div class="home-stage catalog-stage-image">
						<?php foreach( $mediaItems as $mediaItem ) : ?>
							<a class="stage-item" href="<?= $enc->attr( $this->link( 'client/html/catalog/tree/url', ['f_catid' => $this->homeTree->getId(), 'f_name' => $this->homeTree->getName( 'url' )] ) ) ?>">
								<img class="stage-image"
									src="<?= $enc->attr( $this->content( $mediaItem->getPreview( true ) ) ) ?>"
									srcset="<?= $enc->attr( $this->imageset( $mediaItem->getPreviews() ) ) ?>"
									alt="<?= $enc->attr( $mediaItem->getProperties( 'name' )->first() ) ?>"
								>
								<div class="stage-text">
									<div class="stage-short">
										<?php foreach( $this->homeTree->getRefItems( 'text', 'short', 'default' ) as $textItem ) : ?>
											<?= $textItem->getContent() ?>
										<?php endforeach ?>
									</div>
									<div class="btn"><?= $enc->html( $this->translate( 'client', 'Take a look GA' ) ) ?></div>
								</div>
							</a>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>

			<?php foreach( $this->homeTree->getChildren() as $child ) : ?>
				<?php if( !( $mediaItems = $child->getRefItems( 'media', 'stage', 'default' ) )->isEmpty() ) : ?>

					<div class="home-item cat-image <?= $enc->attr( $child->getCode() ) ?>">
						<div class="home-stage catalog-stage-image">

							<?php foreach( $mediaItems as $mediaItem ) : ?>

								<a class="stage-item row" href="<?= $enc->attr( $this->link( 'client/html/catalog/tree/url', ['f_catid' => $child->getId(), 'f_name' => $child->getName( 'url' )] ) ) ?>">
									<img class="stage-image"
										src="<?= $enc->attr( $this->content( $mediaItem->getPreview( true ) ) ) ?>"
										srcset="<?= $enc->attr( $this->imageset( $mediaItem->getPreviews() ) ) ?>"
										alt="<?= $enc->attr( $mediaItem->getProperties( 'name' )->first() ) ?>"
									>
									<div class="stage-text">
										<div class="stage-short">
											<?php foreach( $child->getRefItems( 'text', 'short', 'default' ) as $textItem ) : ?>
												<?= $textItem->getContent() ?>
											<?php endforeach ?>
										</div>
										<div class="btn"><?= $enc->html( $this->translate( 'client', 'Take a look' ) ) ?></div>
									</div>
								</a>

							<?php endforeach ?>

						</div>
					</div>

				<?php endif ?>
			<?php endforeach ?>

		</div>

	<?php endif ?>

</section>
