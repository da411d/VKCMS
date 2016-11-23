function limitText(str){
	if(str.indexOf(" ", 100)>-1){
		r = str.substr(0, str.indexOf(" ", 100));
		return (r.length<str.length && r.length>100)?r+"...":r
	}else{
		return str;
	}
}

function page_ready(){
	getScrollTop()>300&&setScrollTop(300);var o=setInterval(function(){getScrollTop()||clearInterval(o),setScrollTop(getScrollTop()-10)},1);
	document.querySelectorAll(".card_wrapper").forEach(function(t){t.outerHTML = '';});
	document.querySelectorAll(".post_wrapper").forEach(function(t){t.outerHTML = '';});
	if(window.location.hash.length>4 && window.location.hash.indexOf("post-") === 1){
		readyPost(window.location.hash.split("-")[1]);
		document.querySelector(".main h1 .back").style.display = "inline-block";
	}else{
		readyCards();
		document.querySelector(".main h1 .back").style.display = "none";
	}
}
function readyPost(n){
	c = document.createElement("div");
	c.className = "post_wrapper";
	var innerHTML = "";
	for(var i=0;i<POSTS.length;i++){
		var t = POSTS[i];
		if(t.id==n){
			innerHTML += genPost({
				POST_ID: t.id,
				ORIGINAL: t.owner_id+"_"+t.id,
				PROFILE_PHOTO: "data/profile.jpg",
				USERNAME: "ФТЛ",
				TIME: new Date(new Date() - t.date).toLocaleDateString(),
				ATTACHMENT:(function(t){
					var c = document.createElement("div");
					if(!t.attachments)return false;
					for(var i=0;i<t.attachments.length;i++){
						var a = t.attachments[i];
						switch(a.type){
							case "video":
								var l = document.createElement("a");
								l.href = "https://vk.com/video"+a.video.owner_id+"_"+a.video.id;
								var v = document.createElement("div");
								v.className = "video";
								v.style.backgroundImage = "url(" +(a.video.photo_640 || a.video.photo_320)+ ")";
								v.innerHTML = '<div class="info"><span class="title">'+a.video.title+'</span><span class="description">'+a.video.description+'</span></div>';
								l.appendChild(v);
								c.appendChild(l);
								break;
							case "link":
								var l = document.createElement("a");
								l.href = a.link.url;
								l.target = "_blank";
								var v = document.createElement("div");
								v.className = "link";
								if(a.link.photo){
									v.classList.add("photo");
									v.style.backgroundImage = "url(" +a.link.photo.photo_604+ ")";
								}
								v.innerHTML = '<div class="info"><span class="title">'+a.link.title+'</span><span class="description">'+a.link.description+'</span></div>';
								l.appendChild(v);
								c.appendChild(l);
								break;
						}
					}
					return c.innerHTML;
				})(t),
				IMAGE: (function(t){
					var im = "";
					if(!t.attachments)return false;
					for(var i=0;i<t.attachments.length;i++){
						if(t.attachments[i].type == "photo"){
							return t.attachments[i].photo.photo_1280;
						}else if(t.attachments[i].type == "album"){
							return t.attachments[i].album.thumb.photo_1280;
						}
					}
				})(t),
				TEXT : t.text || ""
			});
		}
	}
	c.innerHTML = innerHTML;
	document.querySelector("div.main").appendChild(c);
	initMsnry();
}
function readyCards(){
	c = document.createElement("div");
	c.className = "card_wrapper";
	var innerHTML = ""
	for(var i=0;i<POSTS.length;i++){
		var t = POSTS[i];
		innerHTML += genCard({
			POST_ID: t.id,
			PROFILE_PHOTO: "data/profile.jpg",
			USERNAME: "ФТЛ",
			TIME: new Date(new Date() - t.date).toLocaleDateString(),
			IMAGE: (function(t){
				var im = "";
				if(!t.attachments)return false;
				for(var i=0;i<t.attachments.length;i++){
					if(t.attachments[i].type == "photo"){
						return t.attachments[i].photo.photo_1280;
					}else if(t.attachments[i].type == "link" && typeof t.attachments[i].link.photo == "array"){
						return t.attachments[i].link.photo.photo_604;
					}else if(t.attachments[i].type == "album"){
						return t.attachments[i].album.thumb.photo_1280;
					}else if(t.attachments[i].type == "video"){
						return t.attachments[i].video.photo_800;
					}
				}
			})(t),
			TEXT:(function(t){
				if(t.text)return limitText(t.text);
				out = "";
				if(!t.attachments)return false;
				for(var i=0;i<t.attachments.length;i++){
					if(t.attachments[i].type == "link" && (t.attachments[i].link.title || t.attachments[i].link.description)){
						if(t.attachments[i].link.title)out += t.attachments[i].link.title;
						if(t.attachments[i].link.title && t.attachments[i].link.description)out += "<br>";
						if(t.attachments[i].link.description)out += t.attachments[i].link.description;

					}else if(t.attachments[i].type == "album" && (t.attachments[i].album.title || t.attachments[i].album.description)){
						if(t.attachments[i].album.title)out += t.attachments[i].album.title;
						if(t.attachments[i].album.title && t.attachments[i].album.description)out += "<br>";
						if(t.attachments[i].album.description)out += t.attachments[i].album.description;
					}else if(t.attachments[i].type == "video"){
						if(t.attachments[i].video.title)out += t.attachments[i].video.title;
						if(t.attachments[i].video.title && t.attachments[i].video.description)out += "<br>";
						if(t.attachments[i].video.description)out += t.attachments[i].video.description;
					}
				}
				out = limitText(out);
				return out;
			})(t)
		});
	}
	c.innerHTML = innerHTML;
	document.querySelector("div.main").appendChild(c);
	initMsnry();
}

