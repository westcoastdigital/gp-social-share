var elements = document.querySelectorAll('#gp-social-share a');
Array.prototype.forEach.call(elements, function(el, i){
  el.onclick = function(elaction) {
	elaction.preventDefault();
	window.open( el.attributes.href.value, '', 'width=600,height=300' );
  }
});