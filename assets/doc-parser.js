(() => {
	let doc_content = document.querySelector('.doc-content');
	if (!doc_content) return console.error('no doc-content');
	if (!window.showdown) return console.error('showdown required!');
	let converter = new showdown.Converter();
	let html = converter.makeHtml(atob(doc_content.innerText.trim()));
	doc_content.innerHTML = html;
	doc_content.classList.remove('markdown');
})();