function genCard(data){
	var tmpl = '<a href="#post-{POST_ID}"><div class="card cw4"><div class="author"><div class="photo" style="background-image: url({PROFILE_PHOTO});"></div><div class="name">{USERNAME}</div><div class="time">{TIME}</div></div>{IMAGES}<div class="text">{TEXT}</div></div></a>';
	var cout = tmpl;

	if(typeof data.IMAGE == "string"){
		cout = cout.replace("{IMAGES}", '<div class="images"><div class="image" style="background-image: url({IMAGE});"></div></div>');
	}
	for(k in data){
		cout = cout.replace("{"+k+"}", data[k]);
	}
	var others = ["{POST_ID}", "{PROFILE_PHOTO}", "{USERNAME}", "{TIME}", "{IMAGES}", "{TEXT}", "{IMAGE}"];
	for(var i=0;i<others.length;i++){
		cout = cout.replace(others[i], "");
	}
	return cout;
}

function genPost(data){
	var tmpl = '<div class="post"><div class="author"><div class="photo" style="background-image: url({PROFILE_PHOTO});"></div><div class="name">{USERNAME}</div><div class="time">{TIME}</div></div>{IMAGES}<div class="text">{TEXT}</div></div><div class="attachment">{ATTACHMENT}</div><a class="goto_source" href="http://vk.com/wall{ORIGINAL}">Дивитись оригінал</a>';
	var cout = tmpl;

	if(typeof data.IMAGE == "string"){
		cout = cout.replace("{IMAGES}", '<div class="images"><div class="image" style="background-image: url({IMAGE});"></div></div>');
	}
	for(k in data){
		cout = cout.replace("{"+k+"}", data[k]);
	}
	var others = ["{POST_ID}", "{PROFILE_PHOTO}", "{USERNAME}", "{TIME}", "{IMAGES}", "{TEXT}", "{IMAGE}", "{ORIGINAL}", "{ATTACHMENT}"];
	for(var i=0;i<others.length;i++){
		cout = cout.replace(others[i], "");
	}
	return cout;
}