<?php

class CU_Layout_Footer
{
	public static function printFooter()
	{
		?>
		<footer class="footer mt-auto">
			<div class="footer__inner">
				<div class="container">
					<div class="row">
						<div class="col-md-3 footer__col footer__col_logo">
							<div class="d-inline-block">
								<div class="mb-4">
									<svg class="uicon-footer_logo"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#footer_logo"></use></svg>
								</div>
								<div class="text-center">
									<a href="https://мойбизнес14.рф" class="me-3"><img src="/local/templates/adaptive/markup/imgs/footer_yakutia.svg" alt=""></a>
									<a href="https://мойбизнес.рф" class="me-3"><svg class="uicon-footer_my_business"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#footer_my_business"></use></svg></a>
									<a href="https://национальныепроекты.рф"><svg class="uicon-footer_national_projects"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#footer_national_projects"></use></svg></a>
								</div>
							</div>
						</div>
						<div class="col-md-3 footer__col">
							<div class="menu-footer">
								<div class="menu-footer__header">Общая информация</div>
								<ul>
									<li><a href="/about/">О &laquo;Сделано в Якутии&raquo;</a></li>
									<li><a href="/news/">Новости</a></li>
									<li><a href="/about/contacts/">Контакты</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 footer__col">
							<div class="menu-footer">
								<div class="menu-footer__header">Покупателям</div>
								<ul>
									<li><a href="/help/client/order/">Как сделать заказ</a></li>
									<li><a href="/help/client/pay/">Оплата</a></li>
									<li><a href="/help/client/delivery/">Доставка</a></li>
									<li><a href="/help/client/return/">Возврат</a></li>
									<li><a href="/help/client/rule/">Правила продажи</a></li>
									<li><a href="/help/client/license/">Пользовательское соглашение</a></li>
									<li><a href="/help/client/privacy/">Политика конфеденциальности</a></li>
									<li><a href="/help/client/faq/">Вопросы и ответы</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 footer__col">
							<div class="menu-footer">
								<div class="menu-footer__header">Продавцам</div>
								<ul>
									<li><a href="/help/seller/start/">Стать продавцом</a></li>
									<li><a href="/help/seller/offer/">Договор оферты</a></li>
									<li><a href="/help/seller/faq/">Вопросы и ответы</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div>
						<div class="row align-items-center">
							<div class="col-2">
									<span class="footer__arrow-up" id="js-scroll-to-up">
										<svg class="uicon-arrow_up"><use xlink:href="/local/templates/adaptive/markup/imgs/sprite.svg#arrow_up"></use></svg>
									</span>
							</div>
							<div class="col-10">
								<div class="text-end"><small>© 2023 ГАУ РС(Я) «ЦЕНТР&nbsp;«МОЙ&nbsp;БИЗНЕС»</small></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<?php
	}
}