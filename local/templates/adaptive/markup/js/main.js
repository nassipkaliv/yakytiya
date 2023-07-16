//Код - пример из бутстрапа:
// Import our custom CSS
// import '../scss/styles.scss'

// Import only the Bootstrap components we need
import {Tab} from 'bootstrap';
import {Collapse} from 'bootstrap';

import './jquery_make_global'
import $ from 'jquery'
// Подключение плагинов jquery
import 'fullpage.js/dist/jquery.fullpage';

// Остальные плагины
// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';
import videojs from 'video.js';

// Create an example popover
// document.querySelectorAll('[data-bs-toggle="popover"]')
//   .forEach(popover => {
//     new Popover(popover)
//   })

// ****Начало нашего кода****

const XL_WIDTH = 1200;

$(init);

/**
 * Функция, которая все инициализирует
 */
function init() {
    initLayout();
    initPages();
}

function initLayout() {
    initMenu();
    initSearchMobile();
    initScrollToUp();
}

function initPages() {
    initHomepage();
    initProductCard();
}

function initMenu() {
    initHover();
    initSecondMenuTop();
    initMenuSecondOverflow();
    initMenuThirdAlignment();
    initMobileMenu();


    function initHover() {
        let $topLevelItems = $('#js-menu .menu-item');
        if (!$topLevelItems.length) {
            return;
        }
        let mouseenter = function() {
            // console.log(this, 'mouseenter');
            let $this = $(this);
            //Чтобы пункт меню не открывался сразу, даже если быстро через него провели и не моргал, делаем задержку
            //появления. Если быстро провели через элемент, то нужно убрать эту функцию из ожидания выполнения.
            //Делаю это внутри mouseleave.
            let id = setTimeout(function() {
                //не открываем меню, если родительский пункт меню закрыт.
                let $parentItem = $this.parent().closest('.menu-item');
                if ($parentItem.length && !$parentItem.hasClass('hover')) {
                    return;
                }
                initMenuThirdAlignment();
                $this.addClass('hover');
            }, 200);
            $this.data('timeout_id', id);
        };
        let mouseleave = function() {
            // console.log(this, 'mouseleave');
            let $this = $(this);
            clearTimeout($this.data('timeout_id'));
            $this.removeData('timeout_id');
            //Скроем открытое меню 3-го уровня, если скрывается меню второго уровня.
            //Иначе получалось, что меню 3-го уровня открыто, а второго - закрыто.
            $this.find('.menu-item').removeClass('hover');
            //затем скроем меню 2-го уровня.
            $this.removeClass('hover');
        };
        $topLevelItems.on('mouseenter', mouseenter).on('mouseleave', mouseleave);
    }

    function initSecondMenuTop() {
        /**
         * Если прокрутить немного вниз страницу, то меню второго уровня для большого монитора должно
         * сместиться вверх. Поскольку мы используем position: fixed, чтобы меню 2го уровня было
         * растянуто по всей ширине экрана, то нужно расчитывать вручную верх меню.
         */
        setSecondMenuTop();
        $(window).on('scroll', setSecondMenuTop);
        $(window).on('resize', setSecondMenuTop);
        function setSecondMenuTop() {
            let top = '';
            if (!isMobileMenuActive()) {
                //вычитаем единицу, потому что высота шапки по факту дробная.
                top = $('.header').outerHeight() - $(document).scrollTop() - 1;
            } else {
                top = ''; //удаляем свойство, если меню для мобильника
            }
            $('.menu__second').css('top', top);
        }
    }

    /**
     * Если пункт меню 2-го уровня вылезает за пределы родительского контейнера, то его нужно скрыть, чтобы
     * не вылезал и было красиво.
     */
    function initMenuSecondOverflow() {
        setMenuSecondOverflow();
        $(window).on('resize', setMenuSecondOverflow);

        function setMenuSecondOverflow() {
            const hiddenClass = 'd-none';
            $('.menu__second').each(function() {
                let $container = $(this).children('.container');
                let containerEndPosition = $container.offset().left + $container.outerWidth();
                let $items = $(this).find('.menu__second-list>.menu-item');
                $items.removeClass(hiddenClass);
                //Когда нужно сбросить логику, то не выполняем действия по скрытию элементов.
                //А сбросить ее нужно тогда, когда у нас разрешение страновится таким, когда меню переключается
                //в мобильный вид.
                if (!isMobileMenuActive()) {
                    $items.each(function() {
                        let $item = $(this);
                        if ($item.offset().left + $item.outerWidth() > containerEndPosition) {
                            $item.addClass(hiddenClass);
                        }
                    });
                }
            });
        }
    }

    function initMenuThirdAlignment() {
        /* Если меню 3-го уровня выходит за пределы экрана, то его нужно выровнять не по левой
		 * границе элемента, а по правой границе всего меню 2-го уровня
		 */
        const rightClass = 'right';
        let $menuSecond = $('#js-menu .menu__second-list');
        let $menuSecondItems = $menuSecond.children('.menu-item');
        if (!$menuSecond.length || !$menuSecondItems.length) {
            return;
        }
        let allMenuRight = $menuSecond.offset().left + $menuSecond.outerWidth();
        $menuSecondItems.removeClass(rightClass);
        $menuSecondItems.each(function() {
            let $item = $(this);
            let $menuThird = $item.find('.menu__third');
            if (!$menuThird.length) {
                return;
            }
            let menuThirdRight = $menuThird.offset().left + $menuThird.outerWidth();
            if (menuThirdRight > allMenuRight) {
                $item.addClass(rightClass);
            }
        });
    }

    /**
     * Инициализирует мобильное меню
     */
    function initMobileMenu() {
        let $toggler = $('#js-menu-toggler');
        let $menuBlock = $('#js-menu-block');
        let $menu = $('#js-menu');
        if (!$toggler.length || !$menu.length) {
            return;
        }

        $toggler.on('click', function() {
            if (!isMobileMenuActive()) {
                return;
            }
            $menuBlock.toggleClass('open');
        });

        $('#js-menu .menu-item>a').on('click', function() {
            if (!isMobileMenuActive()) {
                return;
            }
            let $this = $(this);
            let hasSubmenu = $this.parent().hasClass('menu-item_dropdown');
            if (hasSubmenu) {
                $(this).parent().toggleClass('open');
                return false;
            }
        });
    }

    /**
     * Возвращает истину, если должно показываться меню в мобильном виде.
     * @returns {boolean}
     */
    function isMobileMenuActive() {
        const windowWidth = $(window).width();
        return windowWidth < XL_WIDTH;
    }
}

