<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
$autoslide = $arParams['AUTOSLIDE'] == 'Y' ? 'data-bs-ride="carousel"' : '';
?>
<div id="carouselExampleControls" class="carousel slide" <?= $autoslide ?> >
	<? if (count($arResult['BANNERS']) > 1) { ?>
		<div class="carousel-indicators">
			<? for ($i = 0; $i < count($arResult['BANNERS']); $i++) {
				$active = $i == 0 ? 'class="active" aria-current="true"' : '';
				echo '<button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="' . $i . '" ' . $active . '></button>';
			} ?>
		</div>
	<? } ?>
	<div class="carousel-inner">
		<?
		$start = true;
		foreach ($arResult['BANNERS'] as $banner) {
			$start = $start ? 'active' : '';
			$animationMove = $banner['ANIMATION_MOVE'] ? 'animation-move' : '';
			$animationScale = $banner['ANIMATION_SCALE'] ? 'animation-scale' : '';
			?>
			<div class="carousel-item <?=$start?> <?=$animationMove?> <?=$animationScale?>">
				<?
				if ($banner['VIDEO']) {
					echo $banner['VIDEO'];
				} else {
					$a_open = $a_close = '';
					if ($banner['LINK_HREF']) {
						$a_open = '<a href="' . $banner['LINK_HREF'] . '">';
						$a_close = '</a>';
					}
					?>
					<div>
						<?= $a_open ?>
						<?= $banner['PICTURE']; ?>
						<?= $a_close ?>
					</div>
					<?
				}
				?>
			</div>
			<?
			$start = false;
		}
		?>

	</div>
	<? if (count($arResult['BANNERS']) > 1) { ?>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	<? } ?>
</div>