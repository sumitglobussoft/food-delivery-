var mod_pagespeed_1zoWVmnHMl = "!function(a){\"function\"==typeof define&&define.amd?define([\"jquery\"],a):a(jQuery)}(function(a){function b(b,d){var e,f,g,h=b.nodeName.toLowerCase();return\"area\"===h?(e=b.parentNode,f=e.name,b.href&&f&&\"map\"===e.nodeName.toLowerCase()?(g=a(\"img[usemap='#\"+f+\"']\")[0],!!g&&c(g)):!1):(/input|select|textarea|button|object/.test(h)?!b.disabled:\"a\"===h?b.href||d:d)&&c(b)}function c(b){return a.expr.filters.visible(b)&&!a(b).parents().addBack().filter(function(){return\"hidden\"===a.css(this,\"visibility\")}).length}a.ui=a.ui||{},a.extend(a.ui,{version:\"@VERSION\",keyCode:{BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}}),a.fn.extend({scrollParent:function(){var b=this.css(\"position\"),c=\"absolute\"===b,d=this.parents().filter(function(){var b=a(this);return c&&\"static\"===b.css(\"position\")?!1:/(auto|scroll)/.test(b.css(\"overflow\")+b.css(\"overflow-y\")+b.css(\"overflow-x\"))}).eq(0);return\"fixed\"!==b&&d.length?d:a(this[0].ownerDocument||document)},uniqueId:function(){var a=0;return function(){return this.each(function(){this.id||(this.id=\"ui-id-\"+ ++a)})}}(),removeUniqueId:function(){return this.each(function(){/^ui-id-\\d+$/.test(this.id)&&a(this).removeAttr(\"id\")})}}),a.extend(a.expr[\":\"],{data:a.expr.createPseudo?a.expr.createPseudo(function(b){return function(c){return!!a.data(c,b)}}):function(b,c,d){return!!a.data(b,d[3])},focusable:function(c){return b(c,!isNaN(a.attr(c,\"tabindex\")))},tabbable:function(c){var d=a.attr(c,\"tabindex\"),e=isNaN(d);return(e||d>=0)&&b(c,!e)}}),a(\"<a>\").outerWidth(1).jquery||a.each([\"Width\",\"Height\"],function(b,c){function d(b,c,d,f){return a.each(e,function(){c-=parseFloat(a.css(b,\"padding\"+this))||0,d&&(c-=parseFloat(a.css(b,\"border\"+this+\"Width\"))||0),f&&(c-=parseFloat(a.css(b,\"margin\"+this))||0)}),c}var e=\"Width\"===c?[\"Left\",\"Right\"]:[\"Top\",\"Bottom\"],f=c.toLowerCase(),g={innerWidth:a.fn.innerWidth,innerHeight:a.fn.innerHeight,outerWidth:a.fn.outerWidth,outerHeight:a.fn.outerHeight};a.fn[\"inner\"+c]=function(b){return void 0===b?g[\"inner\"+c].call(this):this.each(function(){a(this).css(f,d(this,b)+\"px\")})},a.fn[\"outer\"+c]=function(b,e){return\"number\"!=typeof b?g[\"outer\"+c].call(this,b):this.each(function(){a(this).css(f,d(this,b,!0,e)+\"px\")})}}),a.fn.addBack||(a.fn.addBack=function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}),a(\"<a>\").data(\"a-b\",\"a\").removeData(\"a-b\").data(\"a-b\")&&(a.fn.removeData=function(b){return function(c){return arguments.length?b.call(this,a.camelCase(c)):b.call(this)}}(a.fn.removeData)),a.ui.ie=!!/msie [\\w.]+/.exec(navigator.userAgent.toLowerCase()),a.fn.extend({focus:function(b){return function(c,d){return\"number\"==typeof c?this.each(function(){var b=this;setTimeout(function(){a(b).focus(),d&&d.call(b)},c)}):b.apply(this,arguments)}}(a.fn.focus),disableSelection:function(){var a=\"onselectstart\"in document.createElement(\"div\")?\"selectstart\":\"mousedown\";return function(){return this.bind(a+\".ui-disableSelection\",function(a){a.preventDefault()})}}(),enableSelection:function(){return this.unbind(\".ui-disableSelection\")},zIndex:function(b){if(void 0!==b)return this.css(\"zIndex\",b);if(this.length)for(var c,d,e=a(this[0]);e.length&&e[0]!==document;){if(c=e.css(\"position\"),(\"absolute\"===c||\"relative\"===c||\"fixed\"===c)&&(d=parseInt(e.css(\"zIndex\"),10),!isNaN(d)&&0!==d))return d;e=e.parent()}return 0}}),a.ui.plugin={add:function(b,c,d){var e,f=a.ui[b].prototype;for(e in d)f.plugins[e]=f.plugins[e]||[],f.plugins[e].push([c,d[e]])},call:function(a,b,c,d){var e,f=a.plugins[b];if(f&&(d||a.element[0].parentNode&&11!==a.element[0].parentNode.nodeType))for(e=0;e<f.length;e++)a.options[f[e][0]]&&f[e][1].apply(a.element,c)}}});";
var mod_pagespeed_otcmAQFYko = "!function(a){\"function\"==typeof define&&define.amd?define([\"jquery\"],a):a(jQuery)}(function(a){var b=0,c=Array.prototype.slice;return a.cleanData=function(b){return function(c){var d,e,f;for(f=0;null!=(e=c[f]);f++)try{d=a._data(e,\"events\"),d&&d.remove&&a(e).triggerHandler(\"remove\")}catch(g){}b(c)}}(a.cleanData),a.widget=function(b,c,d){var e,f,g,h,i={},j=b.split(\".\")[0];return b=b.split(\".\")[1],e=j+\"-\"+b,d||(d=c,c=a.Widget),a.expr[\":\"][e.toLowerCase()]=function(b){return!!a.data(b,e)},a[j]=a[j]||{},f=a[j][b],g=a[j][b]=function(a,b){return this._createWidget?void(arguments.length&&this._createWidget(a,b)):new g(a,b)},a.extend(g,f,{version:d.version,_proto:a.extend({},d),_childConstructors:[]}),h=new c,h.options=a.widget.extend({},h.options),a.each(d,function(b,d){return a.isFunction(d)?void(i[b]=function(){var a=function(){return c.prototype[b].apply(this,arguments)},e=function(a){return c.prototype[b].apply(this,a)};return function(){var b,c=this._super,f=this._superApply;return this._super=a,this._superApply=e,b=d.apply(this,arguments),this._super=c,this._superApply=f,b}}()):void(i[b]=d)}),g.prototype=a.widget.extend(h,{widgetEventPrefix:f?h.widgetEventPrefix||b:b},i,{constructor:g,namespace:j,widgetName:b,widgetFullName:e}),f?(a.each(f._childConstructors,function(b,c){var d=c.prototype;a.widget(d.namespace+\".\"+d.widgetName,g,c._proto)}),delete f._childConstructors):c._childConstructors.push(g),a.widget.bridge(b,g),g},a.widget.extend=function(b){for(var d,e,f=c.call(arguments,1),g=0,h=f.length;h>g;g++)for(d in f[g])e=f[g][d],f[g].hasOwnProperty(d)&&void 0!==e&&(a.isPlainObject(e)?b[d]=a.isPlainObject(b[d])?a.widget.extend({},b[d],e):a.widget.extend({},e):b[d]=e);return b},a.widget.bridge=function(b,d){var e=d.prototype.widgetFullName||b;a.fn[b]=function(f){var g=\"string\"==typeof f,h=c.call(arguments,1),i=this;return f=!g&&h.length?a.widget.extend.apply(null,[f].concat(h)):f,g?this.each(function(){var c,d=a.data(this,e);return\"instance\"===f?(i=d,!1):d?a.isFunction(d[f])&&\"_\"!==f.charAt(0)?(c=d[f].apply(d,h),c!==d&&void 0!==c?(i=c&&c.jquery?i.pushStack(c.get()):c,!1):void 0):a.error(\"no such method '\"+f+\"' for \"+b+\" widget instance\"):a.error(\"cannot call methods on \"+b+\" prior to initialization; attempted to call method '\"+f+\"'\")}):this.each(function(){var b=a.data(this,e);b?(b.option(f||{}),b._init&&b._init()):a.data(this,e,new d(f,this))}),i}},a.Widget=function(){},a.Widget._childConstructors=[],a.Widget.prototype={widgetName:\"widget\",widgetEventPrefix:\"\",defaultElement:\"<div>\",options:{disabled:!1,create:null},_createWidget:function(c,d){d=a(d||this.defaultElement||this)[0],this.element=a(d),this.uuid=b++,this.eventNamespace=\".\"+this.widgetName+this.uuid,this.options=a.widget.extend({},this.options,this._getCreateOptions(),c),this.bindings=a(),this.hoverable=a(),this.focusable=a(),d!==this&&(a.data(d,this.widgetFullName,this),this._on(!0,this.element,{remove:function(a){a.target===d&&this.destroy()}}),this.document=a(d.style?d.ownerDocument:d.document||d),this.window=a(this.document[0].defaultView||this.document[0].parentWindow)),this._create(),this._trigger(\"create\",null,this._getCreateEventData()),this._init()},_getCreateOptions:a.noop,_getCreateEventData:a.noop,_create:a.noop,_init:a.noop,destroy:function(){this._destroy(),this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(a.camelCase(this.widgetFullName)),this.widget().unbind(this.eventNamespace).removeAttr(\"aria-disabled\").removeClass(this.widgetFullName+\"-disabled ui-state-disabled\"),this.bindings.unbind(this.eventNamespace),this.hoverable.removeClass(\"ui-state-hover\"),this.focusable.removeClass(\"ui-state-focus\")},_destroy:a.noop,widget:function(){return this.element},option:function(b,c){var d,e,f,g=b;if(0===arguments.length)return a.widget.extend({},this.options);if(\"string\"==typeof b)if(g={},d=b.split(\".\"),b=d.shift(),d.length){for(e=g[b]=a.widget.extend({},this.options[b]),f=0;f<d.length-1;f++)e[d[f]]=e[d[f]]||{},e=e[d[f]];if(b=d.pop(),1===arguments.length)return void 0===e[b]?null:e[b];e[b]=c}else{if(1===arguments.length)return void 0===this.options[b]?null:this.options[b];g[b]=c}return this._setOptions(g),this},_setOptions:function(a){var b;for(b in a)this._setOption(b,a[b]);return this},_setOption:function(a,b){return this.options[a]=b,\"disabled\"===a&&(this.widget().toggleClass(this.widgetFullName+\"-disabled\",!!b),b&&(this.hoverable.removeClass(\"ui-state-hover\"),this.focusable.removeClass(\"ui-state-focus\"))),this},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_on:function(b,c,d){var e,f=this;\"boolean\"!=typeof b&&(d=c,c=b,b=!1),d?(c=e=a(c),this.bindings=this.bindings.add(c)):(d=c,c=this.element,e=this.widget()),a.each(d,function(d,g){function h(){return b||f.options.disabled!==!0&&!a(this).hasClass(\"ui-state-disabled\")?(\"string\"==typeof g?f[g]:g).apply(f,arguments):void 0}\"string\"!=typeof g&&(h.guid=g.guid=g.guid||h.guid||a.guid++);var i=d.match(/^([\\w:-]*)\\s*(.*)$/),j=i[1]+f.eventNamespace,k=i[2];k?e.delegate(k,j,h):c.bind(j,h)})},_off:function(a,b){b=(b||\"\").split(\" \").join(this.eventNamespace+\" \")+this.eventNamespace,a.unbind(b).undelegate(b)},_delay:function(a,b){function c(){return(\"string\"==typeof a?d[a]:a).apply(d,arguments)}var d=this;return setTimeout(c,b||0)},_hoverable:function(b){this.hoverable=this.hoverable.add(b),this._on(b,{mouseenter:function(b){a(b.currentTarget).addClass(\"ui-state-hover\")},mouseleave:function(b){a(b.currentTarget).removeClass(\"ui-state-hover\")}})},_focusable:function(b){this.focusable=this.focusable.add(b),this._on(b,{focusin:function(b){a(b.currentTarget).addClass(\"ui-state-focus\")},focusout:function(b){a(b.currentTarget).removeClass(\"ui-state-focus\")}})},_trigger:function(b,c,d){var e,f,g=this.options[b];if(d=d||{},c=a.Event(c),c.type=(b===this.widgetEventPrefix?b:this.widgetEventPrefix+b).toLowerCase(),c.target=this.element[0],f=c.originalEvent)for(e in f)e in c||(c[e]=f[e]);return this.element.trigger(c,d),!(a.isFunction(g)&&g.apply(this.element[0],[c].concat(d))===!1||c.isDefaultPrevented())}},a.each({show:\"fadeIn\",hide:\"fadeOut\"},function(b,c){a.Widget.prototype[\"_\"+b]=function(d,e,f){\"string\"==typeof e&&(e={effect:e});var g,h=e?e===!0||\"number\"==typeof e?c:e.effect||c:b;e=e||{},\"number\"==typeof e&&(e={duration:e}),g=!a.isEmptyObject(e),e.complete=f,e.delay&&d.delay(e.delay),g&&a.effects&&a.effects.effect[h]?d[b](e):h!==b&&d[h]?d[h](e.duration,e.easing,f):d.queue(function(c){a(this)[b](),f&&f.call(d[0]),c()})}}),a.widget});";
var mod_pagespeed_fitQ77XDyY = "!function(a){\"function\"==typeof define&&define.amd?define([\"jquery\",\"./widget\"],a):a(jQuery)}(function(a){var b=!1;return a(document).mouseup(function(){b=!1}),a.widget(\"ui.mouse\",{version:\"@VERSION\",options:{cancel:\"input,textarea,button,select,option\",distance:1,delay:0},_mouseInit:function(){var b=this;this.element.bind(\"mousedown.\"+this.widgetName,function(a){return b._mouseDown(a)}).bind(\"click.\"+this.widgetName,function(c){return!0===a.data(c.target,b.widgetName+\".preventClickEvent\")?(a.removeData(c.target,b.widgetName+\".preventClickEvent\"),c.stopImmediatePropagation(),!1):void 0}),this.started=!1},_mouseDestroy:function(){this.element.unbind(\".\"+this.widgetName),this._mouseMoveDelegate&&this.document.unbind(\"mousemove.\"+this.widgetName,this._mouseMoveDelegate).unbind(\"mouseup.\"+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(c){if(!b){this._mouseStarted&&this._mouseUp(c),this._mouseDownEvent=c;var d=this,e=1===c.which,f=\"string\"==typeof this.options.cancel&&c.target.nodeName?a(c.target).closest(this.options.cancel).length:!1;return e&&!f&&this._mouseCapture(c)?(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){d.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(c)&&this._mouseDelayMet(c)&&(this._mouseStarted=this._mouseStart(c)!==!1,!this._mouseStarted)?(c.preventDefault(),!0):(!0===a.data(c.target,this.widgetName+\".preventClickEvent\")&&a.removeData(c.target,this.widgetName+\".preventClickEvent\"),this._mouseMoveDelegate=function(a){return d._mouseMove(a)},this._mouseUpDelegate=function(a){return d._mouseUp(a)},this.document.bind(\"mousemove.\"+this.widgetName,this._mouseMoveDelegate).bind(\"mouseup.\"+this.widgetName,this._mouseUpDelegate),c.preventDefault(),b=!0,!0)):!0}},_mouseMove:function(b){return a.ui.ie&&(!document.documentMode||document.documentMode<9)&&!b.button?this._mouseUp(b):b.which?this._mouseStarted?(this._mouseDrag(b),b.preventDefault()):(this._mouseDistanceMet(b)&&this._mouseDelayMet(b)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,b)!==!1,this._mouseStarted?this._mouseDrag(b):this._mouseUp(b)),!this._mouseStarted):this._mouseUp(b)},_mouseUp:function(c){return this.document.unbind(\"mousemove.\"+this.widgetName,this._mouseMoveDelegate).unbind(\"mouseup.\"+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,c.target===this._mouseDownEvent.target&&a.data(c.target,this.widgetName+\".preventClickEvent\",!0),this._mouseStop(c)),b=!1,!1},_mouseDistanceMet:function(a){return Math.max(Math.abs(this._mouseDownEvent.pageX-a.pageX),Math.abs(this._mouseDownEvent.pageY-a.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}})});";
var mod_pagespeed_xDafkDsCT5 = "!function(a){\"function\"==typeof define&&define.amd?define([\"jquery\"],a):a(jQuery)}(function(a){return function(){function b(a,b,c){return[parseFloat(a[0])*(n.test(a[0])?b/100:1),parseFloat(a[1])*(n.test(a[1])?c/100:1)]}function c(b,c){return parseInt(a.css(b,c),10)||0}function d(b){var c=b[0];return 9===c.nodeType?{width:b.width(),height:b.height(),offset:{top:0,left:0}}:a.isWindow(c)?{width:b.width(),height:b.height(),offset:{top:b.scrollTop(),left:b.scrollLeft()}}:c.preventDefault?{width:0,height:0,offset:{top:c.pageY,left:c.pageX}}:{width:b.outerWidth(),height:b.outerHeight(),offset:b.offset()}}a.ui=a.ui||{};var e,f,g=Math.max,h=Math.abs,i=Math.round,j=/left|center|right/,k=/top|center|bottom/,l=/[\\+\\-]\\d+(\\.[\\d]+)?%?/,m=/^\\w+/,n=/%$/,o=a.fn.position;a.position={scrollbarWidth:function(){if(void 0!==e)return e;var b,c,d=a(\"<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>\"),f=d.children()[0];return a(\"body\").append(d),b=f.offsetWidth,d.css(\"overflow\",\"scroll\"),c=f.offsetWidth,b===c&&(c=d[0].clientWidth),d.remove(),e=b-c},getScrollInfo:function(b){var c=b.isWindow||b.isDocument?\"\":b.element.css(\"overflow-x\"),d=b.isWindow||b.isDocument?\"\":b.element.css(\"overflow-y\"),e=\"scroll\"===c||\"auto\"===c&&b.width<b.element[0].scrollWidth,f=\"scroll\"===d||\"auto\"===d&&b.height<b.element[0].scrollHeight;return{width:f?a.position.scrollbarWidth():0,height:e?a.position.scrollbarWidth():0}},getWithinInfo:function(b){var c=a(b||window),d=a.isWindow(c[0]),e=!!c[0]&&9===c[0].nodeType;return{element:c,isWindow:d,isDocument:e,offset:c.offset()||{left:0,top:0},scrollLeft:c.scrollLeft(),scrollTop:c.scrollTop(),width:d||e?c.width():c.outerWidth(),height:d||e?c.height():c.outerHeight()}}},a.fn.position=function(e){if(!e||!e.of)return o.apply(this,arguments);e=a.extend({},e);var n,p,q,r,s,t,u=a(e.of),v=a.position.getWithinInfo(e.within),w=a.position.getScrollInfo(v),x=(e.collision||\"flip\").split(\" \"),y={};return t=d(u),u[0].preventDefault&&(e.at=\"left top\"),p=t.width,q=t.height,r=t.offset,s=a.extend({},r),a.each([\"my\",\"at\"],function(){var a,b,c=(e[this]||\"\").split(\" \");1===c.length&&(c=j.test(c[0])?c.concat([\"center\"]):k.test(c[0])?[\"center\"].concat(c):[\"center\",\"center\"]),c[0]=j.test(c[0])?c[0]:\"center\",c[1]=k.test(c[1])?c[1]:\"center\",a=l.exec(c[0]),b=l.exec(c[1]),y[this]=[a?a[0]:0,b?b[0]:0],e[this]=[m.exec(c[0])[0],m.exec(c[1])[0]]}),1===x.length&&(x[1]=x[0]),\"right\"===e.at[0]?s.left+=p:\"center\"===e.at[0]&&(s.left+=p/2),\"bottom\"===e.at[1]?s.top+=q:\"center\"===e.at[1]&&(s.top+=q/2),n=b(y.at,p,q),s.left+=n[0],s.top+=n[1],this.each(function(){var d,j,k=a(this),l=k.outerWidth(),m=k.outerHeight(),o=c(this,\"marginLeft\"),t=c(this,\"marginTop\"),z=l+o+c(this,\"marginRight\")+w.width,A=m+t+c(this,\"marginBottom\")+w.height,B=a.extend({},s),C=b(y.my,k.outerWidth(),k.outerHeight());\"right\"===e.my[0]?B.left-=l:\"center\"===e.my[0]&&(B.left-=l/2),\"bottom\"===e.my[1]?B.top-=m:\"center\"===e.my[1]&&(B.top-=m/2),B.left+=C[0],B.top+=C[1],f||(B.left=i(B.left),B.top=i(B.top)),d={marginLeft:o,marginTop:t},a.each([\"left\",\"top\"],function(b,c){a.ui.position[x[b]]&&a.ui.position[x[b]][c](B,{targetWidth:p,targetHeight:q,elemWidth:l,elemHeight:m,collisionPosition:d,collisionWidth:z,collisionHeight:A,offset:[n[0]+C[0],n[1]+C[1]],my:e.my,at:e.at,within:v,elem:k})}),e.using&&(j=function(a){var b=r.left-B.left,c=b+p-l,d=r.top-B.top,f=d+q-m,i={target:{element:u,left:r.left,top:r.top,width:p,height:q},element:{element:k,left:B.left,top:B.top,width:l,height:m},horizontal:0>c?\"left\":b>0?\"right\":\"center\",vertical:0>f?\"top\":d>0?\"bottom\":\"middle\"};l>p&&h(b+c)<p&&(i.horizontal=\"center\"),m>q&&h(d+f)<q&&(i.vertical=\"middle\"),g(h(b),h(c))>g(h(d),h(f))?i.important=\"horizontal\":i.important=\"vertical\",e.using.call(this,a,i)}),k.offset(a.extend(B,{using:j}))})},a.ui.position={fit:{left:function(a,b){var c,d=b.within,e=d.isWindow?d.scrollLeft:d.offset.left,f=d.width,h=a.left-b.collisionPosition.marginLeft,i=e-h,j=h+b.collisionWidth-f-e;b.collisionWidth>f?i>0&&0>=j?(c=a.left+i+b.collisionWidth-f-e,a.left+=i-c):j>0&&0>=i?a.left=e:i>j?a.left=e+f-b.collisionWidth:a.left=e:i>0?a.left+=i:j>0?a.left-=j:a.left=g(a.left-h,a.left)},top:function(a,b){var c,d=b.within,e=d.isWindow?d.scrollTop:d.offset.top,f=b.within.height,h=a.top-b.collisionPosition.marginTop,i=e-h,j=h+b.collisionHeight-f-e;b.collisionHeight>f?i>0&&0>=j?(c=a.top+i+b.collisionHeight-f-e,a.top+=i-c):j>0&&0>=i?a.top=e:i>j?a.top=e+f-b.collisionHeight:a.top=e:i>0?a.top+=i:j>0?a.top-=j:a.top=g(a.top-h,a.top)}},flip:{left:function(a,b){var c,d,e=b.within,f=e.offset.left+e.scrollLeft,g=e.width,i=e.isWindow?e.scrollLeft:e.offset.left,j=a.left-b.collisionPosition.marginLeft,k=j-i,l=j+b.collisionWidth-g-i,m=\"left\"===b.my[0]?-b.elemWidth:\"right\"===b.my[0]?b.elemWidth:0,n=\"left\"===b.at[0]?b.targetWidth:\"right\"===b.at[0]?-b.targetWidth:0,o=-2*b.offset[0];0>k?(c=a.left+m+n+o+b.collisionWidth-g-f,(0>c||c<h(k))&&(a.left+=m+n+o)):l>0&&(d=a.left-b.collisionPosition.marginLeft+m+n+o-i,(d>0||h(d)<l)&&(a.left+=m+n+o))},top:function(a,b){var c,d,e=b.within,f=e.offset.top+e.scrollTop,g=e.height,i=e.isWindow?e.scrollTop:e.offset.top,j=a.top-b.collisionPosition.marginTop,k=j-i,l=j+b.collisionHeight-g-i,m=\"top\"===b.my[1],n=m?-b.elemHeight:\"bottom\"===b.my[1]?b.elemHeight:0,o=\"top\"===b.at[1]?b.targetHeight:\"bottom\"===b.at[1]?-b.targetHeight:0,p=-2*b.offset[1];0>k?(d=a.top+n+o+p+b.collisionHeight-g-f,a.top+n+o+p>k&&(0>d||d<h(k))&&(a.top+=n+o+p)):l>0&&(c=a.top-b.collisionPosition.marginTop+n+o+p-i,a.top+n+o+p>l&&(c>0||h(c)<l)&&(a.top+=n+o+p))}},flipfit:{left:function(){a.ui.position.flip.left.apply(this,arguments),a.ui.position.fit.left.apply(this,arguments)},top:function(){a.ui.position.flip.top.apply(this,arguments),a.ui.position.fit.top.apply(this,arguments)}}},function(){var b,c,d,e,g,h=document.getElementsByTagName(\"body\")[0],i=document.createElement(\"div\");b=document.createElement(h?\"div\":\"body\"),d={visibility:\"hidden\",width:0,height:0,border:0,margin:0,background:\"none\"},h&&a.extend(d,{position:\"absolute\",left:\"-1000px\",top:\"-1000px\"});for(g in d)b.style[g]=d[g];b.appendChild(i),c=h||document.documentElement,c.insertBefore(b,c.firstChild),i.style.cssText=\"position: absolute; left: 10.7432222px;\",e=a(i).offset().left,f=e>10&&11>e,b.innerHTML=\"\",c.removeChild(b)}()}(),a.ui.position});";
var mod_pagespeed_I65Tz2Swt_ = "+function(a){\"use strict\";function b(){var a=document.createElement(\"bootstrap\"),b={WebkitTransition:\"webkitTransitionEnd\",MozTransition:\"transitionend\",OTransition:\"oTransitionEnd otransitionend\",transition:\"transitionend\"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one(\"bsTransitionEnd\",function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b(),a.support.transition&&(a.event.special.bsTransitionEnd={bindType:a.support.transition.end,delegateType:a.support.transition.end,handle:function(b){return a(b.target).is(this)?b.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);";
var mod_pagespeed_tFjdIRrof8 = "window.Modernizr=function(a,b,c){function d(a){t.cssText=a}function e(a,b){return d(x.join(a+\";\")+(b||\"\"))}function f(a,b){return typeof a===b}function g(a,b){return!!~(\"\"+a).indexOf(b)}function h(a,b){for(var d in a){var e=a[d];if(!g(e,\"-\")&&t[e]!==c)return\"pfx\"==b?e:!0}return!1}function i(a,b,d){for(var e in a){var g=b[a[e]];if(g!==c)return d===!1?a[e]:f(g,\"function\")?g.bind(d||b):g}return!1}function j(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+\" \"+z.join(d+\" \")+d).split(\" \");return f(b,\"string\")||f(b,\"undefined\")?h(e,b):(e=(a+\" \"+A.join(d+\" \")+d).split(\" \"),i(e,b,c))}function k(){o.input=function(c){for(var d=0,e=c.length;e>d;d++)E[c[d]]=!!(c[d]in u);return E.list&&(E.list=!(!b.createElement(\"datalist\")||!a.HTMLDataListElement)),E}(\"autocomplete autofocus list placeholder max min multiple pattern required step\".split(\" \")),o.inputtypes=function(a){for(var d,e,f,g=0,h=a.length;h>g;g++)u.setAttribute(\"type\",e=a[g]),d=\"text\"!==u.type,d&&(u.value=v,u.style.cssText=\"position:absolute;visibility:hidden;\",/^range$/.test(e)&&u.style.WebkitAppearance!==c?(q.appendChild(u),f=b.defaultView,d=f.getComputedStyle&&\"textfield\"!==f.getComputedStyle(u,null).WebkitAppearance&&0!==u.offsetHeight,q.removeChild(u)):/^(search|tel)$/.test(e)||(d=/^(url|email)$/.test(e)?u.checkValidity&&u.checkValidity()===!1:u.value!=v)),D[a[g]]=!!d;return D}(\"search tel url email datetime date month week time datetime-local number range color\".split(\" \"))}var l,m,n=\"2.8.3\",o={},p=!0,q=b.documentElement,r=\"modernizr\",s=b.createElement(r),t=s.style,u=b.createElement(\"input\"),v=\":)\",w={}.toString,x=\" -webkit- -moz- -o- -ms- \".split(\" \"),y=\"Webkit Moz O ms\",z=y.split(\" \"),A=y.toLowerCase().split(\" \"),B={svg:\"http://www.w3.org/2000/svg\"},C={},D={},E={},F=[],G=F.slice,H=function(a,c,d,e){var f,g,h,i,j=b.createElement(\"div\"),k=b.body,l=k||b.createElement(\"body\");if(parseInt(d,10))for(;d--;)h=b.createElement(\"div\"),h.id=e?e[d]:r+(d+1),j.appendChild(h);return f=[\"&#173;\",'<style id=\"s',r,'\">',a,\"</style>\"].join(\"\"),j.id=r,(k?j:l).innerHTML+=f,l.appendChild(j),k||(l.style.background=\"\",l.style.overflow=\"hidden\",i=q.style.overflow,q.style.overflow=\"hidden\",q.appendChild(l)),g=c(j,a),k?j.parentNode.removeChild(j):(l.parentNode.removeChild(l),q.style.overflow=i),!!g},I=function(b){var c=a.matchMedia||a.msMatchMedia;if(c)return c(b)&&c(b).matches||!1;var d;return H(\"@media \"+b+\" { #\"+r+\" { position: absolute; } }\",function(b){d=\"absolute\"==(a.getComputedStyle?getComputedStyle(b,null):b.currentStyle).position}),d},J=function(){function a(a,e){e=e||b.createElement(d[a]||\"div\"),a=\"on\"+a;var g=a in e;return g||(e.setAttribute||(e=b.createElement(\"div\")),e.setAttribute&&e.removeAttribute&&(e.setAttribute(a,\"\"),g=f(e[a],\"function\"),f(e[a],\"undefined\")||(e[a]=c),e.removeAttribute(a))),e=null,g}var d={select:\"input\",change:\"input\",submit:\"form\",reset:\"form\",error:\"img\",load:\"img\",abort:\"img\"};return a}(),K={}.hasOwnProperty;m=f(K,\"undefined\")||f(K.call,\"undefined\")?function(a,b){return b in a&&f(a.constructor.prototype[b],\"undefined\")}:function(a,b){return K.call(a,b)},Function.prototype.bind||(Function.prototype.bind=function(a){var b=this;if(\"function\"!=typeof b)throw new TypeError;var c=G.call(arguments,1),d=function(){if(this instanceof d){var e=function(){};e.prototype=b.prototype;var f=new e,g=b.apply(f,c.concat(G.call(arguments)));return Object(g)===g?g:f}return b.apply(a,c.concat(G.call(arguments)))};return d}),C.flexbox=function(){return j(\"flexWrap\")},C.flexboxlegacy=function(){return j(\"boxDirection\")},C.canvas=function(){var a=b.createElement(\"canvas\");return!(!a.getContext||!a.getContext(\"2d\"))},C.canvastext=function(){return!(!o.canvas||!f(b.createElement(\"canvas\").getContext(\"2d\").fillText,\"function\"))},C.webgl=function(){return!!a.WebGLRenderingContext},C.touch=function(){var c;return\"ontouchstart\"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:H([\"@media (\",x.join(\"touch-enabled),(\"),r,\")\",\"{#modernizr{top:9px;position:absolute}}\"].join(\"\"),function(a){c=9===a.offsetTop}),c},C.geolocation=function(){return\"geolocation\"in navigator},C.postmessage=function(){return!!a.postMessage},C.websqldatabase=function(){return!!a.openDatabase},C.indexedDB=function(){return!!j(\"indexedDB\",a)},C.hashchange=function(){return J(\"hashchange\",a)&&(b.documentMode===c||b.documentMode>7)},C.history=function(){return!(!a.history||!history.pushState)},C.draganddrop=function(){var a=b.createElement(\"div\");return\"draggable\"in a||\"ondragstart\"in a&&\"ondrop\"in a},C.websockets=function(){return\"WebSocket\"in a||\"MozWebSocket\"in a},C.rgba=function(){return d(\"background-color:rgba(150,255,150,.5)\"),g(t.backgroundColor,\"rgba\")},C.hsla=function(){return d(\"background-color:hsla(120,40%,100%,.5)\"),g(t.backgroundColor,\"rgba\")||g(t.backgroundColor,\"hsla\")},C.multiplebgs=function(){return d(\"background:url(https://),url(https://),red url(https://)\"),/(url\\s*\\(.*?){3}/.test(t.background)},C.backgroundsize=function(){return j(\"backgroundSize\")},C.borderimage=function(){return j(\"borderImage\")},C.borderradius=function(){return j(\"borderRadius\")},C.boxshadow=function(){return j(\"boxShadow\")},C.textshadow=function(){return\"\"===b.createElement(\"div\").style.textShadow},C.opacity=function(){return e(\"opacity:.55\"),/^0.55$/.test(t.opacity)},C.cssanimations=function(){return j(\"animationName\")},C.csscolumns=function(){return j(\"columnCount\")},C.cssgradients=function(){var a=\"background-image:\",b=\"gradient(linear,left top,right bottom,from(#9f9),to(white));\",c=\"linear-gradient(left top,#9f9, white);\";return d((a+\"-webkit- \".split(\" \").join(b+a)+x.join(c+a)).slice(0,-a.length)),g(t.backgroundImage,\"gradient\")},C.cssreflections=function(){return j(\"boxReflect\")},C.csstransforms=function(){return!!j(\"transform\")},C.csstransforms3d=function(){var a=!!j(\"perspective\");return a&&\"webkitPerspective\"in q.style&&H(\"@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}\",function(b,c){a=9===b.offsetLeft&&3===b.offsetHeight}),a},C.csstransitions=function(){return j(\"transition\")},C.fontface=function(){var a;return H('@font-face {font-family:\"font\";src:url(\"https://\")}',function(c,d){var e=b.getElementById(\"smodernizr\"),f=e.sheet||e.styleSheet,g=f?f.cssRules&&f.cssRules[0]?f.cssRules[0].cssText:f.cssText||\"\":\"\";a=/src/i.test(g)&&0===g.indexOf(d.split(\" \")[0])}),a},C.generatedcontent=function(){var a;return H([\"#\",r,\"{font:0/0 a}#\",r,':after{content:\"',v,'\";visibility:hidden;font:3px/1 a}'].join(\"\"),function(b){a=b.offsetHeight>=3}),a},C.video=function(){var a=b.createElement(\"video\"),c=!1;try{(c=!!a.canPlayType)&&(c=new Boolean(c),c.ogg=a.canPlayType('video/ogg; codecs=\"theora\"').replace(/^no$/,\"\"),c.h264=a.canPlayType('video/mp4; codecs=\"avc1.42E01E\"').replace(/^no$/,\"\"),c.webm=a.canPlayType('video/webm; codecs=\"vp8, vorbis\"').replace(/^no$/,\"\"))}catch(d){}return c},C.audio=function(){var a=b.createElement(\"audio\"),c=!1;try{(c=!!a.canPlayType)&&(c=new Boolean(c),c.ogg=a.canPlayType('audio/ogg; codecs=\"vorbis\"').replace(/^no$/,\"\"),c.mp3=a.canPlayType(\"audio/mpeg;\").replace(/^no$/,\"\"),c.wav=a.canPlayType('audio/wav; codecs=\"1\"').replace(/^no$/,\"\"),c.m4a=(a.canPlayType(\"audio/x-m4a;\")||a.canPlayType(\"audio/aac;\")).replace(/^no$/,\"\"))}catch(d){}return c},C.localstorage=function(){try{return localStorage.setItem(r,r),localStorage.removeItem(r),!0}catch(a){return!1}},C.sessionstorage=function(){try{return sessionStorage.setItem(r,r),sessionStorage.removeItem(r),!0}catch(a){return!1}},C.webworkers=function(){return!!a.Worker},C.applicationcache=function(){return!!a.applicationCache},C.svg=function(){return!!b.createElementNS&&!!b.createElementNS(B.svg,\"svg\").createSVGRect},C.inlinesvg=function(){var a=b.createElement(\"div\");return a.innerHTML=\"<svg/>\",(a.firstChild&&a.firstChild.namespaceURI)==B.svg},C.smil=function(){return!!b.createElementNS&&/SVGAnimate/.test(w.call(b.createElementNS(B.svg,\"animate\")))},C.svgclippaths=function(){return!!b.createElementNS&&/SVGClipPath/.test(w.call(b.createElementNS(B.svg,\"clipPath\")))};for(var L in C)m(C,L)&&(l=L.toLowerCase(),o[l]=C[L](),F.push((o[l]?\"\":\"no-\")+l));return o.input||k(),o.addTest=function(a,b){if(\"object\"==typeof a)for(var d in a)m(a,d)&&o.addTest(d,a[d]);else{if(a=a.toLowerCase(),o[a]!==c)return o;b=\"function\"==typeof b?b():b,\"undefined\"!=typeof p&&p&&(q.className+=\" \"+(b?\"\":\"no-\")+a),o[a]=b}return o},d(\"\"),s=u=null,function(a,b){function c(a,b){var c=a.createElement(\"p\"),d=a.getElementsByTagName(\"head\")[0]||a.documentElement;return c.innerHTML=\"x<style>\"+b+\"</style>\",d.insertBefore(c.lastChild,d.firstChild)}function d(){var a=s.elements;return\"string\"==typeof a?a.split(\" \"):a}function e(a){var b=r[a[p]];return b||(b={},q++,a[p]=q,r[q]=b),b}function f(a,c,d){if(c||(c=b),k)return c.createElement(a);d||(d=e(c));var f;return f=d.cache[a]?d.cache[a].cloneNode():o.test(a)?(d.cache[a]=d.createElem(a)).cloneNode():d.createElem(a),!f.canHaveChildren||n.test(a)||f.tagUrn?f:d.frag.appendChild(f)}function g(a,c){if(a||(a=b),k)return a.createDocumentFragment();c=c||e(a);for(var f=c.frag.cloneNode(),g=0,h=d(),i=h.length;i>g;g++)f.createElement(h[g]);return f}function h(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?f(c,a,b):b.createElem(c)},a.createDocumentFragment=Function(\"h,f\",\"return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(\"+d().join().replace(/[\\w\\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c(\"'+a+'\")'})+\");return n}\")(s,b.frag)}function i(a){a||(a=b);var d=e(a);return!s.shivCSS||j||d.hasCSS||(d.hasCSS=!!c(a,\"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}\")),k||h(a,d),a}var j,k,l=\"3.7.0\",m=a.html5||{},n=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,o=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,p=\"_html5shiv\",q=0,r={};!function(){try{var a=b.createElement(\"a\");a.innerHTML=\"<xyz></xyz>\",j=\"hidden\"in a,k=1==a.childNodes.length||function(){b.createElement(\"a\");var a=b.createDocumentFragment();return\"undefined\"==typeof a.cloneNode||\"undefined\"==typeof a.createDocumentFragment||\"undefined\"==typeof a.createElement}()}catch(c){j=!0,k=!0}}();var s={elements:m.elements||\"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video\",version:l,shivCSS:m.shivCSS!==!1,supportsUnknownElements:k,shivMethods:m.shivMethods!==!1,type:\"default\",shivDocument:i,createElement:f,createDocumentFragment:g};a.html5=s,i(b)}(this,b),o._version=n,o._prefixes=x,o._domPrefixes=A,o._cssomPrefixes=z,o.mq=I,o.hasEvent=J,o.testProp=function(a){return h([a])},o.testAllProps=j,o.testStyles=H,o.prefixed=function(a,b,c){return b?j(a,b,c):j(a,\"pfx\")},q.className=q.className.replace(/(^|\\s)no-js(\\s|$)/,\"$1$2\")+(p?\" js \"+F.join(\" \"):\"\"),o}(this,this.document);";
var mod_pagespeed_TzvFJ7xIyo = "!function(a){\"function\"==typeof define&&define.amd?define([\"jquery\"],a):a(\"object\"==typeof exports?require(\"jquery\"):jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('\"')&&(a=a.slice(1,-1).replace(/\\\\\"/g,'\"').replace(/\\\\\\\\/g,\"\\\\\"));try{return a=decodeURIComponent(a.replace(g,\" \")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\\+/g,h=a.cookie=function(e,g,i){if(arguments.length>1&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),\"number\"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),\"=\",d(g),i.expires?\"; expires=\"+i.expires.toUTCString():\"\",i.path?\"; path=\"+i.path:\"\",i.domain?\"; domain=\"+i.domain:\"\",i.secure?\"; secure\":\"\"].join(\"\")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split(\"; \"):[],n=0,o=m.length;o>n;n++){var p=m[n].split(\"=\"),q=c(p.shift()),r=p.join(\"=\");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,\"\",a.extend({},c,{expires:-1})),!a.cookie(b))}});";