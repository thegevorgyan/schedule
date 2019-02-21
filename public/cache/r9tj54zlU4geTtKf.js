var key = "r9tj54zlU4geTtKf";
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

function aspire_loadHtml(elm, key = "default"){	
	
	var xhttp = new XMLHttpRequest();
	xhttp.open('GET', 'http://local.aspire/reg/public/cache/r9tj54zlU4geTtKf.html', true);
	
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var htmltxt = this.responseText;
			elm.innerHTML = htmltxt;			  
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

	var xhttp = new XMLHttpRequest();
	xhttp.open('GET', 'http://local.aspire/reg/public/check?' + collectedDataString, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			if(this.status == 200){
				var json = JSON.parse(this.responseText);
				if(json.status == "200"){
					toggleClass(document.querySelector('.aspire_modal_buttons'), 'avc_disabled');
					toggleClass(document.querySelector('.circle-loader'), 'avc_disabled');
					document.cookie = "aspire_token="+aspire_token;
					setTimeout(function(){			
						modal = document.querySelector('#myAspire-modal');
						setTimeout(function(){
							toggleClass(document.querySelector('#myAspire-modal'), 'avc_disabled');							
						},1000);
					},1000);
				} else if(json.status == "204") {
					window.location.href = "https://google.com";
				} else {
					if(json.redirect != ""){
						window.location = json.redirect; //todo show message and red X
					} else {
						document.write(json.status_message);
					}
				}
				if(json.redirect != ""){
						window.location = json.redirect; //todo show message and red X
				} 
			} else {
				//todo add login if unsable to load resource
			}
		}
	};	
	xhttp.send(); 
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
	aspire_token = keyGenerator();		
	let collectedData = [];	
	
	collectedData["aspire_token"] = getCookie('aspire_token');
	collectedData["website_key"]= key;
	let collectedDataString = arrayToString(collectedData);
		
	if(getCookie('aspire_token') != null && !botCheck()){		
		var xhttp = new XMLHttpRequest();
		xhttp.open('GET', 'http://local.aspire/reg/public/compare?' + collectedDataString, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.onreadystatechange = function() {		
			if (this.readyState == 4 && this.status == 200) {
				let entered = Date.parse(JSON.parse(this.responseText)[0].added_on);
				let sess_timeout = (JSON.parse(this.responseText)[0].session_timeout) * 60 * 1000;
				let now_time = new Date();
				
				if(now_time > entered + sess_timeout){
					now_time.setTime(now_time.getTime() - (1000*60*60*24));
					var expires = "expires=" + now_time.toGMTString();
					document.cookie = "aspire_token"+"="+"; "+expires;
				}		
			}
		};	
		xhttp.send(); 
	}else{
		var fileref=document.createElement("link");
			fileref.setAttribute("rel", "stylesheet");
			fileref.setAttribute("type", "text/css");
			fileref.setAttribute("href", 'http://local.aspire/reg/public/cache/r9tj54zlU4geTtKf.css');
			document.getElementsByTagName('head')[0].appendChild(fileref);
		var myAspire_modal = document.createElement('div');
			myAspire_modal.setAttribute('id', 'myAspire-modal');
			myAspire_modal.setAttribute('class', 'aspire_modal aspire_bg_cover aspire_display');
			document.body.appendChild(myAspire_modal);
			
		aspire_loadHtml(myAspire_modal, key);		
	}
}
