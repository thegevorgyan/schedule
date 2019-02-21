var key = "SRKBaRBdCHNVpbD4";
var aspire_token = '';

function botCheck(){
var botPattern = "(googlebot\/|Googlebot-Mobile|Googlebot-Image|Google favicon|Mediapartners-Google|bingbot|slurp|java|wget|curl|Commons-HttpClient|Python-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks-robot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j-asr|Domain Re-Animator Bot|AddThis)";
          var re = new RegExp(botPattern, 'i');
          var userAgent = navigator.userAgent;
          if (re.test(userAgent)) {
              return true;
          }else{
            return false;
          }
}

var getCks = function(){
  var pairs = document.cookie.split(";");
  var cks = {};
  for (var i=0; i<pairs.length; i++){
    var pair = pairs[i].split("=");
    cks[(pair[0]+'').trim()] = unescape(pair[1]);
  }
  return cks;
}

function keyGenerator() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 32; i++)
          text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
}

function toggleClass(element, className){
    if (!element || !className){
        return;
    }
 
    var classString = element.className, nameIndex = classString.indexOf(className);
    if (nameIndex == -1) {
        classString += ' ' + className;
    }
    else {
        classString = classString.substr(0, nameIndex) + classString.substr(nameIndex+className.length);
    }
    element.className = classString;
}

function getCookie(name){
	var re = new RegExp(name + '=([^;]+)');
	var value = re.exec(document.cookie);
	return (value != null) ? unescape(value[1]) : null;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ";"+"path="+"/";
} 

function readCookie(name) {
	let aspire_cookie = [];
	let ca = document.cookie.split(';');

	for(let i=0;i < ca.length;i++) {
		if(ca[i].search('aspire_token') != - 1){
			aspire_cookie.push(ca[i]);			
		}
	}
	if( aspire_cookie.length > 1){
		eraseCookieFromAllPaths('aspire_token');
	}
}

function eraseCookieFromAllPaths(name) {
    // This function will attempt to remove a cookie from all paths.
    var pathBits = location.pathname.split('/');
    var pathCurrent = ' path=';

    // do a simple pathless delete first.
    document.cookie = name + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT;';

    for (var i = 0; i < pathBits.length; i++) {
        pathCurrent += ((pathCurrent.substr(-1) != '/') ? '/' : '') + pathBits[i];
        document.cookie = name + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT;' + pathCurrent + ';';
    }
}

function aspire_loadHtml(elm, key = "default"){	
	
	var xhttp = new XMLHttpRequest();
	xhttp.open('GET', 'http://local.aspire/reg/public/cache/SRKBaRBdCHNVpbD4.html', true);	
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var htmltxt = this.responseText;
			elm.innerHTML = htmltxt;
			if(document.getElementById("termsCond").style.display=='none'){
				if(document.getElementById("mmInput") == null){
					document.getElementById("aspire_modal_confirm").disabled = false;
				}
			}			
		}		
	};
	xhttp.send(); 
}

function aspire_processData(val){
	let websiteKey = document.getElementById('required_key').innerHTML;	
	let collectedData = [];
	
	collectedData["websiteKey"]= websiteKey;
	collectedData["verify"] = val;
	collectedData["aspire_token"] = aspire_token;
	
	let collectedDataString = arrayToString(collectedData);

	let xhttp = new XMLHttpRequest();
	xhttp.open('GET', 'http://local.aspire/reg/public/check?' + collectedDataString, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			if(this.status == 200){
				var json = JSON.parse(this.responseText);
				if(json.status == "200"){
					toggleClass(document.querySelector('.aspire_modal_buttons'), 'avc_disabled');
					toggleClass(document.querySelector('.circle-loader'), 'avc_disabled');
					
					setCookie("aspire_token", aspire_token, 365);				
					
					setTimeout(function(){
						toggleClass(document.querySelector('.circle-loader'), 'load-complete');
						toggleClass(document.querySelector('.checkmark'), 'avc_disabled');	
						setTimeout(function(){
							toggleClass(document.querySelector('#myAspire-modal'), 'avc_disabled');

							let storedData = [];							
								storedData["website_key"]= websiteKey;
								storedData["aspire_token"] = aspire_token;
								storedData["cks"] = JSON.stringify(getCks());	
							let storedDataString = arrayToString(storedData);						
							let xhr = new XMLHttpRequest();							
							xhr.open('GET', 'http://local.aspire/reg/public/storage?' + storedDataString, true);
							xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
							xhr.send(); 	
					
							if(json.redirect != ""){
								window.location = json.redirect;
							}
						},1000);						
					},1000);
				} else if(json.status == "204") {
					"" != "" ? window.location.href = "" : document.write(json.status_message);
				}
			} else {
				setCookie("aspire_token", aspire_token, 365);
			}
		}
	};	
	xhttp.send(); 
}

