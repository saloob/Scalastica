(function(){function k(a,b){var c=a,d,c=null===c||"undefined"==typeof c?"":""+c;d="0";for(var f=d.length,i=c.length;i<b;i+=f)c=d+c;return c}var n,m;n={changeIdAttribute:"data-cid",userIdAttribute:"data-userid",userNameAttribute:"data-username",timeAttribute:"data-time",changeDataAttribute:"data-changedata",attrValuePrefix:"",blockEl:"p",blockEls:"p ol ul li h1 h2 h3 h4 h5 h6 blockquote".split(" "),stylePrefix:"cts",currentUser:{id:null,name:null},changeTypes:{insertType:{tag:"span",alias:"ins",action:"Inserted"},
deleteType:{tag:"span",alias:"del",action:"Deleted"}},handleEvents:!1,contentEditable:void 0,isTracking:!0,noTrack:".ice-no-track",avoid:".ice-avoid",mergeBlocks:!0,titleTemplate:null,isVisible:!0,changeData:null};m=function(a){this._changes={};this._refreshInterval=null;this.$this=jQuery(this);a||(a={});if(!a.element)throw Error("`options.element` must be defined for ice construction.");ice.dom.extend(!0,this,n,a);this.pluginsManager=new ice.IcePluginManager(this);a.plugins&&this.pluginsManager.usePlugins("ice-init",
a.plugins)};m.prototype={_userStyles:{},_styles:{},_uniqueStyleIndex:0,_browserType:null,_batchChangeid:null,_uniqueIDIndex:1,_delBookmark:"tempdel",isPlaceHoldingDeletes:!1,startTracking:function(){"boolean"==typeof this.contentEditable&&this.element.setAttribute("contentEditable",this.contentEditable);if(this.handleEvents){var a=this;ice.dom.bind(a.element,"keyup.ice keydown.ice keypress.ice mousedown.ice mouseup.ice",function(b){return a.handleEvent(b)})}this.initializeEnvironment();this.initializeEditor();
this.initializeRange();this._setInterval();this.pluginsManager.fireEnabled(this.element);return this},stopTracking:function(a){this._isTracking=!1;try{this.element&&ice.dom.unbind(this.element,"keyup.ice keydown.ice keypress.ice mousedown.ice mouseup.ice"),!a&&"undefined"!=typeof this.contentEditable&&this.element.setAttribute("contentEditable",!this.contentEditable)}catch(b){}try{this.pluginsManager.fireDisabled(this.element)}catch(c){}this._setInterval();return this},initializeEnvironment:function(){this.env||
(this.env={});this.env.element=this.element;this.env.document=this.element.ownerDocument;this.env.window=this.env.document.defaultView||this.env.document.parentWindow||window;this.env.frame=this.env.window.frameElement;this.env.selection=this.selection=new ice.Selection(this.env);this.env.document.createElement(this.changeTypes.insertType.tag);this.env.document.createElement(this.changeTypes.deleteType.tag)},initializeRange:function(){var a=this.selection.createRange();a.setStart(ice.dom.find(this.element,
this.blockEls.join(", "))[0],0);a.collapse(!0);this.selection.addRange(a);this.env.frame?this.env.frame.contentWindow.focus():this.element.focus()},initializeEditor:function(){var a=this.env.document.createElement("div");this.element.childNodes.length?(a.innerHTML=this.element.innerHTML,ice.dom.removeWhitespace(a),""===a.innerHTML&&a.appendChild(ice.dom.create("<"+this.blockEl+" ><br/></"+this.blockEl+">"))):a.appendChild(ice.dom.create("<"+this.blockEl+" ><br/></"+this.blockEl+">"));this.element.innerHTML=
a.innerHTML;this._loadFromDom();this._setInterval()},enableChangeTracking:function(){this.isTracking=!0;this.pluginsManager.fireEnabled(this.element)},disableChangeTracking:function(){this.isTracking=!1;this.pluginsManager.fireDisabled(this.element)},setCurrentUser:function(a){this.currentUser=a;this._updateUserData(a)},handleEvent:function(a){if(this.isTracking)if("mouseup"==a.type){var b=this;setTimeout(function(){b.mouseUp(a)},200)}else{if("mousedown"==a.type)return this.mouseDown(a);if("keypress"==
a.type){var c=this.keyPress(a);c||a.preventDefault();return c}if("keydown"==a.type)return(c=this.keyDown(a))||a.preventDefault(),c;"keyup"==a.type&&this.pluginsManager.fireCaretUpdated()}},createIceNode:function(a,b){var c=this.env.document.createElement(this.changeTypes[a].tag);ice.dom.addClass(c,this._getIceNodeClass(a));c.appendChild(b?b:this.env.document.createTextNode(""));this.addChange(this.changeTypes[a].alias,[c]);this.pluginsManager.fireNodeCreated(c,{action:this.changeTypes[a].action});
return c},insert:function(a,b){var c=!a;a||(a="﻿");b?this.selection.addRange(b):b=this.getCurrentRange();"string"===typeof a&&(a=document.createTextNode(a));var d=this._batchChangeid?null:this.startBatchChange();if(!b.collapsed&&(this.deleteContents(!1,null,!0),b=this.getCurrentRange(),b.startContainer===b.endContainer&&this.element===b.startContainer)){ice.dom.empty(this.element);var f=b.getLastSelectableChild(this.element);b.setStartAfter(f);b.collapse(!0)}this._moveRangeToValidTrackingPos(b);this._insertNode(a,
b,c);this.pluginsManager.fireNodeInserted(a,b);this.endBatchChange(d);return c},placeholdDeletes:function(){var a=this;this.isPlaceholdingDeletes&&this.revertDeletePlaceholders();this.isPlaceholdingDeletes=!0;this._deletes=[];var b="."+this._getIceNodeClass("deleteType");ice.dom.each(ice.dom.find(this.element,b),function(b,d){a._deletes.push(ice.dom.cloneNode(d));ice.dom.replaceWith(d,"<"+a._delBookmark+' data-allocation="'+(a._deletes.length-1)+'"/>')});return!0},revertDeletePlaceholders:function(){var a=
this;if(!this.isPlaceholdingDeletes)return!1;ice.dom.each(this._deletes,function(b,c){ice.dom.find(a.element,a._delBookmark+"[data-allocation="+b+"]").replaceWith(c)});this.isPlaceholdingDeletes=!1;return!0},deleteContents:function(a,b){var c=!0;b?this.selection.addRange(b):b=this.getCurrentRange();var d=this._batchChangeid?null:this.startBatchChange();!1===b.collapsed?this._deleteSelection(b):c=a?this._deleteRight(b):this._deleteLeft(b);this.selection.addRange(b);this.endBatchChange(d);return c},
getChanges:function(){return this._changes},getChangeUserids:function(){var a=[],b=Object.keys(this._changes),c;for(c in b)a.push(this._changes[b[c]].userid);return a.sort().filter(function(a,b,c){return b==c.indexOf(a)?1:0})},getElementContent:function(){return this.element.innerHTML},getCleanContent:function(a,b,c){return(a=this.getCleanDOM(a,b,c))&&a.innerHTML||""},getCleanDOM:function(a,b,c){var d="",f=this;ice.dom.each(this.changeTypes,function(a,b){"deleteType"!=a&&(0<b&&(d+=","),d+="."+f._getIceNodeClass(a))});
a=a?"string"===typeof a?ice.dom.create("<div>"+a+"</div>"):ice.dom.cloneNode(a,!1)[0]:ice.dom.cloneNode(this.element,!1)[0];a=c?c.call(this,a):a;c=ice.dom.find(a,d);ice.dom.each(c,function(){ice.dom.replaceWith(this,ice.dom.contents(this))});c=ice.dom.find(a,"."+this._getIceNodeClass("deleteType"));ice.dom.remove(c);return a=b?b.call(this,a):a},acceptAll:function(a){if(a)return this._acceptRejectSome(a,!0);this.element.innerHTML=this.getCleanContent();this._changes={};this._triggerChange()},rejectAll:function(a){if(a)return this._acceptRejectSome(a,
!1);var a="."+this._getIceNodeClass("insertType"),b="."+this._getIceNodeClass("deleteType");ice.dom.remove(ice.dom.find(this.element,a));ice.dom.each(ice.dom.find(this.element,b),function(a,b){ice.dom.replaceWith(b,ice.dom.contents(b))});this._changes={};this._triggerChange()},acceptChange:function(a){this.acceptRejectChange(a,!0)},rejectChange:function(a){this.acceptRejectChange(a,!1)},acceptRejectChange:function(a,b){var c,d,f,i,h,g,e=ice.dom;if(!a)if(c=this.getCurrentRange(),c.collapsed)a=c.startContainer;
else return;c=f="."+this._getIceNodeClass("deleteType");d=i="."+this._getIceNodeClass("insertType");h=e.getNode(a,c+","+d);var l=e.attr(h,this.changeIdAttribute);g=e.find(this.element,"["+this.changeIdAttribute+"="+l+"]");b||(f=d,i=c);if(ice.dom.is(h,i))e.each(g,function(a,b){e.replaceWith(b,ice.dom.contents(b))});else if(e.is(h,f))e.remove(g);else return;1>=g.length&&delete this._changes[l];this._triggerChange()},isInsideChange:function(a){try{return!!this.currentChangeNode(a)}catch(b){return!1}},
addChangeType:function(a,b,c,d){b={tag:b,alias:c};d&&(b.action=d);this.changeTypes[a]=b},getIceNode:function(a,b){var c="."+this._getIceNodeClass(b);return ice.dom.getNode(a,c)},_moveRangeToValidTrackingPos:function(a){for(var b=!1,c=this._getVoidElement(a.endContainer);c;){try{a.moveEnd(ice.dom.CHARACTER_UNIT,1),a.moveEnd(ice.dom.CHARACTER_UNIT,-1)}catch(d){b=!0}if(b||ice.dom.onBlockBoundary(a.endContainer,a.startContainer,this.blockEls)){a.setStartAfter(c);a.collapse(!0);break}(c=this._getVoidElement(a.endContainer))?
(a.setEnd(a.endContainer,0),a.moveEnd(ice.dom.CHARACTER_UNIT,ice.dom.getNodeCharacterLength(a.endContainer)),a.collapse()):(a.setStart(a.endContainer,0),a.collapse(!0))}},_getNoTrackElement:function(a){var b=this._getNoTrackSelector();return ice.dom.is(a,b)?a:ice.dom.parents(a,b)[0]||null},_getNoTrackSelector:function(){return this.noTrack},_getVoidElement:function(a){try{var b=this._getVoidElSelector();return ice.dom.is(a,b)?a:ice.dom.parents(a,b)[0]||null}catch(c){return null}},_getVoidElSelector:function(){return"."+
this._getIceNodeClass("deleteType")+","+this.avoid},_currentUserIceNode:function(a){return ice.dom.attr(a,this.userIdAttribute)==this.currentUser.id},_getChangeTypeFromAlias:function(a){var b,c=null;for(b in this.changeTypes)this.changeTypes.hasOwnProperty(b)&&this.changeTypes[b].alias==a&&(c=b);return c},_getIceNodeClass:function(a){return this.attrValuePrefix+this.changeTypes[a].alias},getUserStyle:function(a){var b=null;return b=this._userStyles[a]?this._userStyles[a]:this.setUserStyle(a,this.getNewStyleId())},
setUserStyle:function(a,b){var c=this.stylePrefix+"-"+b;this._styles[b]||(this._styles[b]=!0);return this._userStyles[a]=c},getNewStyleId:function(){var a=++this._uniqueStyleIndex;if(this._styles[a])return this.getNewStyleId();this._styles[a]=!0;return a},addChange:function(a,b){var c=this._batchChangeid||this.getNewChangeId();this._changes[c]||(this._changes[c]={type:this._getChangeTypeFromAlias(a),time:(new Date).getTime(),userid:""+this.currentUser.id,username:this.currentUser.name,data:this.changeData||
""},this._triggerChange());var d=this;ice.dom.foreach(b,function(a){d.addNodeToChange(c,b[a])});return c},addNodeToChange:function(a,b){var a=this._batchChangeid||a,c=this.getChange(a);b.getAttribute(this.changeIdAttribute)||b.setAttribute(this.changeIdAttribute,a);var d=b.getAttribute(this.userIdAttribute);d||b.setAttribute(this.userIdAttribute,d=c.userid);d==c.userid&&b.setAttribute(this.userNameAttribute,c.username);null==b.getAttribute(this.changeDataAttribute)&&b.setAttribute(this.changeDataAttribute,
this.changeData||"");b.getAttribute(this.timeAttribute)||b.setAttribute(this.timeAttribute,c.time);ice.dom.hasClass(b,this._getIceNodeClass(c.type))||ice.dom.addClass(b,this._getIceNodeClass(c.type));d=this.getUserStyle(c.userid);ice.dom.hasClass(b,d)||ice.dom.addClass(b,d);this._setNodeTitle(b,c)},getChange:function(a){var b=null;this._changes[a]&&(b=this._changes[a]);return b},getNewChangeId:function(){var a=++this._uniqueIDIndex;this._changes[a]&&(a=this.getNewChangeId());return a},startBatchChange:function(){return this._batchChangeid=
this.getNewChangeId()},endBatchChange:function(a){a===this._batchChangeid&&(this._batchChangeid=null,this._triggerChangeText())},getCurrentRange:function(){try{return this.selection.getRangeAt(0)}catch(a){return null}},_insertNode:function(a,b,c){!ice.dom.isBlockElement(b.startContainer)&&(!ice.dom.canContainTextElement(ice.dom.getBlockParent(b.startContainer,this.element))&&b.startContainer.previousSibling)&&b.setStart(b.startContainer.previousSibling,0);var d=b.startContainer,d=ice.dom.isBlockElement(d)&&
d||ice.dom.getBlockParent(d,this.element)||null;if(d===this.element){var f=document.createElement(this.blockEl);d.appendChild(f);b.setStart(f,0);b.collapse();return this._insertNode(a,b,c)}ice.dom.hasNoTextOrStubContent(d)&&(ice.dom.empty(d),ice.dom.append(d,"<br>"),b.setStart(d,0));d=this._currentUserIceNode(this.getIceNode(b.startContainer,"insertType"));if(!c||!d)d||(a=this.createIceNode("insertType",a)),b.insertNode(a),b.setStartAfter(a),c?b.setStart(a,0):b.collapse(),this.selection.addRange(b)},
_handleVoidEl:function(a,b){var c=this._getVoidElement(a);return c&&!this.getIceNode(c,"deleteType")?(b.collapse(!0),!0):!1},_deleteSelection:function(a){for(var b=new ice.Bookmark(this.env,a),c=ice.dom.getElementsBetween(b.start,b.end),d=ice.dom.parents(a.startContainer,this.blockEls.join(", "))[0],f=ice.dom.parents(a.endContainer,this.blockEls.join(", "))[0],i=[],h=0;h<c.length;h++){var g=c[h];if(ice.dom.isBlockElement(g)&&(i.push(g),!ice.dom.canContainTextElement(g))){for(var e=0;e<g.childNodes.length;e++)c.push(g.childNodes[e]);
continue}if(!(g.nodeType===ice.dom.TEXT_NODE&&0===ice.dom.getNodeTextContent(g).length)&&!this._getVoidElement(g))if(g.nodeType!==ice.dom.TEXT_NODE){if(ice.dom.BREAK_ELEMENT!=ice.dom.getTagName(g))if(ice.dom.isStubElement(g))this._addNodeTracking(g,!1,!0);else{ice.dom.hasNoTextOrStubContent(g)&&ice.dom.remove(g);for(j=0;j<g.childNodes.length;j++)c.push(g.childNodes[j])}}else e=ice.dom.getBlockParent(g),this._addNodeTracking(g,!1,!0,!0),ice.dom.hasNoTextOrStubContent(e)&&ice.dom.remove(e)}if(this.mergeBlocks&&
d!==f){for(;i.length;)ice.dom.mergeContainers(i.shift(),d);ice.dom.removeBRFromChild(f);ice.dom.removeBRFromChild(d);ice.dom.mergeContainers(f,d)}b.selectBookmark();a.collapse(!1)},_deleteRight:function(a){var b=ice.dom.isBlockElement(a.startContainer)&&a.startContainer||ice.dom.getBlockParent(a.startContainer,this.element)||null,c=b?ice.dom.hasNoTextOrStubContent(b):!1,d=b&&ice.dom.getNextContentNode(b,this.element),f=d?ice.dom.hasNoTextOrStubContent(d):!1,i=a.endContainer,h=a.endOffset,g=a.commonAncestorContainer,
e;if(c)return!1;if(g.nodeType!==ice.dom.TEXT_NODE){if(0===h&&(ice.dom.isBlockElement(g)&&!ice.dom.canContainTextElement(g))&&(b=g.firstElementChild))return a.setStart(b,0),a.collapse(),this._deleteRight(a);if(g.childNodes.length>h)return e=document.createTextNode(" "),g.insertBefore(e,g.childNodes[h]),a.setStart(e,1),a.collapse(!0),b=this._deleteRight(a),ice.dom.remove(e),b;e=ice.dom.getNextContentNode(g,this.element);a.setEnd(e,0);a.collapse();return this._deleteRight(a)}a.moveEnd(ice.dom.CHARACTER_UNIT,
1);a.moveEnd(ice.dom.CHARACTER_UNIT,-1);if(h===i.data.length&&!ice.dom.hasNoTextOrStubContent(i)){e=ice.dom.getNextNode(i,this.element);if(!e)return a.selectNodeContents(i),a.collapse(),!1;ice.dom.BREAK_ELEMENT==ice.dom.getTagName(e)&&(e=ice.dom.getNextNode(e,this.element));e.nodeType===ice.dom.TEXT_NODE&&(e=e.parentNode);if(!e.isContentEditable)return b=this._addNodeTracking(e,!1,!1),h=document.createTextNode(""),e.parentNode.insertBefore(h,e.nextSibling),a.selectNode(h),a.collapse(!0),b;if(this._handleVoidEl(e,
a))return!0;if(ice.dom.isChildOf(e,b)&&ice.dom.isStubElement(e))return this._addNodeTracking(e,a,!1)}if(this._handleVoidEl(e,a))return!0;if(this._getNoTrackElement(a.endContainer.parentElement))return a.deleteContents(),!1;if(ice.dom.isOnBlockBoundary(a.startContainer,a.endContainer,this.element)){if(this.mergeBlocks&&ice.dom.is(ice.dom.getBlockParent(e,this.element),this.blockEl)){d!==ice.dom.getBlockParent(a.endContainer,this.element)&&a.setEnd(d,0);h=ice.dom.getElementsBetween(a.startContainer,
a.endContainer);for(g=0;g<h.length;g++)ice.dom.remove(h[g]);h=a.endContainer;ice.dom.remove(ice.dom.find(a.startContainer,"br"));ice.dom.remove(ice.dom.find(h,"br"));return ice.dom.mergeBlockWithSibling(a,ice.dom.getBlockParent(a.endContainer,this.element)||b)}if(f)return ice.dom.remove(d),a.collapse(!0),!0;a.setStart(d,0);a.collapse(!0);return!0}b=a.endContainer.splitText(a.endOffset);b.splitText(1);return this._addNodeTracking(b,a,!1)},_deleteLeft:function(a){var b=ice.dom.isBlockElement(a.startContainer)&&
a.startContainer||ice.dom.getBlockParent(a.startContainer,this.element)||null,c=b?ice.dom.hasNoTextOrStubContent(b):!1,d=b&&ice.dom.getPrevContentNode(b,this.element),f=d?ice.dom.hasNoTextOrStubContent(d):!1,i=a.startContainer,h=a.startOffset,g=a.commonAncestorContainer,e;if(c)return!1;if(0===h||g.nodeType!==ice.dom.TEXT_NODE){if(ice.dom.isBlockElement(g)&&!ice.dom.canContainTextElement(g))if(0===h){if(e=g.firstElementChild)return a.setStart(e,0),a.collapse(),this._deleteLeft(a)}else if(e=g.lastElementChild)if(c=
a.getLastSelectableChild(e))return a.setStart(c,c.data.length),a.collapse(),this._deleteLeft(a);e=0===h?ice.dom.getPrevContentNode(i,this.element):g.childNodes[h-1];if(!e)return!1;ice.dom.is(e,"."+this._getIceNodeClass("insertType")+", ."+this._getIceNodeClass("deleteType"))&&(0<e.childNodes.length&&e.lastChild)&&(e=e.lastChild);e.nodeType===ice.dom.TEXT_NODE&&(e=e.parentNode);if(!e.isContentEditable)return b=this._addNodeTracking(e,!1,!0),d=document.createTextNode(""),e.parentNode.insertBefore(d,
e),a.selectNode(d),a.collapse(!0),b;if(this._handleVoidEl(e,a))return!0;if(ice.dom.isStubElement(e)&&ice.dom.isChildOf(e,b)||!e.isContentEditable)return this._addNodeTracking(e,a,!0);if(ice.dom.isStubElement(e))return ice.dom.remove(e),a.collapse(!0),!1;if(e!==b&&!ice.dom.isChildOf(e,b)){ice.dom.canContainTextElement(e)||(e=e.lastElementChild);if(e.lastChild&&e.lastChild.nodeType!==ice.dom.TEXT_NODE&&ice.dom.isStubElement(e.lastChild)&&"BR"!==e.lastChild.tagName)return a.setStartAfter(e.lastChild),
a.collapse(!0),!0;if((c=a.getLastSelectableChild(e))&&!ice.dom.isOnBlockBoundary(a.startContainer,c,this.element))return a.selectNodeContents(c),a.collapse(),!0}}if(1===h&&!ice.dom.isBlockElement(g)&&1<a.startContainer.childNodes.length&&a.startContainer.childNodes[0].nodeType===ice.dom.TEXT_NODE&&0===a.startContainer.childNodes[0].data.length)return a.setStart(a.startContainer,0),this._deleteLeft(a);a.moveStart(ice.dom.CHARACTER_UNIT,-1);a.moveStart(ice.dom.CHARACTER_UNIT,1);if(this._getNoTrackElement(a.startContainer.parentElement))return a.deleteContents(),
!1;if(ice.dom.isOnBlockBoundary(a.startContainer,a.endContainer,this.element)){if(f)return ice.dom.remove(d),a.collapse(),!0;if(this.mergeBlocks&&ice.dom.is(ice.dom.getBlockParent(e,this.element),this.blockEl)){d!==ice.dom.getBlockParent(a.startContainer,this.element)&&a.setStart(d,d.childNodes.length);d=ice.dom.getElementsBetween(a.startContainer,a.endContainer);for(f=0;f<d.length;f++)ice.dom.remove(d[f]);d=a.endContainer;ice.dom.remove(ice.dom.find(a.startContainer,"br"));ice.dom.remove(ice.dom.find(d,
"br"));return ice.dom.mergeBlockWithSibling(a,ice.dom.getBlockParent(a.endContainer,this.element)||b)}if(d&&d.lastChild&&ice.dom.isStubElement(d.lastChild))return a.setStartAfter(d.lastChild),a.collapse(!0),!0;(c=a.getLastSelectableChild(d))?(a.setStart(c,c.data.length),a.collapse(!0)):d&&(a.setStart(d,d.childNodes.length),a.collapse(!0));return!0}b=a.startContainer.splitText(a.startOffset-1);b.splitText(1);return this._addNodeTracking(b,a,!0)},_addNodeTracking:function(a,b,c){var d=this.getIceNode(a,
"insertType");if(d&&this._currentUserIceNode(d))return b&&c&&b.selectNode(a),a.parentNode.removeChild(a),a=ice.dom.cloneNode(d),ice.dom.remove(ice.dom.find(a,".iceBookmark")),null!==d&&ice.dom.hasNoTextOrStubContent(a[0])&&(a=this.env.document.createTextNode(""),ice.dom.insertBefore(d,a),b&&(b.setStart(a,0),b.collapse(!0)),ice.dom.replaceWith(d,ice.dom.contents(d))),!0;if(b&&this.getIceNode(a,"deleteType")){this._normalizeNode(a);var f=!1;if(c){for(a=ice.dom.getPrevContentNode(a,this.element);!f;)(d=
this.getIceNode(a,"deleteType"))?a=ice.dom.getPrevContentNode(a,this.element):f=!0;a&&((c=b.getLastSelectableChild(a))&&(a=c),b.setStart(a,ice.dom.getNodeCharacterLength(a)),b.collapse(!0))}else{for(a=ice.dom.getNextContentNode(a,this.element);!f;)(d=this.getIceNode(a,"deleteType"))?a=ice.dom.getNextContentNode(a,this.element):f=!0;a&&(b.selectNodeContents(a),b.collapse(!0))}return!0}a.previousSibling&&(a.previousSibling.nodeType===ice.dom.TEXT_NODE&&0===a.previousSibling.length)&&a.parentNode.removeChild(a.previousSibling);
a.nextSibling&&(a.nextSibling.nodeType===ice.dom.TEXT_NODE&&0===a.nextSibling.length)&&a.parentNode.removeChild(a.nextSibling);d=this.getIceNode(a.previousSibling,"deleteType");f=this.getIceNode(a.nextSibling,"deleteType");if(d&&this._currentUserIceNode(d)){if(d.appendChild(a),f&&this._currentUserIceNode(f)){var i=ice.dom.extractContent(f);ice.dom.append(d,i);f.parentNode.removeChild(f)}}else f&&this._currentUserIceNode(f)?(d=f,d.insertBefore(a,d.firstChild)):(d=this.createIceNode("deleteType"),a.parentNode.insertBefore(d,
a),d.appendChild(a));b&&(ice.dom.isStubElement(a)?b.selectNode(a):b.selectNodeContents(a),c?b.collapse(!0):b.collapse(),this._normalizeNode(a));return!0},_handleAncillaryKey:function(a){var b=!0;switch(a.keyCode){case ice.dom.DOM_VK_DELETE:b=this.deleteContents();this.pluginsManager.fireKeyPressed(a);break;case 46:b=this.deleteContents(!0);this.pluginsManager.fireKeyPressed(a);break;case ice.dom.DOM_VK_DOWN:case ice.dom.DOM_VK_UP:case ice.dom.DOM_VK_LEFT:case ice.dom.DOM_VK_RIGHT:this.pluginsManager.fireCaretPositioned();
b=!1;break;default:b=!1}return!0===b?(ice.dom.preventDefault(a),!1):!0},keyDown:function(a){if(!this.pluginsManager.fireKeyDown(a))return ice.dom.preventDefault(a),!1;var b=!1;if(!1===this._handleSpecialKey(a))return!0!==ice.dom.isBrowser("msie")&&(this._preventKeyPress=!0),!1;if((!0===a.ctrlKey||!0===a.metaKey)&&(!0===ice.dom.isBrowser("msie")||!0===ice.dom.isBrowser("chrome"))&&!this.pluginsManager.fireKeyPressed(a))return!1;switch(a.keyCode){case 27:break;default:!0!==/Firefox/.test(navigator.userAgent)&&
(b=!this._handleAncillaryKey(a))}return b?(ice.dom.preventDefault(a),!1):!0},keyPress:function(a){if(!0===this._preventKeyPress)this._preventKeyPress=!1;else{var b=null;null==a.which?b=String.fromCharCode(a.keyCode):0<a.which&&(b=String.fromCharCode(a.which));if(!this.pluginsManager.fireKeyPress(a))return!1;if(a.ctrlKey||a.metaKey)return!0;var c=this.getCurrentRange(),d=c&&ice.dom.parents(c.startContainer,"br")[0]||null;d&&(c.moveToNextEl(d),d.parentNode.removeChild(d));if(null!==b&&!0!==a.ctrlKey&&
!0!==a.metaKey)switch(a.keyCode){case ice.dom.DOM_VK_DELETE:break;case ice.dom.DOM_VK_ENTER:return this._handleEnter();default:return this._moveRangeToValidTrackingPos(c,c.startContainer),this.insert(b)}return this._handleAncillaryKey(a)}},_handleEnter:function(){var a=this.getCurrentRange();a&&!a.collapsed&&this.deleteContents();return!0},_handleSpecialKey:function(a){var b=a.which;null===b&&(b=a.keyCode);var c=!1;switch(b){case 65:if(!0===a.ctrlKey||!0===a.metaKey){c=!0;b=this.getCurrentRange();
if(!0===ice.dom.isBrowser("msie")){var d=this.env.document.createTextNode(""),f=this.env.document.createTextNode("");this.element.firstChild?ice.dom.insertBefore(this.element.firstChild,d):this.element.appendChild(d);this.element.appendChild(f);b.setStart(d,0);b.setEnd(f,0)}else b.setStart(b.getFirstSelectableChild(this.element),0),d=b.getLastSelectableChild(this.element),b.setEnd(d,d.length);this.selection.addRange(b)}}return!0===c?(ice.dom.preventDefault(a),!1):!0},mouseUp:function(a){if(!this.pluginsManager.fireClicked(a))return!1;
this.pluginsManager.fireSelectionChanged(this.getCurrentRange());return!0},mouseDown:function(a){if(!this.pluginsManager.fireMouseDown(a))return!1;this.pluginsManager.fireCaretUpdated();return!0},getContentElement:function(){return this.element},getIceNodes:function(){var a=[],b=this;ice.dom.each(this.changeTypes,function(c){a.push("."+b._getIceNodeClass(c))});a=a.join(",");return jQuery(this.element).find(a)},currentChangeNode:function(a){var b="."+this._getIceNodeClass("insertType")+", ."+this._getIceNodeClass("deleteType");
if(!a){a=this.getCurrentRange();if(!a||!a.collapsed)return!1;a=a.startContainer}return ice.dom.getNode(a,b)},setShowChanges:function(a){this._isVisible=a=!!a;jQuery(this.element).toggleClass("ICE-Tracking",a);this._showTitles(a);this._setInterval()},reload:function(){this._loadFromDom()},hasChanges:function(){for(var a in this._changes){var b=this._changes[a];if(b&&b.type)return!0}return!1},countChanges:function(a){return this._filterChanges(a).count},setChangeData:function(a){if(null==a||"undefined"==
typeof a)a="";this.changeData=""+a},getDeleteClass:function(){return this._getIceNodeClass("deleteType")},_triggerChange:function(){this.$this.trigger("change")},_triggerChangeText:function(){this.$this.trigger("textChange")},_setNodeTitle:function(a,b){if(!b||!this.titleTemplate)return null;var c=this.titleTemplate,d=b?b.time:parseInt(a.getAttribute(this.timeAttribute)||0),d=new Date(d),f=(b?b.username:a.getAttribute(this.userNameAttribute)||"")||"(Unknown)",c=c.replace(/%t/g,this._relativeDateFormat(d)),
c=c.replace(/%u/g,f),c=c.replace(/%dd/g,k(d.getDate(),2)),c=c.replace(/%d/g,d.getDate()),c=c.replace(/%mm/g,k(d.getMonth()+1,2)),c=c.replace(/%m/g,d.getMonth()+1),c=c.replace(/%yy/g,k(d.getYear()-100,2)),c=c.replace(/%y/g,d.getFullYear()),c=c.replace(/%nn/g,k(d.getMinutes(),2)),c=c.replace(/%n/g,d.getMinutes()),c=c.replace(/%hh/g,k(d.getHours(),2)),c=c.replace(/%h/g,d.getHours());a.setAttribute("title",c);return c},_acceptRejectSome:function(a,b){var c=function(a,c){this.acceptRejectChange(c,b)}.bind(this),
d=this._filterChanges(a),f;for(f in d.changes)ice.dom.find(this.element,"["+this.changeIdAttribute+"="+f+"]").each(c);d.count&&this._triggerChange()},_filterChanges:function(a){var b=0,c={},d=a&&a.filter,f=a&&a.exclude?jQuery.map(a.exclude,function(a){return""+a}):null,a=a&&a.include?jQuery.map(a.include,function(a){return""+a}):null,i;for(i in this._changes){var h=this._changes[i];if(h&&h.type&&!(d&&!d({userid:h.userid,time:h.time,data:h.data})||f&&0<=f.indexOf(h.userid)||a&&0>a.indexOf(h.userid)))++b,
c[i]=h}return{count:b,changes:c}},_loadFromDom:function(){this._changes={};this._userStyles={};var a=this.currentUser&&this.currentUser.id,b=this.currentUser&&this.currentUser.name||"",c=(new Date).getTime(),d=[],f;for(f in this.changeTypes)d.push(this._getIceNodeClass(f));this.getIceNodes().each(function(f,h){for(var g=0,e="",l=h.className.split(" "),f=0;f<l.length;f++){var k=RegExp(this.stylePrefix+"-(\\d+)").exec(l[f]);k&&(g=k[1]);(k=RegExp("("+d.join("|")+")").exec(l[f]))&&(e=this._getChangeTypeFromAlias(k[1]))}l=
ice.dom.attr(h,this.userIdAttribute);a&&l==a?(k=b,h.setAttribute(this.userNameAttribute,b)):k=h.getAttribute(this.userNameAttribute);this.setUserStyle(l,Number(g));g=parseInt(ice.dom.attr(h,this.changeIdAttribute)||"");isNaN(g)&&(g=this.getNewChangeId(),h.setAttribute(this.changeIdAttribute,g));var m=parseInt(h.getAttribute(this.timeAttribute)||"");isNaN(m)&&(m=c);var n=ice.dom.attr(h,this.changeDataAttribute)||"",e={type:e,userid:""+l,username:k,time:m,data:n};this._changes[g]=e;this._setNodeTitle(h,
e)}.bind(this));this._triggerChange()},_updateUserData:function(a){if(a)for(var b in this._changes){var c=this._changes[b];c.userid==a.id&&(c.username=a.name)}this.getIceNodes().each(function(b,c){var i=!a||a.id==c.getAttribute(this.userIdAttribute);a&&i&&c.setAttribute(this.userNameAttribute,a.name);i&&this._isVisible&&(i=this._changes[c.getAttribute(this.changeIdAttribute)])&&this._setNodeTitle(c,i)}.bind(this))},_showTitles:function(a){var b=this.getIceNodes();a?jQuery(b).each(function(a,b){var f=
b.getAttribute(this.changeIdAttribute);(f=f&&this._changes[f])&&this._setNodeTitle(b,f)}.bind(this)):jQuery(b).removeAttr("title")},_setInterval:function(){this.isTracking&&this.isVisible?this._refreshInterval||(this._refreshInterval=setInterval(function(){this._updateUserData(null)}.bind(this),6E4)):this._refreshInterval&&(clearInterval(this._refreshInterval),this._refreshInterval=null)},_relativeDateFormat:function(a,b){if(!a)return"";var b=b||new Date,c=b.getDate(),d=b.getMonth(),f=b.getFullYear(),
i=typeof a;if("string"==i||"number"==i)a=new Date(a);i="Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ");if(c==a.getDate()&&d==a.getMonth()&&f==a.getFullYear()){c=Math.floor((b.getTime()-a.getTime())/6E4);if(1>c)return"now";if(2>c)return"1 minute ago";if(60>c)return c+" minutes ago";d=a.getHours();c=a.getMinutes();return"on "+k(d,2)+":"+k(c,2,"0")}return f==a.getFullYear()?"on "+i[a.getMonth()]+" "+a.getDate():"on "+i[a.getMonth()]+" "+a.getDate()+", "+a.getFullYear()},_normalizeNode:function(a){if(a)return"function"==
typeof a.normalize?a.normalize():this._myNormalizeNode(a)},_myNormalizeNode:function(a){if(a)for(var b=a.firstChild;b;){if(1==b.nodeType)this._myNormalizeNode(b);else if(3==b.nodeType)for(var c;(c=b.nextSibling)&&3==c.nodeType;){var d=c.nodeValue;null!=d&&d.length&&(b.nodeValue+=d);a.removeChild(c)}b=b.nextSibling}}};this.ice=this.ice||{};this.ice.InlineChangeEditor=m}).call(this);