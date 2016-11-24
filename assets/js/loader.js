function rand(mi, ma){return Math.floor(Math.random() * (ma - mi + 1) + mi);}
function randId(){return (new Date()-0).toString(36).replace(/[^a-z]+/g, "").substr(0,8) + "_" +rand(1000000, 9999999);}
var POSTS = {};
var loader = {
	start:function(){
		var el = document.querySelector("div.loader");
		if(el){
			el.style.height = "";
			el.style.opacity = 1;
		}
	},
	stop(){
		var el = document.querySelector("div.loader");
		if(el){
			el.style.height = "0px";
			el.style.opacity = 0;
		}
	}
}
function loadPosts(f){
	t = 'data/posts.json';
	if (t.match(/\?/)) {
		t += '&z='+randId();
	} else {
		t += '?z='+randId();
	}
	var xhr = new XMLHttpRequest();
	xhr.open('GET', t, 1);
	xhr.send();
	xhr.onreadystatechange = f;
}
loader.start();
loadPosts(function(e){
	xhr = e.target;
	if (xhr.readyState != 4) return;
	if (xhr.status != 200) {
		console.log(xhr.status + ': ' + xhr.statusText);
	}
	data = xhr.responseText;
	data = JSON.parse(data);
	POSTS = data;
	onReady();
	loader.stop();
});

function onReady(){
	if(typeof page_ready == "function"){
		page_ready(POSTS);
	}
}
