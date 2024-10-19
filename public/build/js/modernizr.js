/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-webp-setclasses !*/
!function(e,A){function n(e,A){return typeof e===A}function o(e){var A=f.className,n=r._config.classPrefix||"";if(u&&(A=A.baseVal),r._config.enableJSClass){var o=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");A=A.replace(o,"$1"+n+"js$2")}r._config.enableClasses&&(A+=" "+n+e.join(" "+n),u?f.className.baseVal=A:f.className=A)}function a(e,A){if("object"==typeof e)for(var n in e)l(e,n)&&a(n,e[n]);else{var t=(e=e.toLowerCase()).split("."),i=r[t[0]];if(2==t.length&&(i=i[t[1]]),void 0!==i)return r;A="function"==typeof A?A():A,1==t.length?r[t[0]]=A:(!r[t[0]]||r[t[0]]instanceof Boolean||(r[t[0]]=new Boolean(r[t[0]])),r[t[0]][t[1]]=A),o([(A&&0!=A?"":"no-")+t.join("-")]),r._trigger(e,A)}return r}var t=[],i=[],s={_version:"3.6.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,A){var n=this;setTimeout((function(){A(n[e])}),0)},addTest:function(e,A,n){i.push({name:e,fn:A,options:n})},addAsyncTest:function(e){i.push({name:null,fn:e})}},r=function(){};r.prototype=s,r=new r;var l,f=A.documentElement,u="svg"===f.nodeName.toLowerCase();!function(){var e={}.hasOwnProperty;l=n(e,"undefined")||n(e.call,"undefined")?function(e,A){return A in e&&n(e.constructor.prototype[A],"undefined")}:function(A,n){return e.call(A,n)}}(),s._l={},s.on=function(e,A){this._l[e]||(this._l[e]=[]),this._l[e].push(A),r.hasOwnProperty(e)&&setTimeout((function(){r._trigger(e,r[e])}),0)},s._trigger=function(e,A){if(this._l[e]){var n=this._l[e];setTimeout((function(){var e;for(e=0;e<n.length;e++)(0,n[e])(A)}),0),delete this._l[e]}},r._q.push((function(){s.addTest=a})),r.addAsyncTest((function(){function e(e,A,n){function o(A){var o=!(!A||"load"!==A.type)&&1==t.width;a(e,"webp"===e&&o?new Boolean(o):o),n&&n(A)}var t=new Image;t.onerror=o,t.onload=o,t.src=A}var A=[{uri:"data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=",name:"webp"},{uri:"data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA==",name:"webp.alpha"},{uri:"data:image/webp;base64,UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA",name:"webp.animation"},{uri:"data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=",name:"webp.lossless"}],n=A.shift();e(n.name,n.uri,(function(n){if(n&&"load"===n.type)for(var o=0;o<A.length;o++)e(A[o].name,A[o].uri)}))})),function(){var e,A,o,a,s,l;for(var f in i)if(i.hasOwnProperty(f)){if(e=[],(A=i[f]).name&&(e.push(A.name.toLowerCase()),A.options&&A.options.aliases&&A.options.aliases.length))for(o=0;o<A.options.aliases.length;o++)e.push(A.options.aliases[o].toLowerCase());for(a=n(A.fn,"function")?A.fn():A.fn,s=0;s<e.length;s++)1===(l=e[s].split(".")).length?r[l[0]]=a:(!r[l[0]]||r[l[0]]instanceof Boolean||(r[l[0]]=new Boolean(r[l[0]])),r[l[0]][l[1]]=a),t.push((a?"":"no-")+l.join("-"))}}(),o(t),delete s.addTest,delete s.addAsyncTest;for(var c=0;c<r._q.length;c++)r._q[c]();e.Modernizr=r}(window,document);