<div class="blog_detail-footer-buttons like-block" data-id="<?=$arResult['ID']?>">
	<button class="blog_detail-footer-like like-block__btn" data-type="like" disabled>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_102_6337)">
				<path d="M13.12 2.05997L7.58 7.59997C7.21 7.96997 7 8.47997 7 9.00997V19C7 20.1 7.9 21 9 21H18C18.8 21 19.52 20.52 19.84 19.79L23.1 12.18C23.94 10.2 22.49 7.99997 20.34 7.99997H14.69L15.64 3.41997C15.74 2.91997 15.59 2.40997 15.23 2.04997C14.64 1.46997 13.7 1.46997 13.12 2.05997V2.05997ZM3 21C4.1 21 5 20.1 5 19V11C5 9.89997 4.1 8.99997 3 8.99997C1.9 8.99997 1 9.89997 1 11V19C1 20.1 1.9 21 3 21Z" fill="#637381"/>
			</g>
		</svg>
		<?=GetMessage('NAME_LIKE')?> <span class="blog_detail-footer-count like__count"><?=$arResult['LIKE'] != 0 ? $arResult['LIKE'] : ''?></span>
	</button>
	<button class="blog_detail-footer-dislike like-block__btn" data-type="dislike" disabled>
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_102_6345)">
				<path d="M10.8799 21.94L16.4099 16.4C16.7799 16.03 16.9899 15.52 16.9899 14.99V5C16.9899 3.9 16.0899 3 14.9899 3H5.9999C5.1999 3 4.4799 3.48 4.1699 4.21L0.9099 11.82C0.0598996 13.8 1.5099 16 3.6599 16H9.3099L8.3599 20.58C8.2599 21.08 8.4099 21.59 8.7699 21.95C9.3599 22.53 10.2999 22.53 10.8799 21.94V21.94ZM20.9999 3C19.8999 3 18.9999 3.9 18.9999 5V13C18.9999 14.1 19.8999 15 20.9999 15C22.0999 15 22.9999 14.1 22.9999 13V5C22.9999 3.9 22.0999 3 20.9999 3Z" fill="#637381"/>
			</g>
		</svg>				
		<?=GetMessage('NAME_DISLIKE')?> <span class="blog_detail-footer-count like__count"><?=$arResult['DISLIKE'] != 0 ? $arResult['DISLIKE'] : ''?></span>
	</button>
</div>