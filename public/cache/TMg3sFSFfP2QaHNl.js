var key = "TMg3sFSFfP2QaHNl";

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
	xhttp.open('GET', 'http://local.aspire/reg/public/cache/TMg3sFSFfP2QaHNl.html', true);
	
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
	var websiteKey = document.getElementById('required_key').innerHTML;
	var dataVariables = document.querySelectorAll('input[data-variable]');
	
	for(var i in dataVariables){
		//dataVariables[i].oncontextmenu = function() {return false;}
		if(dataVariables[i].type == "text" && val != false){
			if(!/^\d{1,}$/.test(dataVariables[i].value)){
				//alert('Invalid value detected');					
				dataVariables[i].focus();
				return false;
			}
		}
	}
	let collectedData = [];
	
	collectedData["websiteKey"]= websiteKey;
	
	dataVariables.forEach(function(dataVariable){
		dataVar = dataVariable.getAttribute('data-variable');
		collectedData[dataVar] = dataVariable.value;
	});
	
	collectedData["verify"] = val;  //assigns true or false;
	
	let collectedDataString = arrayToString(collectedData);
	let xhttp = new XMLHttpRequest();
	xhttp.open('GET', 'http://local.aspire/reg/public/check?'+collectedDataString, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4) {
			if(this.status == 200){
				var json = JSON.parse(this.responseText);
				if(json.status == "200"){
					
					toggleClass(document.querySelector('.aspire_modal_buttons'), 'avc_disabled');
					toggleClass(document.querySelector('.circle-loader'), 'avc_disabled');
	
					var now = new Date();
					now.setTime(now.getTime() + 1 * 1800 * 1000);
					document.cookie = "avc_ageverified=true; expires=" + now.toUTCString() + "; path=/";
					setTimeout(function(){
						toggleClass(document.querySelector('.circle-loader'), 'load-complete');
						toggleClass(document.querySelector('.checkmark'), 'avc_disabled');	
						setTimeout(function(){						
							toggleClass(document.querySelector('#myAspire-modal'), 'avc_disabled');
							window.location.href = "https://wholesale.aspirevapeco.com";							
						},1000);
					},1000);
				} else if(json.status == "204") {
					window.location.href = "https://google.com";
				} else {
					if(val == true){
						document.write(json.status_message);
					}else{
						if(json.redirect != ""){
							window.location = json.redirect; //todo show message and red X
						} else {
							document.write(json.status_message);
						}
					}
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

function aspire_verifyDOF(evt, val){
	var	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	var dataVariables = document.querySelectorAll('input[data-variable]');
	
	if((val=='mmdd' && (evt.srcElement.value.length + 1) > 2) || (val=='yyyy' && (evt.srcElement.value.length + 1) > 4)){
		if(!/^\d{1,}$/.test(dataVariables[1].value)){				
				dataVariables[1].focus();	
		}else if(!/^\d{1,}$/.test(dataVariables[2].value)){				
				dataVariables[2].focus();	
		}
		return false;
	}
	if ((charCode > 31 && (charCode < 48 || charCode > 57))) {		
		return false;		
	}
	return true;
}

document.addEventListener("DOMContentLoaded", ready);

function ready(){
	if(getCookie('avc_ageverified') != 'true' && !botCheck()){
		var fileref=document.createElement("link");
			fileref.setAttribute("rel", "stylesheet");
			fileref.setAttribute("type", "text/css");
			fileref.setAttribute("href", 'http://local.aspire/reg/public/cache/TMg3sFSFfP2QaHNl.css');
			//document.body.appendChild(fileref);
			document.getElementsByTagName('head')[0].appendChild(fileref);
		var myAspire_modal = document.createElement('div');
			myAspire_modal.setAttribute('id', 'myAspire-modal');
			myAspire_modal.setAttribute('class', 'aspire_modal aspire_bg_cover aspire_display');
			document.body.appendChild(myAspire_modal);

		aspire_loadHtml(myAspire_modal, key);
	}
}
