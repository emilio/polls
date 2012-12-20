(function(window, document){
	var doc_mode = document.documentMode;

	var localStorage = window.localStorage;

	var ua = navigator.userAgent;

	var browser = {
		msie: /*@cc_on!@*/0,
		opera: !! window.opera,
		webkit: ua.indexOf("WebKit") > -1,
		moz: ua.indexOf("Firefox") > -1,
		msieVersion: (function(){
			if( ! this.msie ) return null;
			return parseInt(ua.match(/MSIE\s([0-9]+)/)[1], 10)
		})()
	}

	var doc_el = document.documentElement;

	function trace(data){
		return window.console && console.log(data)
	}

	function forEach( collection, fn ) {
		var i = 0,
			len = collection.length;
		for( ; i < len; i++ ) {
			fn.call(null, collection[i], i, len)
		}
	}

	function create(tag, props){
		var el = document.createElement(tag);
		if( typeof props === 'object' && props !== null){
			for( var i in props ){
				if( i === 'attributes' ){
					for ( var j in props[i] ){
						el.setAttribute(j, props[i][j]);
					}
				}
				else if( i === 'style' ){
					for ( var j  in props[i] ){
						el.style[j] = props[i][j]
					}
				} else {
					el[i] = props[i];
				}
			}
		}
		return el;
	}

	function cargarArchivo(tipo, url, callback, error) {
		var isCSS = tipo === 'css',
			firstScript = $('script')[0],
			loaded = false,
			file;
		callback = callback || null;
		error = error || null;
		// Cargar CSS
		if( isCSS ){
			file = create('link',{
				rel: 'stylesheet',
				type: 'text/css',
				href: url
			});
		} else {
			file = create('script', {
				type: 'text/javascript',
				src: url,
				async: true,
				onerror: error,
				onload: callback,
				onreadystatechange: function(){
					// Sólo funciona si hemos puesto async = true. Esto solo es para IE
					if( file.readyState === "complete" ){
						callback && callback();
					} else if( file.readyState === "loaded" ){
						error && error();
					}
				}
			});
		}

		firstScript.parentNode.insertBefore(file,firstScript)

		return file;
	}

	/************************************************
		Ajax Functions
	*/
	function cargarJson( url, contexto, callback, error){
		var loaded = false,
			// Creamos un callback con un nombre identificatorio
			callbackName = "ajax" + +new Date,
			errorfn = null,
			file;

		// Creamos el callback en el contexto global para ser usado
		window[callbackName] = function(data) {
			// Para detectar posibles errores 503, daremos como mucho 10 segundos al script para cargar
			loaded = true;
			// Ejecutamos el callback
			callback.call(contexto,data);
			file && remove(file);
			// Borramos el script y la función
			window[callbackName] = undefined;
		}
		if( error ){
			errorfn = function(){
				if( ! loaded )
					error.call(contexto);
			}
		}

		// Añadimos el callback dinámicamente
		url = (url + (url.indexOf('?') > -1 ? '&' : '?') + "callback=" + callbackName);

		file = cargarArchivo('js', url, null, errorfn);

		return true
	}

	function createXQR(){
		if( window.XMLHttpRequest ){
			return new window.XMLHttpRequest()
		} else {
			try {
				return new window.ActiveXObject("Microsoft.XMLHTTP");
			} catch( ex ){
				return null;
			}
		}
	}
	function setCookie(name,value,days) {
		var date = new Date(),
		expires;
		if (days) {
			date.setTime(date.getTime()+(days*24*60*60*1000));
			expires = "; expires="+date.toGMTString();
		} else {
			expires = "";
		}
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function ajax(opciones, callbackConString ) {
		var request = createXQR();
		if( request === null ) { return false }

		opciones = typeof opciones === "string" ? {url: opciones, callback: callbackConString} : opciones || {};
		var url = opciones.url,
			metodo = (opciones.metodo || "GET").toUpperCase(),
			callback = opciones.callback,
			error = opciones.error,
			data = opciones.data,
			async = !! opciones.async,
			contexto = opciones.contexto || null;

		if( opciones.cache === false ){
			if (metodo === "GET" && data)
				data += "&_=" + (+new Date);
			else 
				url += ( url.indexOf("?") === -1 ? "?" : "&") + "_=" + (+new Date);
		}
		if( metodo === "GET" && data )
			url += ( url.indexOf("?") === -1 ? "?" : "&") + data;

		request.open(metodo, url, async);
		request.onreadystatechange = function(){
			if( request.readyState === 4 ){
				(request.status === 200 ? callback : error ? error : function(){return}).call(contexto, request.responseText, request)
			}
		}
		if( metodo === "POST" ){
			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		}
		request.send( ( metodo === "POST" && data ) ? data : null )
	}

	/************************************************************
		DOM functions
	***************************************************************/
	function $$(id){
		return document.getElementById(id)
	}
	function $(tag){
		return document.getElementsByTagName(tag);
	}

	function filterByClass(array, clase){
		var result = [], 
			i = 0, 
			len = array.length;
		for( ; i < len; i++ ){
			if( hasClass(array[i], clase) ) result.push(array[i]);
		}
		return result;
	}

	function getByClass(clase, contexto) {
		if( document.querySelector )
			return (contexto || document).querySelectorAll('.' + clase);
		return filterByClass((contexto || document).getElementsByTagName("*"), clase);
	}

	function addEvent(elementos, tipo, funcion ){
		if( ! elementos ){ return false}
		if(  ! elementos.addEventListener && ! elementos.attachEvent && typeof elementos.length === "number" ){
			for( var i = 0, len = elementos.length; i < len; i++){
				addEvent(elementos[i], tipo, funcion)
			};
			return false;
		}
		if(window.addEventListener){
			return elementos.addEventListener(tipo, funcion, false)
		} else {
			elementos.attachEvent('on' + tipo, function(e){
				e = e || window.event;
				e.keyCode = e.keyCode || e.which;
				e.target = e.target || e.srcElement;
				if( ! e.preventDefault ){
					e.preventDefault = function(){
						this.returnValue = false;
					};
					e.stopPropagation = function(){
						this.cancelBubble = true;
					};
				}
				return funcion.call(elementos, e)
			})
		}
	};

	function removeEvent(elementos, tipo, funcion ){
		if( ! elementos ){ return false}
		if(  ! elementos.removeEventListener && ! elementos.detachEvent && typeof elementos.length === "number" ){
			for( var i = 0, len = elementos.length; i < len; i++){
				removeEvent(elementos[i], tipo, funcion)
			};
			return false;
		}
		if(window.removeEventListener){
			return elementos.removeEventListener(tipo, funcion, false)
		} else {
			elementos.detachEvent('on' + tipo, function(e){// Hay que replicar la función completamente :S
				e = e || window.event;
				if( ! e.preventDefault ){
					e.target = e.target || e.srcElement
					e.preventDefault = function(){
						this.returnValue = false;
					};
					e.stopPropagation = function(){
						this.cancelBubble = true;
					};
				}
				return funcion.call(elementos, e)
			})
		}
	};

	/* =trim function
	----------------------------------------- */
	var trim;
	if( ! String.prototype.trim ){
		trim = function(str){
			return str.replace(/(^\s)|(\s$)/g, "")
		}
	} else {
		trim = function(str){
			return str.trim()
		}
	}

	/* =addClass + removeClass + hasClass
	   trying to use native classlist support
	----------------------------------------- */
	var classListSupport = !! document.body.classList,
		addClass, removeClass, hasClass;

	if( classListSupport ){
		addClass = function( el, clase ) {
			return el.classList.add(clase);
		}
		removeClass = function( el, clase ) {
			return el.classList.remove( clase );
		}
		hasClass = function( el, clase ) {
			return el.classList.contains( clase )
		}
	} else {
		addClass = function(el, clase){
			return el.className += " " + clase;
		}
		removeClass = function(el, clase){
			return el.className = trim( el.className.replace( new RegExp("(\\s|^)(" + clase + ")(\\s|$)"), " ") )
		}
		hasClass = function(el, clase){
			return new RegExp("(\\s|^)(" + clase + ")(\\s|$)").test(el.className)
		}
	}// End if classlist support

	var insertAfter = function(cual, detrasDeCual){
		return detrasDeCual.nextSibling ? detrasDeCual.parentNode.insertBefore(cual, detrasDeCual.nextSibling):
			detrasDeCual.parentNode.appendChild(cual)
	}

	/* =Select the next sibling by TagName
	----------------------------------------- */
	var next = function(reference, tag){
		while( reference = reference.nextSibling ){
			if( reference.nodeType !== 3 && (!tag || reference.tagName === tag) ) return reference;
		}
		return false;
	}

	/* =Remove a DOM Object
	----------------------------------------------*/
	function remove( element ){
		if( !element || !element.parentNode ) return false;
		return element.parentNode.removeChild(element)
	}
	function replace( element, otherElement ){
		var helperDiv;
		if( typeof otherElement === "string" ){
			if (element.insertAdjacentHTML){
				element.insertAdjacentHTML("afterend", otherElement)
			} else if( element.outerHTML ){
				element.outerHTML += otherElement
			} else {
				helperDiv = create("div", {
					innerHTML: otherElement
				});
				element.parentNode.insertBefore( helperDiv, element );
			}
		} else if( otherElement.nodeType ) {
			element.parentNode.insertBefore( otherElement, element );
		}
		remove( element );
	}
	/* = windowsizes
	-------------------------------------------------*/
	function winSize(){
		return {
			scrollTop: window.pageYOffset || document.documentElement.scrollTop,
			scrollLeft: window.pageXOffset || document.documentElement.scrollLeft,
			width: window.innerWidth || document.documentElement.clientWidth,
			height: window.innerHeight || document.documentElement.clientHeight
		}
	}

	trace("Se acabó la definición de funciones.")

	window.$e = {
		"byId": $$,
		"byTag": $,
		"byClass": getByClass,
		"winSize": winSize,
		"replace": replace,
		"remove": remove,
		"addClass": addClass,
		"removeClass": removeClass,
		"hasClass": hasClass,
		"create": create,
		"forEach": forEach,
		"addEvent": addEvent,
		"removeEvent": removeEvent,
		"cargarArchivo": cargarArchivo,
		"cargarJson": cargarJson,
		"ajax": ajax,
		"trim": trim,
		"insertAfter": insertAfter,
		"setCookie": setCookie
	}

})(window, window.document)