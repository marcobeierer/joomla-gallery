// This file is part of Shutter Reloaded WordPress plugin. For standalone version visit http://www.laptoptips.ca/javascripts/shutter-reloaded/
var shutterLinks = {}, shutterSets = {};

function shutterAddLoad(fn) {
	if ('undefined' != typeof jQuery) jQuery(document).ready(fn());
	else if( typeof window.onload != 'function' ) window.onload = fn;
	else {oldonld = window.onload; window.onload = function(){if(oldonld){oldonld();};fn();}};
}

shutterReloaded = {

	I : function (a) {
		return document.getElementById(a);
	},

	settings : function(a) { // my modification // hack
		var t = this, s = shutterSettings;

		t.L10n = s.L10n || ['Previous','Next','Close','Full Size','Fit to Screen','Image','of','Loading...'];
		t.imageCount = s.imageCount || 0;
		t.textBtns = s.textBtns || 0;
		t.imgDir = s.imgDir || a; // my modification // hack
		t.FS = s.FS || 0;
		t.oneSet = s.oneSet || 0;
	},

	init : function (a,b) { // my modification // hack
		var t = this, L, T, ext, i, j, m, setid, inset, shfile, shMenuPre, k, img;

		if ( 'object' != typeof shutterSettings ) shutterSettings = {};
		t.settings(b); // my modification // hack

		for ( i = 0, j = document.links.length; i < j; i++ ) {
			L = document.links[i];
			ext = ( L.href.indexOf('?') == -1 ) ? L.href.slice(-4).toLowerCase() : L.href.substring( 0, L.href.indexOf('?') ).slice(-4).toLowerCase();

			if ( a == 'sh' && L.className.toLowerCase().indexOf('shutter') == -1 ) continue; // my modification // hack

			if ( L.className && L.className.toLowerCase().indexOf('shutterset') != -1 )
				setid = L.className.match(/shutterset[^\s]*/g);
			else if ( L.rel && L.rel.toLowerCase().indexOf('lightbox[') != -1 )
				setid = L.rel.replace(/\s/g, '_');
			else if ( t.oneSet )
				setid = 'oneSetForAllLinks';
			else setid = 0, inset = -1;

			if ( setid ) {
				if ( ! shutterSets[setid] ) shutterSets[setid] = [];
				inset = shutterSets[setid].push(i);
			}

			shfile = L.href.slice(L.href.lastIndexOf('/')+1);
			T = ( L.title && L.title != shfile ) ? L.title : '';
			
			if ( !T && L.firstChild && L.firstChild.nodeName == 'IMG' )
				T = L.firstChild.title || '';

			shutterLinks[i] = {link:L.href,num:inset,set:setid,title:T}
			L.onclick = new Function('shutterReloaded.make("'+i+'");return false;');
		}

		if ( ! t.textBtns ) {
			shMenuPre = ['close.gif','prev.gif','prev-d.gif','next.gif','next-d.gif','resize1.gif','resize2.gif','resize-d.gif','loading.gif'];
			for ( k = 0, m = shMenuPre.length; k < m; k++ ) {
				img = new Image();
				img.src = t.imgDir+shMenuPre[k];
			}
		}
	},

	make : function(ln,fs) {
		var t = this, prev, next, prevlink = '', nextlink = '', previmg, nextimg, prevbtn, nextbtn, D, S, NB, fsarg = -1, imgNum, closebtn, fsbtn, fsLink, dv;

		if ( ! t.Top ) {
			if ( typeof window.pageYOffset != 'undefined' ) t.Top = window.pageYOffset;
			else t.Top = (document.documentElement.scrollTop > 0) ? document.documentElement.scrollTop : document.body.scrollTop;
		}

		if ( typeof t.pgHeight == 'undefined' )
			t.pgHeight = Math.max(document.documentElement.scrollHeight,document.body.scrollHeight);

		if ( fs ) t.FS = ( fs > 0 ) ? 1 : 0;
		else t.FS = shutterSettings.FS || 0;

		if ( t.resizing ) t.resizing = null;
		window.onresize = new Function('shutterReloaded.resize("'+ln+'");');

		document.documentElement.style.overflowX = 'hidden';
		if ( ! t.VP ) {
			t._viewPort();
			t.VP = true;
		}

		if ( ! (S = t.I('shShutter')) ) {
			S = document.createElement('div');
			S.setAttribute('id','shShutter');
			document.getElementsByTagName('body')[0].appendChild(S);
			t.hideTags();
		}

		if ( ! (D = t.I('shDisplay')) ) {
			D = document.createElement('div');
			D.setAttribute('id','shDisplay');
			D.style.top = t.Top + 'px';
			document.getElementsByTagName('body')[0].appendChild(D);
		}

		S.style.height = t.pgHeight + 'px';

		dv = t.textBtns ? ' | ' : '';
		if ( shutterLinks[ln].num > 1 ) {
			prev = shutterSets[shutterLinks[ln].set][shutterLinks[ln].num - 2];
			prevbtn = t.textBtns ? t.L10n[0] : '<img src="'+t.imgDir+'prev.gif" title="'+t.L10n[0]+'" />';
			
			if (typeof piwikTracker == 'undefined') {
				prevlink = '<a href="#" onclick="shutterReloaded.make('+prev+');return false">'+prevbtn+'</a>'+dv;
			} else {
				prevlink = '<a href="#" onclick="piwikTracker.trackLink(\''+shutterLinks[ln].link+'\', \'download\');shutterReloaded.make('+prev+');return false">'+prevbtn+'</a>'+dv;
			}
			
			previmg = new Image();
			previmg.src = shutterLinks[prev].link;
		} else {
			prevlink = t.textBtns ? '<span class="srel-d">'+t.L10n[0]+'</span>'+dv : '<img class="srel-d" src="'+t.imgDir+'prev-d.gif" title="'+t.L10n[0]+'" />';
		}

		if ( shutterLinks[ln].num != -1 && shutterLinks[ln].num < (shutterSets[shutterLinks[ln].set].length) ) {
			next = shutterSets[shutterLinks[ln].set][shutterLinks[ln].num];
			nextbtn = t.textBtns ? t.L10n[1] : '<img src="'+t.imgDir+'next.gif" title="'+t.L10n[1]+'" />';
			
			if (typeof piwikTracker == 'undefined') {
				nextlink = '<a href="#" onclick="shutterReloaded.make('+next+');return false">'+nextbtn+'</a>'+dv;
			} else {
				nextlink = '<a href="#" onclick="piwikTracker.trackLink(\''+shutterLinks[ln].link+'\', \'download\');shutterReloaded.make('+next+');return false">'+nextbtn+'</a>'+dv;
			}
			
			nextimg = new Image();
			nextimg.src = shutterLinks[next].link;
		} else {
			nextlink = t.textBtns ? '<span class="srel-d">'+t.L10n[1]+'</span>'+dv : '<img class="srel-d" src="'+t.imgDir+'next-d.gif" title="'+t.L10n[1]+'" />';
		}

		closebtn = t.textBtns ? t.L10n[2] : '<img src="'+t.imgDir+'close.gif" title="'+t.L10n[2]+'" />';

		imgNum = ( (shutterLinks[ln].num > 0) && t.imageCount ) ? ' '+t.L10n[5]+'&nbsp;'+shutterLinks[ln].num+'&nbsp;'+t.L10n[6]+'&nbsp;'+shutterSets[shutterLinks[ln].set].length : '';

		if ( t.FS ) {
			fsbtn = t.textBtns ? t.L10n[4] : '<img src="'+t.imgDir+'resize2.gif" title="'+t.L10n[4]+'"	/>';
		} else {
			fsbtn = t.textBtns ? t.L10n[3] : '<img src="'+t.imgDir+'resize1.gif" title="'+t.L10n[3]+'" />';
			fsarg = 1;
		}

		fsbtn_d = t.textBtns ? '<span class="srel-d">'+t.L10n[3]+'</span>'+dv : '<img class="srel-d" src="'+t.imgDir+'resize-d.gif" title="'+t.L10n[3]+'" />';

		fsLink = '<span id="fullSize"><a href="#" onclick="shutterReloaded.make('+ln+', '+fsarg+');return false">'+fsbtn+'</a>'+dv+'</span><span id="fullSize-d">'+fsbtn_d+'</span>';

		if ( ! (NB = t.I('shNavBar')) ) {
			NB = document.createElement('div');
			NB.setAttribute('id','shNavBar');
			document.getElementsByTagName('body')[0].appendChild(NB);
		}

		NB.innerHTML = dv+prevlink+'<a href="#" onclick="shutterReloaded.hideShutter();return false">'+closebtn+'</a>'+dv+nextlink+fsLink+imgNum;

		D.innerHTML = '<div id="shWrap"><img src="'+shutterLinks[ln].link+'" id="shTopImg" onload="shutterReloaded.showImg();" onclick="shutterReloaded.hideShutter();" /><div id="shTitle">'+shutterLinks[ln].title+'</div></div>';

		window.setTimeout(function(){shutterReloaded.loading();},2000);
	},

	loading : function() {
		var t = this, S, WB, W;
		if ( (W = t.I('shWrap')) && W.style.visibility == 'visible' ) return;
		if ( ! (S = t.I('shShutter')) ) return;
		if ( t.I('shWaitBar') ) return;
		WB = document.createElement('div');
		WB.setAttribute('id','shWaitBar');
		WB.style.top = t.Top + 'px';
		WB.innerHTML = '<img src="'+t.imgDir+'loading.gif" title="'+t.L10n[7]+'" />';
		S.appendChild(WB);
	},

	hideShutter : function() {
		var t = this, D, S, NB;
		if ( D = t.I('shDisplay') ) D.parentNode.removeChild(D);
		if ( S = t.I('shShutter') ) S.parentNode.removeChild(S);
		if ( NB = t.I('shNavBar') ) NB.parentNode.removeChild(NB);
		t.hideTags(true);
		document.documentElement.style.overflowX = '';
		window.scrollTo(0,t.Top);
		window.onresize = t.FS = t.Top = t.VP = null;
	},

	resize : function(ln) {
		var t = this, W;

		if ( t.resizing ) return;
		if ( ! t.I('shShutter') ) return;
		W = t.I('shWrap');
		if ( W ) W.style.visibility = 'hidden';

		window.setTimeout(function(){shutterReloaded.resizing = null},500);
		window.setTimeout(new Function('shutterReloaded.VP = null;shutterReloaded.make("'+ln+'");'),100);
		t.resizing = true;
	},

	_viewPort : function() {
		var t = this, wiH = window.innerHeight ? window.innerHeight : 0, dbH = document.body.clientHeight ? document.body.clientHeight : 0,
			deH = document.documentElement ? document.documentElement.clientHeight : 0, deW, dbW;

		if( wiH > 0 ) {
			t.wHeight = ( (wiH - dbH) > 1 && (wiH - dbH) < 30 ) ? dbH : wiH;
			t.wHeight = ( (t.wHeight - deH) > 1 && (t.wHeight - deH) < 30 ) ? deH : t.wHeight;
		} else t.wHeight = ( deH > 0 ) ? deH : dbH;

		deW = document.documentElement ? document.documentElement.clientWidth : 0;
		dbW = window.innerWidth ? window.innerWidth : document.body.clientWidth;
		t.wWidth = ( deW > 1 ) ? deW : dbW;
	},

	showImg : function() {
		var t = this, S = t.I('shShutter'), D = t.I('shDisplay'), TI = t.I('shTopImg'), T = t.I('shTitle'), NB = t.I('shNavBar'),
			W, WB, capH, shHeight, maxHeight, itop, mtop, resized = 0;

		if ( ! S ) return;
		if ( (W = t.I('shWrap')) && W.style.visibility == 'visible' ) return;
		if ( WB = t.I('shWaitBar') ) WB.parentNode.removeChild(WB);

		S.style.width = D.style.width = '';
		T.style.width = (TI.width - 4) + 'px';

		capH = NB.offsetHeight ? T.offsetHeight + NB.offsetHeight : 30;
		shHeight = t.wHeight - 65 - capH; // my modification // hack

		if ( t.FS ) {
			if ( TI.width > (t.wWidth - 10) )
			S.style.width = D.style.width = TI.width + 10 + 'px';
			document.documentElement.style.overflowX = '';
		} else {
			window.scrollTo(0,t.Top);
			if ( TI.height > shHeight ) {
				TI.width = TI.width * (shHeight / TI.height);
				TI.height = shHeight;
				resized = 1;
			}
			if ( TI.width > (t.wWidth - 16) ) {
				TI.height = TI.height * ((t.wWidth - 16) / TI.width);
				TI.width = t.wWidth - 16;
				resized = 1;
			}
			T.style.width = (TI.width - 4) + 'px';
			NB.style.bottom = '0px';
		}

		maxHeight = t.Top + TI.height + capH + 10;
		if ( maxHeight > t.pgHeight ) S.style.height = maxHeight + 'px';
		window.scrollTo(0,t.Top);

		if ( (t.FS && (TI.height > shHeight || TI.width > t.wWidth)) || resized ) {
			t.I('fullSize').style.display = 'inline';
			t.I('fullSize-d').style.display = 'none';
		}

		itop = (shHeight - TI.height) * 0.45;
		mtop = (itop > 3) ? Math.floor(itop) : 3;
		D.style.top = t.Top + mtop + 40 + 'px'; // my modification // hack
		NB.style.bottom = '0';
		W.style.visibility = 'visible';
	},

	hideTags : function(arg) {
		var sel = document.getElementsByTagName('select'), obj = document.getElementsByTagName('object'),
			emb = document.getElementsByTagName('embed'), ifr = document.getElementsByTagName('iframe'),
			vis = ( arg ) ? 'visible' : 'hidden', i, j;

		for ( i = 0, j = sel.length; i < j; i++ )
			sel[i].style.visibility = vis;

		for ( i = 0, j = obj.length; i < j; i++ )
			obj[i].style.visibility = vis;

		for ( i = 0, j = emb.length; i < j; i++ )
			emb[i].style.visibility = vis;

		for ( i = 0, j = ifr.length; i < j; i++ )
			ifr[i].style.visibility = vis;
	}
}
