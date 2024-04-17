class Likes {
	#cookieName;
	#cookiePrefix;

	constructor () {
		this.container = document.querySelector('.like-block');
		this.elementId = this.container.getAttribute('data-id');

		this.btns = this.container.querySelectorAll('.like-block__btn');
		this.#cookiePrefix = 'BITRIX_SM';
		this.#cookieName = 'USER_OPINION_SET';
		this.liked = BX.getCookie(`${this.#cookiePrefix}_${this.#cookieName}_${this.elementId}`);

		if (typeof this.liked === 'undefined') {
			this.btns.forEach(btn => {
				btn.removeAttribute('disabled');
				btn.addEventListener('click', (event) => {
					const { target } = event;
					this.setEvent(target);
				})
			});
		} else {
			this.container.querySelector(`[data-type="${this.liked}"]`)?.classList.add('active');
		}
	}

	async setEvent(btn) {
		const countNode = btn.querySelector('.like__count');
		const type = btn.getAttribute('data-type');

		if (type !== null) {
			const result = await BX.ajax.runComponentAction('itc:itc.likes', 'setLikes', {
				mode: "class",
				data: {
					id: this.elementId,
					type: type,
					cookieName: this.#cookieName,
				}
			});
			if (result.status === 'success') {
				btn.classList.add('active');
				countNode.textContent = result.data;
				this.btns.forEach(btn => btn.setAttribute('disabled', ''));
			} else {
				console.log('error');
			}
		}
	}
}

document.addEventListener('DOMContentLoaded', () => {
	new Likes();
});