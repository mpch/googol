<?php 

	if (isset($_GET['lang'])){$langue=strip_tags($_GET['lang']);}else{$langue=strip_tags(lang());}
	clear_cache();// vire les thumbs de plus de trois minutes
	define('LANGUAGE',$langue);
	define('PAUSE_DURATION',60); // minutes
	define('RACINE','http://'.$_SERVER['SERVER_NAME']);
	define('USE_WEB_OF_TRUST',true);
	define('ORANGE_PROXY_URL','');
	define('WOT_URL','http://www.mywot.com/scorecard/');
	define('REGEX_WEB','#(?<=<h3 class="r"><a href="/url\?q=)([^&]+).*?>(.*?)</a>.*?(?<=<span class="st">)(.*?)(?=</span>)#s');
	define('REGEX_PAGES','#&start=([0-9]+)|&start=([0-9]+)#');

	define('REGEX_DATAIMG','#\["(?P<id>.*?)","data:image\/jpeg;base64(?P<dataimg>.*?)"\]#');
	define('REGEX_IMAGE','#imgurl=(?P<imgurl>.*?)&.*?imgrefurl=(?P<srcurl>.*?)&.*?h=(?P<h>.*?)&.*?w=(?P<w>.*?)&.*?tbnid=(?P<id>.*?)&.*?<img data-s.*?="(?P<thmbsrc>.*?)".*?"fn":"(?P<imgfilename>.*?)".*?"os":"(?P<filesize>.*?)".*?"th":(?P<th>[0-9]+).*?"tw":(?P<tw>[0-9]+)#');

	define('REGEX_VID','#(?:<img.*?src="([^"]+)".*?width="([0-9]+)".*?)?<h3 class="r">[^<]*<a href="/url\?q=(.*?)(?:&|&).*?">(.*?)</a>.*?<cite[^>]*>(.*?)</cite>.*?<span class="(?:st|f)">(.*?)(?:</span></td>|</span><br></?div>)#');
	define('REGEX_VID_THMBS','#<img.*?src="([^"]+)".*?width="([0-9]+)"#');
	
	// old regexes (just in case)
	/*
	define('REGEX_IMG','#(?<=imgurl=)(.*?)&imgrefurl=(.*?)&.*?h=([0-9]+)&w=([0-9]+)&sz=([0-9]+)|(?<=imgurl=)(.*?)&imgrefurl=(.*?)&.*?h=([0-9]+)&w=([0-9]+)&sz=([0-9]+)#s');
	define('REGEX_THMBS','#<img.*?height="([0-9]+)".*?src="([^"]+)".*?width="([0-9]+)"#s');
	define('REGEX_IMGTHUMBS','#imgrefurl=([^&]+).*?imgurl=([^&]+).*?w=([0-9]+).*?h=([0-9]+).*?"th":([0-9]+).*?"tu":"(https://[^"]+).*?"tw":([0-9]+)#');
	define('REGEX_DATAIMG',"#\{e\.src='(data:image[^']+).*?ByName\('(.*?)'#");
	define('REGEX_IMGTHUMBS','#imgurl=(.*?)&.*?imgrefurl=(.*?)&.*?h=([0-9]+).*?w=([0-9]+).*?tbnid=(.*?)&#');
	define('REGEX_DATAIMG',"#\{e\.src='(data:image[^']+).*?ByName\('(.*?)'#");
	define('REGEX_IMG','#<div class="rg_di.*?<img class="rg_i" src="([^"]+).*?"tw":([0-9]+), ?"th":([0-9]+).*?imgrefurl=(.*?)&.*?h=#');
	define('REGEX_IMG1','#<div class="rg_di.*?href=".*?imgurl=([^&]+).*?imgrefurl=([^&]+).*?h=([0-9]+).*?w=([0-9]+).*?tbnid=([^&]+).*?"th":([0-9]+).*?"tw":([0-9]+)#');
	define('REGEX_IMG2','#<img.*?data-src="([^"]+).*?name="([^"]+)#');
	define('REGEX_IMG3','#<img.*?class="rg_i.*?src="([^"]+).*?<div class="rg_meta.*?tbnid=([^&]+)#');
	define('REGEX_IMG4',"#\{e\.src='([^']+).*?\('([^']+)#");
	define('REGEX_IMAGE','#"rg_di rg_el ivg-i".*?href="[^\?]*?\?imgurl=([^&]*?).*?imgrefurl=([^&]*?).*?img data-src="([^"]*?).*?<span class="rg_ilmn">([^\<]*?)#');
	
	*/

	define('TPL','<li class="result"><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#link</a>#wot<p class="description">#description</p></li>');
	define('TPLIMG','<div class="image" ><p><a rel="noreferrer" href="#link" title="#link">#thumbs</a></p><p class="description">#W x #H #proxylink #size<a class="source" href="#site" title="#site"> &#9658;</a></p></div>');
	define('TPLVID','<div class="video" ><h3><a rel="noreferrer" href="#link" title="#link">#titre</a></h3><a class="thumb" rel="noreferrer" href="#link" title="#link">#thumbs</a><p class="site">#site</p><p class="description">#description</p></div>');
	define('LOGO1','<a href="'.RACINE.'"><em class="g">G</em><em class="o1">o</em>');
	define('LOGO2','<em class="o2">o</em><em class="g">g</em><em class="o1">o</em><em class="l">l</em></a>');
	define('CAPCHA_DETECT','Our systems have detected unusual traffic from your computer network.');
	define('SAFESEARCH_ON','&safe=on');
	define('SAFESEARCH_IMAGESONLY','&safe=images');
	define('SAFESEARCH_OFF','&safe=off');
	define('SAFESEARCH_LEVEL',SAFESEARCH_OFF);// SAFESEARCH_ON, SAFESEARCH_IMAGESONLY, SAFESEARCH_OFF

	define('URL','https://encrypted.google.com/search?hl='.LANGUAGE.SAFESEARCH_LEVEL.'&id=hp&q=');
	define('URLIMG','&source=lnms&tbm=isch&biw=1920&bih=1075');
	define('URLVID','&tbm=vid');
	define('VERSION','v1.71');
	define('USE_GOOGLE_THUMBS',false);
	define('THEME','style_google.css');

	/* try to re send captcha to google */
	if (!empty($_GET['captcha'])){
		exit('location: '.$bangs['!ddg'].$query);//post_data('https://google.fr',$_POST));
	}



	if (!USE_GOOGLE_THUMBS){ 
		session_start();
		if (!isset($_SESSION['ID'])){$_SESSION['ID']=uniqid();}
		define('UNIQUE_THUMBS_PATH','thumbs/'.$_SESSION['ID']);
		if (!is_dir('thumbs')){mkdir('thumbs');}// crée le dossier thumbs si nécessaire
	}
	$lang['fr']=array(
		'previous'=>strip_tags('Page précédente'),
		'next'=>'Page suivante',
		'Google has received too mutch requests from this IP, try again later or with another version af googol.'=>strip_tags('Google a reçu trop de requêtes de cette IP et la bloque: essaie plus tard !'),
		'The thumbnails are temporarly stored in this server to hide your ip from Google…'=>strip_tags('les miniatures sont temporairement récupérées sur ce serveur, google n\'a pas votre IP…'),
		'Search anonymously on Google (direct links, fake referer, no ads)'=>strip_tags('Rechercher anonymement sur Google (Pas de pubs, liens directs et referrer caché)'),
		'Free and open source (please keep a link to warriordudimanche.net for the author ^^)'=>strip_tags('Libre et open source, merci de laisser un lien vers warriordudimanche.net pour citer l\'auteur ;)'),
		'Googol - google without lies'=>'Googol - google sans mensonge',
		'on GitHub'=>'sur GitHub',
		'no results for'=>strip_tags('pas de résultat pour '),
		'by'=>'par',
		'search '=>'recherche ',
		'Videos'=>strip_tags('Vidéos'),
		'Search'=>'Rechercher',
		'Otherwise, use a real Search engine !'=>'Sinon, utilisez un vrai moteur de recherche !',
		'Filter on'=>strip_tags('Filtre activé'),
		'Filter off'=>strip_tags('Filtre désactivé'),
		'Filter images only'=>strip_tags('Filtre activé sur les images'),
		'red'=>'rouge',
		'yellow'=>'jaune',
		'green'=>'vert',
		'white'=>'blanc',
		'gray'=>'gris',
		'teal'=>'sarcelle',
		'black'=>'noir',
		'pink'=>'rose',
		'blue'=>'bleu',
		'brown'=>'marron',
		'Black_and_white'=>'Noir_et_blanc',
		'Color'=>'couleur',
		'all colors'=>'toutes les couleurs',
		'all sizes'=>'toutes les tailles',
		'Select a color'=>'Filtrer par couleur',
		'Select a size'=>'Filtrer par size',
		'Big'=>'Grande',
		'Medium'=>'Moyenne',
		'Icon'=>'Petite',
		);
	$bangs=array(
		'!ddg'=>'https://duckduckgo.com/?q=',
		'!gi'=>'https://www.google.fr/search?hl=fr&tbm=isch&biw=6366&bih=6628&q=',
		);


	#######################################################################
	## Fonctions
	#######################################################################
	function aff($a,$stop=true,$line=0){echo 'Arret a la ligne '.$line.' du fichier '.__FILE__.'<pre style="text-align:left">';var_dump($a);echo '</pre>';if ($stop){exit();}}
	function my_htmlspecialchars($str) {
		return str_replace(
			array('&', '<', '>', '"'),
			array('&amp;', '&lt;', '&gt;', '&quot;'),
			$str
		);
	}

	function start_pause(){file_put_contents('INACTIVE.ini',date('U'));}
	function still_pause(){
		$since=intval(file_get_contents('INACTIVE.ini'));
		//echo 'depuis '.$since.'// pendant '.PAUSE_DURATION.' min// il est '.date('U').'// jusqua '.($since+(PAUSE_DURATION*60));
		return $since+(PAUSE_DURATION*60)>date('U');
	}
	function proxyfie($str){
		// returns a modified url: complete with ORANGE_PROXY if not empty and
		// hides the url
		if (ORANGE_PROXY_URL){
			$newurl='';
			for($i=0;$i<strlen($str);$i++){
				$newurl.=$str[$i].'0';
			}
			return ORANGE_PROXY_URL.$newurl;
		}else{
			return $str;
		}

	}
	function msg($m){global $lang;if(isset($lang[LANGUAGE][$m])){return $lang[LANGUAGE][$m];}else{return $m;}}
	function lang($default='fr'){if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){$l=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);return substr($l[0],0,2);}else{return $default;}}
	function return_safe_search_level(){
		if (SAFESEARCH_LEVEL==SAFESEARCH_ON){return '<b class="ss_on">'.msg('Filter on').'</b>';}
		if (SAFESEARCH_LEVEL==SAFESEARCH_OFF){return '<b class="ss_off">'.msg('Filter off').'</b>';}
		if (SAFESEARCH_LEVEL==SAFESEARCH_IMAGESONLY){return '<b class="ss_images">'.msg('Filter images only').'</b>';}
	}
	function Random_referer(){
		return array_rand(array(
			'http://oudanstoncul.com.free.fr/‎',
			'http://googlearretedenousfliquer.fr/‎',
			'http://stopspyingme.fr/‎',
			'http://spyyourassfuckinggoogle.fr/‎',
			'http://dontfuckinglookatme.fr/‎',
			'http://matemonculgoogle.fr/‎',
			'http://auxarmescitoyens.fr/‎',
			'http://jetlametsavecdugravier.con/‎',
			'http://lesdeuxpiedsdanstagueule.fr/‎',
			'http://moncoudedanstabouche.con/‎',
			'http://monpieddanston.uk/‎',
			'http://bienfaitpourvosgueul.es/‎',
			'http://pandanstesdents.fr/‎',
			'http://tupuessouslesbras.fr/‎',
			'http://mangetescrottesdenez.fr/‎',
			'http://jtepourristesstats.fr/‎',
			'http://ontecompissevigoureusement.com/‎',
			'http://lepoingleveetlemajeuraussi.com/‎',
		));
	}
	function file_curl_contents($url,$pretend=true){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: UTF-8'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		if (!ini_get("safe_mode") && !ini_get('open_basedir') ) {curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);}
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		if ($pretend){curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0');}
    
		curl_setopt($ch, CURLOPT_REFERER, random_referer());// notez le referer "custom"

		$data = curl_exec($ch);
		$response_headers = curl_getinfo($ch);

		// Google seems to be sending ISO encoded page + htmlentities, why??
		if($response_headers['content_type'] == 'text/html; charset=ISO-8859-1') $data = html_entity_decode(iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $data)); 
		
		# $data = curl_exec($ch);

		curl_close($ch);

		return $data;
	}
	function add_search_engine(){
		if(!is_file('googol.xml')){
			file_put_contents('googol.xml', '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"
			  xmlns:moz="http://www.mozilla.org/2006/browser/search/">
			  <ShortName>Googol</ShortName>
			  <Description>'.msg('Googol - google without lies').'</Description>
			  <InputEncoding>UTF-8</InputEncoding>
			  <Image width="32" height="32">data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABCFJREFUeNrEV21MW2UUfm7v7QcwWqj9YBQyEAdqwBGGY3xkQRlLRjLnsmnUOOOSJYsmxvhDo/7VRH+YaPxhYqLRiAkuccbh5jbFRZgR3IbpwphG0wxaSgOUXgot7W177/V9L/DDrLv3bcK2kzy97e15zz3vOc85573c4bfOY112ruNuyATBKP0iQNVufETwKu6ufElwTFBVtf0ePJzKiwQniQNoLmRVYyUHT5kNT3f7YLbatHtkE4gvr+LsWATT82kEoszm2gVFVZk0K+0qnulwoM7nAG82gxfM2n2OM5HfAjzeYhw76EIuk8HV6zP4engBYoozMmuhKTB8eJ0LeHlvGc74VzHwexyz8f//73NweNBnRU9rJWq3VaBzVwNqKkrwdv9NpHP6Thg6QHfe12TDO6dFiKv5dWaWVIIUhiYDeK4rhid7m+D2utDkm8blKUXXvommQA9HO4rw1Wgai0l9vQ2cGotBSiaQTafwz5xsqC+oOg4+QEIfJrtbTLCTtLyIQyqxjIGLIaZ1gqLcPgVVTko2CxQlxexAx3YbRv4M46cJtjW6HOA4DntaqiApPC5eEzEj6uezs94Kj8OCjy8sMTusG4EbYYlEQMChfU040C1BzmZJzed3wmTiwfE8hq8GYeVFpLKsDuiQIBgDBkcCOLyvEcX2MvC8QMNyW31VUdDbaSNlCbzRH2JMgaJfhv3DIubFcRx5rAZljhItLXkjQJyzFhVrTcphL4aRXaYUbMg5f5Jg0lDv2T0ezdFvfw1CYXaAsRWziN2SwXdDf+FHf2JzSJhPdtaYsbvBjrb6LWuVQsgXislaCn6biOLMeLwge0yzYENe6fPi8UercWUygte+CCK6osBVasKJ/T50tdaiurIcgYifVE+W2aaJMpcFT7U7sL/7ISQlBR9+P4OFeE67T6/vfjONqdA8vF433jvRgupyDqx2TQr5MIKzBDja97A2/3+4NIVEWr5FZ+DnAGQ5h1KnG4c6PGCxS2Gi5WKEtu0lsG0p1UK2nJDy6oz9TQaQlNac7GmrAYtdCiYOVDhthGQ8NnTzrUlKZLqRCNA+QQl5H+FodEVlaUSKoVIimdUeSjshdUZvjSzLWIonCTdkRhISw0b4N5wgRy0JJjIXdjVuzatTZFnrhlkphV/+mAaLXQqmKrgeTCOysKql4f7areh5xH6LTm9zuTaQZkNhnBqZZa4C3U74wfNubKtyacSyWbNYic5rUXj9hRZymhnHkH9t7O7d4cDxJ+oRCUfw5qfXMLcsM/cBrvnIZy+R6yesCw7udqK1wY0ddXbkshJlJObEDM5dmcPg5aVCu/f7AgqcBadHFzVslhTUiu+AZOh54OY9dOAGLcPzBJ+zls0m4izBSXLG0lJwnL4oEnTRxneHdx1bfzUfpD/+E2AAqmeV253DYKAAAAAASUVORK5CYII=</Image>
			  <Url type="text/html" method="get" template="'.RACINE.'">
			  <Param name="q" value="{searchTerms}"/>
			  </Url>
			  <moz:SearchForm>'.RACINE.'</moz:SearchForm> 
			</OpenSearchDescription>');
		}
	}

	function parse_query($query,$start=0){
		global $mode,$filtre;
		if ($mode=='web'){ 
			$page=file_curl_contents(URL.str_replace(' ','+',urlencode($query)).'&start='.$start.'&num=100',false);


			if (stripos($page,CAPCHA_DETECT)!==false){
				start_pause();
				global $bangs;header('location: '.$bangs['!ddg'].$query);
				exit();
			}
			if (!$page){return false;}
			preg_match_all(REGEX_WEB, $page, $r);
			preg_match_all(REGEX_PAGES,$page,$p);
			$p=count($p[2]);

			$retour=array(
				'links'=>$r[1],
				'titles'=>array_map('strip_tags',$r[2]),
				'descriptions'=>array_map('strip_tags',$r[3]),
				'nb_pages'=>$p,
				'current_page'=>$start,
				'query'=>$query,
				'mode'=>$mode
				);

			return $retour;
		}elseif ($mode=='images'){ 			
			if (!empty($filtre)){$f='&tbs='.$filtre;}else{$f='';}
			$page=file_curl_contents(URL.str_replace(' ','+',urlencode($query)).URLIMG.$f.'&ei=zeA3U4vOOaW20wWOr4CoAw&page=3&start=22');
			if (!$page){return false;}			

			preg_match_all(REGEX_DATAIMG,$page,$d);		// gets 19 first img in base64 format (thx google oO)	
			preg_match_all(REGEX_IMAGE,$page,$r);		// gets all other data
			$data=array();
			foreach ($d['id'] as $key=>$id){
				$data[$id]=$d['dataimg'][$key];
			}

			$results=array();
			foreach($r[2] as $key=>$item){
				$results[$key]['urlimg']=$r['imgurl'][$key];
				$results[$key]['urlpage']=$r['srcurl'][$key];
				$results[$key]['imgfilename']=$r['imgfilename'][$key];
				$results[$key]['filesize']=$r['filesize'][$key];
				$results[$key]['h']=$r['h'][$key];
				$results[$key]['w']=$r['w'][$key];
				$results[$key]['th']=$r['th'][$key];
				$results[$key]['tw']=$r['tw'][$key];
				$results[$key]['id']=$r['id'][$key];
				if (!empty($data[$results[$key]['id']])){
					$results[$key]['datatbm']=$data[$results[$key]['id']];
				}else{
					$results[$key]['urltmb']=$r['thmbsrc'][$key];
				}
				
			}
			unset($r);
			unset($d);
			
			$retour=array();$key=0;
			foreach ($results as $id=>$result){
				
				foreach($result as $k=>$r){
					$retour[$k][$key]=$result[$k];
				}				
				$retour['id'][$key]=$id;
				$key++;
			}
			$retour['query']=$query;
			$retour['mode']=$mode;

			return $retour;		
		}elseif($mode=="videos"){
			$page=file_curl_contents(URL.str_replace(' ','+',urlencode($query)).URLVID.'&start='.$start,false);
			if (stripos($page,CAPCHA_DETECT)!==false){
				start_pause();
				global $bangs;header('location: '.$bangs['!ddg'].$query);
				exit();
			}
			if (!$page){return false;}
			preg_match_all(REGEX_VID,$page,$r);
			preg_match_all(REGEX_PAGES,$page,$p);
			$p=count($p[2]);
			$retour=array(
				'site'=>$r[5],
				'titre'=>$r[4],
				'links'=>array_map('urldecode', $r[3]),
				'description'=>$r[6],
				'thumbs'=>$r[1],
				'thumbs_w'=>$r[2],
				'nb_pages'=>$p,
				'current_page'=>$start,
				'query'=>$query,
				'mode'=>$mode
				);
				
			return $retour;		
		}
	}
	function width($w,$h,$nh){return round(($nh*$w)/$h);}
	function render_query($array){
		global $start,$langue,$mode,$couleur,$taille;
		if (!is_array($array)
			||empty($array['urlimg'])&&empty($array['links'])
			)
			{echo '<div class="noresult"> '.msg('no results for').' <em>'.strip_tags($array['query']).'</em> </div>';return false;}

		if ($mode=='web'){
			echo '<ul start="'.$start.'">';
			$nbresultsperpage=100;
			$filtre='';
			foreach ($array['links'] as $nb => $link){
				if (ORANGE_PROXY_URL){$orange_proxy_link='<a class=" wot-exclude" title="proxy" href="'.proxyfie($link).'"> (proxy)</a>';}else{$orange_proxy_link='';}
		
				$r=str_replace('#link',urldecode($link),TPL);
				$r=str_replace('#title',$array['titles'][$nb],$r);
				$d=str_replace('<br>','',$array['descriptions'][$nb].' '.$orange_proxy_link);
				$d=str_replace('<br/>','',$d);
				$r=str_replace('#description',$d,$r);
				if (preg_match('#http://(.*?)/#',$link,$domaine)){
					$domaine='<a class="wot-exclude wot" href="'.WOT_URL.$domaine[1].'" title="View scorecard"> </a>';
					$r=str_replace('#wot',$domaine,$r);
				}else{$r=str_replace('#wot','',$r);}

				echo $r;
			}
			echo '</ul>';
		}elseif ($mode=='images'){
			$nbresultsperpage=20;
			$filtre='&couleur='.$couleur.'&taille='.$taille;
			$common_height=min($array['tw']);
			
			foreach ($array['urlimg'] as $nb => $link){
				if (ORANGE_PROXY_URL){$orange_proxy_link='<a class="o_p wot-exclude" title="proxy" href="'.proxyfie($link).'">&nbsp;</a>';}else{$orange_proxy_link='';}
		
				$r=str_replace('#link',$link,TPLIMG);
				$r=str_replace('#proxylink',$orange_proxy_link,$r);
				$r=str_replace('#H',$array['h'][$nb],$r);
				$r=str_replace('#W',$array['w'][$nb],$r);
				$r=str_replace('#site',$array['urlpage'][$nb],$r);
				$r=str_replace('#size',$array['filesize'][$nb],$r);
				
				
				if (!USE_GOOGLE_THUMBS){
					if (!empty($array['urltmb'][$nb])){
						$repl='<img src="'.grab_google_thumb($array['urltmb'][$nb]).'" style="width:auto;height:'.$common_height.'px;"/>';
					}
					else{
						$repl='<img src="data:image/jpeg;base64'.str_replace('\\u003d','',$array['datatbm'][$nb]).'" style="width:auto;height:'.$common_height.'px;"/>';
					}
				}else if (USE_GOOGLE_THUMBS){
					$repl='<img src="data:image/jpeg;base64'.str_replace('\\u003d','',$array['datatbm'][$nb]).'" style="width:auto;height:'.$common_height.'px;"/>';
				}				
				$r=str_replace('#thumbs',$repl,$r);
				echo $r;
			}	
		}elseif($mode='videos'){ 
			$nbresultsperpage=10;
			$filtre='';
			foreach ($array['links'] as $nb => $link){
				if (ORANGE_PROXY_URL){$orange_proxy_link='<a class="o_p wot-exclude" title="proxy" href="'.proxyfie($link).'">&nbsp;</a>';}else{$orange_proxy_link='';}
		
				$array['description'][$nb]=link2YoutubeUser($array['description'][$nb],$link);
				$r=str_replace('#link',$link,TPLVID);
				$r=str_replace('#titre',$array['titre'][$nb],$r);
				$r=str_replace('#description',$array['description'][$nb].' '.$orange_proxy_link,$r);
				$r=str_replace('#site',$array['site'][$nb],$r);
				if (!USE_GOOGLE_THUMBS){
					$repl='<img src="'.grab_google_thumb($array['thumbs'][$nb]).'" width="'.$array['thumbs_w'][$nb].'" height="'.round($array['thumbs_w'][$nb]/1.33).'"/>';
				}else if (USE_GOOGLE_THUMBS){
					$repl='<img src="'.$array['thumbs'][$nb].'" width="'.$array['thumbs_w'][$nb].'" height="'.round($array['thumbs_w'][$nb]/1.33).'"/>';
				}				
				$r=str_replace('#thumbs',$repl,$r);
				echo $r;
			}

		}

		if(!empty($array['nb_pages'])){
			echo '<hr/><p class="footerlogo">'.LOGO1.str_repeat('<em class="o2">o</em>', $array['nb_pages']-1).LOGO2.'</p><div class="pagination">';
			if ($start>0){echo '<a class="previous" title="'.msg('previous').'" href="?q='.urlencode($array['query']).'&mod='.$mode.'&start='.($start-$nbresultsperpage).'&lang='.$langue.$filtre.'">&#9668;</a>';}
			for ($i=0;$i<$array['nb_pages']-1;$i++){
				if ($i*$nbresultsperpage==$array['current_page']){echo '<em>'.($i+1).'</em>';}
				else{echo '<a href="?q='.urlencode($array['query']).'&mod='.$mode.'&start='.($i*$nbresultsperpage).'&lang='.$langue.$filtre.'">'.($i+1).'</a>';}
			}
			if ($start<($array['nb_pages']-2)*$nbresultsperpage){echo '<a class="next" title="'.msg('next').'" href="?q='.urlencode($array['query']).'&mod='.$mode.'&start='.($start+$nbresultsperpage).'&lang='.$langue.$filtre.'">&#9658;</a>';}
			
			echo  '</div>';
		}
	}
	function grab_google_thumb($link){
		$local = 'thumbs/'.md5($link).'.jpg';

		if(is_file($local)) return $local;

		if($thumb = file_curl_contents($link))
		{
			file_put_contents($local, $thumb);
			return $local;
		}

		return $link;
	}
	function link2YoutubeUser($desc,$link){
		if (stristr($link,'youtube.com')){
			$desc=preg_replace('#([Aa]jout[^ ]+ par )([^<]+)#','$1<a rel="noreferrer" href="http://www.youtube.com/user/$2?feature=watch">$2</a>',$desc);
		};
		return $desc;
	}
	function clear_cache($delay=180){
		$fs=glob('thumbs/*');
		if(!empty($fs)){
			foreach ($fs as $file){
				if (@date('U')-@date(filemtime($file))>$delay){
					unlink ($file);
				}
			}
		}
	}
	function is_active($first,$second){
		if ($first==$second){
			echo 'active';
		}else{
			echo '';
		}
	}
	function handle_bangs($q){
		global $bangs;
		foreach ($bangs as $bang=>$url){
			if ( strtolower( (substr($q,0,strlen($bang)))) ==strtolower($bang)){header('location: '.proxyfie($url.str_replace($bang,'',$q)));exit();}
		}

	}

	#######################################################################
	## Gestion GET
	#######################################################################
	if (isset($_GET['mod'])){$mode=strip_tags($_GET['mod']);}else{$mode='web';}
	if (isset($_GET['start'])){$start=strip_tags($_GET['start']);}else{$start='';}
	if (!empty($_GET['couleur'])&&empty($_GET['taille'])){$filtre=$couleur=strip_tags($_GET['couleur']);$taille='';}
	elseif (!empty($_GET['taille'])&&empty($_GET['couleur'])){$filtre=$taille=strip_tags($_GET['taille']);$couleur='';}
	elseif (!empty($_GET['taille'])&&!empty($_GET['couleur'])){$taille=strip_tags($_GET['taille']);$couleur=strip_tags($_GET['couleur']);$filtre=$couleur.','.$taille;}
	else{$filtre=$taille=$couleur='';}
	if (isset($_GET['q'])){
		if (still_pause()){header('location: '.$bangs['!ddg'].strip_tags($_GET['q']));exit();}
		handle_bangs($_GET['q']);
		$q_raw=$_GET['q'];
		$q_txt=strip_tags($_GET['q']);
		$title=$q_txt.' - Googol '.msg('search ');
		$noqueryclass='';
	}else{
		$q_txt=$q_raw='';$title=msg('Googol - google without lies');
		$noqueryclass=' noqueryclass ';
	}

?>
<!DOCTYPE html>
<html dir="ltr" lang="fr">
<head>
	<title><?php echo $title;?> </title>
	<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if (is_file('favicon.png')){echo '<link rel="shortcut icon" href="favicon.png" /> ';}?>
	<link rel="stylesheet" type="text/css" href="<?php echo THEME;?>"  media="screen" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?php echo msg('Googol - google without lies'); ?>" href="<?php echo RACINE;?>/googol.xml">

	<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->
</head>
<body class="<?php echo $mode;?>">
<header>
	<form action="" method="get" >
		<div class="top">
			<span class="logo <?php echo $noqueryclass;?>"><?php echo LOGO1.LOGO2; ?></span>
			<span>
				<input type="text" name="q" placeholder="<?php echo msg('Search'); ?>" value="<?php  echo $q_txt; ?>"/>
				<input type="submit" value="OK"/>
			</span>

			
			<div class="lang">
				<a class="<?php is_active(LANGUAGE,'fr'); ?>" href="?lang=fr">FR</a> 
				<a class="<?php is_active(LANGUAGE,'en'); ?>" href="?lang=en">EN</a>
			</div><div style="clear:both;"></div>

		</div>

	
		<input type="hidden" name="lang" value="<?php echo LANGUAGE;?>"/>

		<?php

			if ($mode!=''){echo '<input type="hidden" name="mod" value="'.$mode.'"/>';}
			if ($mode=='images'){
				// ajout des options de recherche d'images
				// couleur
				$colors=array(
					''=>msg('all colors'),
					'ic:trans'=>'Transparent',
					'ic:gray'=>msg('Black_and_white'),
					'ic:color'=>msg('Color'),
					'ic:specific,isc:red'=>'red',
					'ic:specific,isc:orange'=>'orange',
					'ic:specific,isc:yellow'=>'yellow',
					'ic:specific,isc:pink'=>'pink',
					'ic:specific,isc:white'=>'white',
					'ic:specific,isc:gray'=>'gray',
					'ic:specific,isc:black'=>'black',
					'ic:specific,isc:brown'=>'brown',
					'ic:specific,isc:green'=>'green',
					'ic:specific,isc:teal'=>'teal',
					'ic:specific,isc:blue'=>'blue',
				);
				echo '<div class="options"><select id="color_selection" name="couleur" class="'.$colors[$couleur].'" title="'.msg('Select a color').'" onChange="change_class(this.options[this.selectedIndex].innerHTML);" >';
				foreach ($colors as $get=>$color){
					if ($get==$couleur){$sel=' selected ';}else{$sel='';}
					echo '<option value="'.$get.'" class="'.$color.'"'.$sel.'>'.msg($color).'</option>';
				}
				echo '</select>';
				unset($colors);
				// tailles
				$sizes=array(
					''=>msg('all sizes'),
					'isz:l'=>msg('Big'),
					'isz:m'=>msg('Medium'),
					'isz:i'=>msg('Icon'),
					'isz:lt,islt:vga'=>'>  640x 480',
					'isz:lt,islt:svga'=>'>  800x 600',
					'isz:lt,islt:xga'=>'> 1024x 768',
					'isz:lt,islt:2mp'=>'> 1600x1200 2mpx',
					'isz:lt,islt:4mp'=>'> 2272x1704 4mpx',
					'isz:lt,islt:6mp'=>'> 2816x2112 6mpx',
					'isz:lt,islt:8mp'=>'> 3264x2448 8mpx',
					'isz:lt,islt:10mp'=>'> 3648x2736 10mpx',
					'isz:lt,islt:12mp'=>'> 4096x3072 12mpx',
					'isz:lt,islt:15mp'=>'> 4480x3360 15mpx',
					'isz:lt,islt:20mp'=>'> 5120x3840 20mpx',
					'isz:lt,islt:40mp'=>'> 7216x5412 40mpx',
					'isz:lt,islt:70mp'=>'> 9600x7200 70mpx',
				);
				echo '<select id="size_selection" name="taille" class="'.$sizes[$taille].'" title="'.msg('Select a size').'">';
				foreach ($sizes as $get=>$size){
					if ($get==$taille){$sel=' selected ';}else{$sel='';}
					echo '<option value="'.$get.'"'.$sel.'>'.$size.'</option>';
				}
				echo '</select></div>';
			}

		?>
	



	</form>
	<p class="msg nomobile <?php echo $noqueryclass;?>">
		<?php 
			echo msg('Search anonymously on Google (direct links, fake referer, no ads)'); 
			if ($mode!='web'){	echo '<br/>'.msg('The thumbnails are temporarly stored in this server to hide your ip from Google…');	} 
		?> 
	</p>
				<nav>
			<?php 
				if ($mode=='web'){echo '<li class="active">Web</li><li><a href="?q='.urlencode($q_raw).'&mod=images&lang='.$langue.'">Images</a></li><li><a href="?q='.urlencode($q_raw).'&mod=videos&lang='.$langue.'">'.msg('Videos').'</a></li>';}
				else if($mode=='images'){echo '<li><a href="?q='.urlencode($q_raw).'&lang='.$langue.'">Web</a></li><li class="active">Images</li><li><a href="?q='.urlencode($q_raw).'&mod=videos&lang='.$langue.'">'.msg('Videos').'</a></li>';}
				else { echo '<li><a href="?q='.urlencode($q_raw).'&lang='.$langue.'">Web</a></li><li><a href="?q='.urlencode($q_raw).'&mod=images&lang='.$langue.'">Images</a></li><li class="active">'.msg('Videos').'</li>';}
			?>	
			</nav>		
</header>

<aside class="<?php echo $noqueryclass.' '.$mode;?>">
	<?php if ($q_raw!=''){render_query(parse_query($q_raw,$start,$mode));} ?>
</aside>
<footer>
	<span class="version"> <?php echo return_safe_search_level(); ?> </span>
		
		<span class="nomobile infos">
			<a href="<?php echo RACINE;?>">Googol <?php echo strip_tags(VERSION);?></a> <?php echo msg('by');?> 
			<a href="http://warriordudimanche.net">Bronco - warriordudimanche.net</a> 
			<a href="https://github.com/broncowdd/googol" title="<?php echo msg('on GitHub');?>" class=" wot-exclude "> GitHub </a>
		</span>
</footer>
<?php if(USE_WEB_OF_TRUST){echo '<script type="text/javascript" src="http://api.mywot.com/widgets/ratings.js"></script>';}?> 
	<script language="javascript"> 
		function change_class(classe) { 
			var btn = document.getElementById("color_selection"); 
			btn.className= classe; 
		} 
	</script>
</body>
</html>
<?php add_search_engine(); ?>
