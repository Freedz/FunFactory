// Prototype compatibility functions
// Mainly here to support moo.ajax.js
// Originally from http://www.prototypejs.org/, version 1.4.0
var Class = {
	create: function() {
		return function() {
			this.initialize.apply(this, arguments);
		}
	}
};

Function.prototype.bind = function(object) {
	var __method = this;
	return function() {
		return __method.apply(object, arguments);
	}
};

//based on prototype's ajax class
//to be used with prototype.lite, moofx.mad4milk.net.

ajax = Class.create();
ajax.prototype = {
	initialize: function(url, options){
		this.transport = this.getTransport();
		this.postBody = options.postBody || '';
		this.method = options.method || 'post';
		this.onComplete = options.onComplete || null;
		this.update = $(options.update) || null;
		this.aborted = false;
		this.request(url);
	},

	request: function(url){
		this.transport.open(this.method, url, true);
		this.transport.onreadystatechange = this.onStateChange.bind(this);
		if (this.method == 'post') {
			this.transport.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			if (this.transport.overrideMimeType) this.transport.setRequestHeader('Connection', 'close');
		}
		this.transport.send(this.postBody);
	},

	onStateChange: function(){
		if(this.aborted)
		{
			this.transport.onreadystatechange = function(){};
			return;
		}
		if (this.transport.readyState == 4 && this.transport.status == 200) {
			if (this.onComplete) 
				setTimeout(function(){this.onComplete(this.transport);}.bind(this), 10);
			if (this.update)
				setTimeout(function(){this.update.innerHTML = this.transport.responseText;}.bind(this), 10);
			this.transport.onreadystatechange = function(){};
		}
	},

	getTransport: function() {
		if (window.ActiveXObject) return new ActiveXObject('Microsoft.XMLHTTP');
		else if (window.XMLHttpRequest) return new XMLHttpRequest();
		else return false;
	},
	
	abort: function() {
		this.aborted=true;
		this.transport.abort();
	}
};