/**
 * Инициализирует работу кнопку "наверх в лайауте"
 */
function initScrollToUp() {
    //Click event to scroll to top
    $('#js-scroll-to-up').on("click", function(){
        let isFullPageActive = (typeof $.fn.fullpage !== 'undefined') && ($('html').hasClass('fp-enabled'));
        if (isFullPageActive) {
            $.fn.fullpage.moveTo(1);
        } else {
            $('html, body').animate({scrollTop : 0},100);
        }
        return false;
    });
}

function initSearchMobile() {
    const MODIFY_CLASS = 'js-mobile-search-showed';
    $('#js-search-toggler').on('click', function() {
        $('body').addClass(MODIFY_CLASS);
    });
    $('#js-mobile-cancel').on('click', function() {
        $('body').removeClass(MODIFY_CLASS);
    });
}

/**
 * Инициализация главной страницы
 */
function initHomepage() {
    initBanner();
    initNovelties();
    initPopularProducts();
    initFullPage();

    hidePageLoader();

    function initBanner() {
        //Нужно удостовериться, что видео проинициализировано до того, как будет инициализироваться слайдер.
        //Для этого инициализируем вручную, если не проинициализовано.
        let $videos = $('.video-js');
        $videos.each(function() {
            let player = videojs.getPlayer(this);
            if (!player) {
                let player = videojs(this, {});
            }
        });

        let swiperBanner = new Swiper(".swiper-banner", {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            on: {
                init: playVideoOnlyActiveSlide,
                slideChange: playVideoOnlyActiveSlide
            }
        });

        /**
         * Включает воспроизведение видео, только если слайд с ним активный. Иначе - выключает.
         * @param swiper - объект свипера
         */
        function playVideoOnlyActiveSlide(swiper) {
            //Включаем воспроизведение видео
            let $slides = $('.swiper-banner .swiper-slide');
            let index = 0;
            $slides.each(function() {
                let $slide = $(this);
                let $video = $slide.find('video');
                if ($video.length) {
                    let player = videojs.getPlayer($video[0]);
                    if (player) {
                        if (index === swiper.activeIndex) {
                            player.addClass('d-block');
                            player.play();
                        } else {
                            player.pause();
                        }
                    }
                }
                index++;
            });
        }

    }

    function initNovelties() {
        let swiperNovelties = new Swiper(".js-swiper-novelties", {
            slidesPerView: 'auto',
            spaceBetween: 24,//1.5rem == --bs-gutter-x
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }

    function initPopularProducts() {
        //Популярные продукты
        let swiperPopular = new Swiper(".js-swiper-products-popular", {
            slidesPerView: 'auto',
            spaceBetween: 24,//1.5rem == --bs-gutter-x
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    }

    /**
     * Инициализация вертикального слайдера
     */
    function initFullPage() {
        let isInited = false;
        initFullpageOnXlResolution();
        $(window).on('resize', initFullpageOnXlResolution);

        function initFullpageOnXlResolution() {
            if (!isFullPageActive()) {
                if (isInited) {
                    $.fn.fullpage.destroy('all');
                    isInited = false;
                }
            } else {
                if (!isInited) {
                    let $fullpage = $('#fullpage');
                    if ($fullpage.length) {
                        $fullpage.fullpage({
                            paddingTop: '70px',
                        });
                        isInited = true;
                    }
                }
            }
        }

        /**
         * Возвращает истину, если должен работать плагин fullpage.js
         * @returns {boolean}
         */
        function isFullPageActive() {
            const windowWidth = $(window).width();
            const windowHeight = $(window).height();
            return windowWidth >= XL_WIDTH && windowHeight >= 900;
        }
    }

    /**
     * Инициализация эффекта заставки на главной странице.
     */
    function hidePageLoader() {
        let $loader = $('#js-page-loader');
        $loader.animate({
            'height': '130%'
        }, 500, function() {
            $loader.animate({
                'height': '4.4rem'
            }, 1000, function() {
                $loader.fadeOut(200);
            });
        });
    }
}

/**
 * Инициализация карточки товара
 */
function initProductCard() {
    let $card = $('#js-product-card');
    if (!$card.length) {
        return;
    }

    initImagesGallery();
}

/**
 * Инициализирует слайдер изображений с модальным окном.
 */
function initImagesGallery() {
    initSwipers();

    let $galleryOnPage = $('.js-images-gallery').filter(function() {
        //Исключаем те галереи, которые в модальном окне находятся
        return $(this).parents('.images-gallery-modal').length === 0;
    });
    $galleryOnPage.on('click', '.swiper-main img', function() {
        $('.images-gallery-modal').fadeIn(200);
        $('body').addClass('js-images-gallery-modal-active');
        return false;
    });

    let scrollSize = getScrollbarWidth() + 'px';
    document.body.style.setProperty('--removed-body-scroll-bar-size', scrollSize);

    $('body').on('click touchstart', '.js-images-gallery-modal-close', function() {
        $('.images-gallery-modal').fadeOut(200, function() {
            $('body').removeClass('js-images-gallery-modal-active');
        });
        return false;
    })

    /**
     * Возвращает ширину скроллбара
     * @returns {number}
     */
    function getScrollbarWidth() {
        // Creating invisible container
        const outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll'; // forcing scrollbar to appear
        outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
        document.body.appendChild(outer);

        // Creating inner element and placing it in the container
        const inner = document.createElement('div');
        outer.appendChild(inner);

        // Calculating difference between container's full width and the child width
        const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

        // Removing temporary elements from the DOM
        outer.parentNode.removeChild(outer);

        return scrollbarWidth;
    }

    function initSwipers() {
        let $wrapper = $('.js-images-gallery');
        $wrapper.each(function() {
            let $thumbnailsContainer = $(this).find(".swiper-thumbnails");
            let swiperThumbnails = new Swiper($thumbnailsContainer[0], {
                loop: true,
                spaceBetween: 10,
                // freeMode: true,
                slidesPerView: 'auto',
                watchSlidesProgress: true,
                navigation: {
                    nextEl: $thumbnailsContainer.siblings(".swiper-button-next")[0],
                    prevEl: $thumbnailsContainer.siblings(".swiper-button-prev")[0],
                },
            });
            let swiperMain = new Swiper($(this).find(".swiper-main")[0], {
                loop: true,
                spaceBetween: 10,
                thumbs: {
                    swiper: swiperThumbnails,
                },
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        });
    }
}

