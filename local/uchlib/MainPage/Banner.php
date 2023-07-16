<?php


class CU_MainPage_Banner
{
	public static function printBanner()
	{
		/*
		?>
		<div class="homepage__slide">

			<div class="homepage__slide-inner">
				<div class="homepage__banner">
					<div class="swiper swiper-banner">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="video-overlay"></div>
								<video
									id="my-video1"
									class="video-js"
									muted
									autoplay
									loop
									data-setup="{}"
								>
									<source src="/local/templates/adaptive/markup/upload/banner/video/video.mp4" type="video/mp4" />
									<p class="vjs-no-js">
										Для просмотра этого видео, пожалуйста, убедитесь что JavaScript включен и
										Ваш браузер
										<a href="https://videojs.com/html5-video-support/" target="_blank"
										>поддерживает видео HTML5</a>
									</p>
								</video>
							</div>
							<div class="swiper-slide"><a href="http://ya.ru"><img src="/local/templates/adaptive/markup/upload/banner/1.jpg" alt=""></a></div>
							<div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/2.jpg" alt=""></a></div>
							<div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/3.jpg" alt=""></a></div>
							<div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/4.jpg" alt=""></a></div>
						</div>

						<div class="swiper-pagination"></div>
					</div>

				</div>

			</div>

		</div>
		<?php
		*/
//		return;
		self::customBanner();
	}

	private static function customBanner()
	{
//        self::firstBanner();
        self::newBanner();
//        self::markup();
        return;
	}

    private static function firstBanner()
    {
        global $APPLICATION;
        $APPLICATION->IncludeComponent(
            "eshop_bootstrap_v4:banner",
            ".default",
            array(
                "COMPONENT_TEMPLATE" => ".default",
                "IBLOCK_ID" => "4",
                "ACTIVE" => "Y",
                "AUTOSLIDE" => "Y"
            ),
            false
        );
    }

    private static function newBanner()
    {
        $arParams = [
            "COMPONENT_TEMPLATE" => ".default",
            "IBLOCK_ID" => "4",
            "ACTIVE" => "Y",
            "AUTOSLIDE" => "Y"
        ];
        $arResult = self::fillBanners(4);
        if (!$arResult['BANNERS']) {
            //не нашлось активных баннеров
            return;
        }
        self::newBannerTemplate($arResult, $arParams);
    }

    private static function fillBanners($iblockId)
    {
        $iframeClass = 'd-block w-100 embed-responsive embed-responsive-16by9';
        $imgClass = 'd-block w-100';

        $arOrder = ["SORT"=>"ASC"];
        $arFilter = ["IBLOCK_ID" => $iblockId, 'ACTIVE' => 'Y'];
        $arGroupBy = false;
        $arNavStartParams = false;
        $arSelect = [
            'ID',
            'IBLOCK_ID',
            'DETAIL_PICTURE',
            'PROPERTY_LINK_HREF',
            'PROPERTY_VIDEO_FILE'
        ];
        $rsElement = CIBlockElement::GetList($arOrder, $arFilter, $arGroupBy, $arNavStartParams, $arSelect);

        while ($arElement = $rsElement->GetNext()) {
            $src = $videoSrc = null;
            if ($arElement["DETAIL_PICTURE"]) {
                $detalPicture = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
                if ($detalPicture) {
                    $src = $detalPicture['SRC'];
                }
            }
            if ($arElement["PROPERTY_VIDEO_FILE_VALUE"]) {
                $video = CFile::GetFileArray($arElement["PROPERTY_VIDEO_FILE_VALUE"]);
                if ($video) {
                    $videoSrc = $video['SRC'];
                }
            }
            $arResult['BANNERS'][] = [
                'PICTURE' => '<img src="'.$src.'" class="' . $imgClass . '" alt="" title="">',
                'LINK_HREF' => $arElement['PROPERTY_LINK_HREF_VALUE'],
                'SRC' => $src,
                'VIDEO_SRC' => $videoSrc,
            ];
        }
        return $arResult;
    }

    private static function firstBannerTemplate($arResult, $arParams)
    {
        ?>
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
        <?php
    }

    private static function newBannerTemplate($arResult, $arParams)
    {
        //если баннеров не было - ничего не выводим
        if (!$arResult['BANNERS']) {
            return;
        }
        ?>
        <div class="homepage__slide">
            <div class="homepage__slide-inner">
                <div class="homepage__banner">
                    <div class="swiper swiper-banner">
                        <div class="swiper-wrapper">
                            <?
                            foreach ($arResult['BANNERS'] as $banner) {
                                if ($banner['VIDEO_SRC']) {
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="video-overlay"></div>
                                        <video
                                            id="my-video1"
                                            class="video-js"
                                            muted
                                            autoplay
                                            loop
                                            data-setup="{}"
                                        >
                                            <source src="<?=$banner['VIDEO_SRC']?>" type="video/mp4" />
                                            <p class="vjs-no-js">
                                                Для просмотра этого видео, пожалуйста, убедитесь что JavaScript включен и
                                                Ваш браузер
                                                <a href="https://videojs.com/html5-video-support/" target="_blank"
                                                >поддерживает видео HTML5</a>
                                            </p>
                                        </video>
                                    </div>
                                <?
                                } else {
                                    ?>
                                    <div class="swiper-slide">
                                        <a href="<?=$banner['LINK_HREF']?>"><img src="<?=$banner['SRC']?>" alt=""></a>
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    //---------------

    private static function markup()
    {
        ?>
        <div class="homepage__slide">
            <div class="homepage__slide-inner">
                <div class="homepage__banner">
                    <div class="swiper swiper-banner">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="video-overlay"></div>
                                <video
                                    id="my-video1"
                                    class="video-js"
                                    muted
                                    autoplay
                                    loop
                                    data-setup="{}"
                                >
                                    <source src="/local/templates/adaptive/markup/upload/banner/video/video.mp4" type="video/mp4" />
                                    <p class="vjs-no-js">
                                        Для просмотра этого видео, пожалуйста, убедитесь что JavaScript включен и
                                        Ваш браузер
                                        <a href="https://videojs.com/html5-video-support/" target="_blank"
                                        >поддерживает видео HTML5</a>
                                    </p>
                                </video>
                            </div>
                            <div class="swiper-slide"><a href="http://ya.ru"><img src="/local/templates/adaptive/markup/upload/banner/1.jpg" alt=""></a></div>
                            <div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/2.jpg" alt=""></a></div>
                            <div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/3.jpg" alt=""></a></div>
                            <div class="swiper-slide"><a href="#"><img src="/local/templates/adaptive/markup/upload/banner/4.jpg" alt=""></a></div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}