function showPopup(){
	var fileref=document.createElement("link");
			fileref.setAttribute("rel", "stylesheet");
			fileref.setAttribute("type", "text/css");
			fileref.setAttribute("href", 'http://local.aspire/reg/public/cache/SRKBaRBdCHNVpbD4.css');
			document.getElementsByTagName('head')[0].appendChild(fileref);
		var myAspire_modal = document.createElement('div');
			myAspire_modal.setAttribute('id', 'myAspire-modal');
			myAspire_modal.setAttribute('class', 'aspire_modal aspire_bg_cover aspire_display');
			document.body.appendChild(myAspire_modal);

		aspire_loadHtml(myAspire_modal, key);
}

function arrayToString (arr){
	let getString = "";

	Object.keys(arr).forEach(function(elm){
		if (getString == ""){
			getString += elm+"="+arr[elm];
		} else {
			getString +="&"+elm+"="+arr[elm];
		}
	});	
	return getString;
}

document.addEventListener("DOMContentLoaded", ready);

function ready(){		

	readCookie('aspire_token');
		
	let collectedData = [];	
	let created_new_token = false;
	aspire_token = getCookie("aspire_token");
	
	if(aspire_token == null){
		created_new_token = true;
		aspire_token = keyGenerator();	
	}

	collectedData["aspire_token"] = aspire_token;
	collectedData["website_key"]= key;
	let collectedDataString = arrayToString(collectedData);

	if(!created_new_token){
			
		var xhttp = new XMLHttpRequest();
		xhttp.open('GET', 'http://local.aspire/reg/public/compare?' + collectedDataString, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.onreadystatechange = function() {		
			if (this.readyState == 4 && this.status == 200) {
				//console.log(this.responseText);
				let jsonresponse = JSON.parse(this.responseText)[0];
				let session_status = jsonresponse.status;
				let regenerate_token = jsonresponse.regenerate;
				
				if(session_status == "ok"){
					//console.log(this.responseText);									
				} else {
					if(regenerate_token){
						aspire_token = keyGenerator();
						collectedData["aspire_token"] = aspire_token; // regenerate token
					}
					showPopup();
				}
					
			}
		};	
		xhttp.send(); 
	}else{
		showPopup();
	}
}

function jumpNext(evt,x,y) {	
	var	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	if(charCode==229){		
		charCode=event.target.value.charAt(event.target.selectionStart - 1).charCodeAt();
	}
	if (charCode!=32 && charCode!=8 && charCode!=9 && (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 95 || charCode > 105))) {	
		return false;		
	}
	var inputMonth = document.getElementById("mmInput");
	var aspire_modal_confirm=document.getElementById("aspire_modal_confirm");
	var chkBox=document.getElementById("chkBox");

	var next=x.tabIndex;

	if((x.tabIndex==4) && (charCode==13) && (document.getElementById('termsCond').style.display == 'block')){
		chkBox.checked = true;
	 	aspire_modal_confirm.disabled = false;
		document.getElementById("aspire_chkMark").style.backgroundColor="#2196F3";
	 	document.getElementById("chkBox").style.display="block";
	 	aspire_modal_confirm.focus();
	}
	if(document.getElementById("termsCond").style.display=='block'){
		if(chkBox.checked && inputMonth==null ) {
			aspire_modal_confirm.disabled=false;
			aspire_modal_confirm.focus();
		}
	}
	if(document.getElementById("termsCond").style.display=='block'){
		if(chkBox.checked==false && inputMonth == null){
			aspire_modal_confirm.disabled=true;
		}
	}
	return true;
}
