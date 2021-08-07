/*ÊÖ»úÍøÕ¾Ìø×ª*/
try {
	var urlhash = window.location.hash;
	if (!urlhash.match("fromapp")){
		if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|iPad)/i))){
		location.replace(juhaoyong_mp_site_jump_url);
		}
	}
}
catch(err){
}