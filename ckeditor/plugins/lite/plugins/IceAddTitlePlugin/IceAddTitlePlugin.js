(function(){var a;a=function(b){this._ice=b};a.prototype={nodeCreated:function(b,a){b.setAttribute("title",(a.action||"Modified")+" by "+b.getAttribute(this._ice.userNameAttribute)+" - "+ice.dom.date("m/d/Y h:ia",parseInt(b.getAttribute(this._ice.timeAttribute))))}};ice.dom.noInclusionInherits(a,ice.IcePlugin);this._plugin.IceAddTitlePlugin=a}).call(this.ice);