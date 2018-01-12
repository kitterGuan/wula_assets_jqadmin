layui.define(["jquery","layer"],function(t){var i=layui.jquery,e=layui.layer,a="",n=function(){};n.prototype.init=function(){var t=this;i(".tag-defined:not([tag-bind]),.tag:not([tag-bind])").each(function(){t.setBind(i(this)),i(this).bind("click",{tags:t},t.click)})},n.prototype.setBind=function(t){t.attr("tag-bind",1)},n.prototype.addTag=function(t){var n=i.trim(t.val());if(""!=n){if(n.indexOf(",")>=0)return e.msg('标签不能包含","'),void(a=n);if(n.indexOf("|")>=0)return e.msg('标签不能包含"|"'),void(a=n);if(n.length>10)return e.msg("您最多只能输入10个字符"),void(a=n);if(Number(n))return e.msg("标签不能纯数字"),void(a="");var s='<div class="tag" data-id="0"><p class="text">'+n+'</p><p class="tick-box"><span class="tick-bg"></span><i class="iconfont tick">&#xe6a1;</i></p></div>';t.parent("div.tag-defined").before(s).empty().css({padding:"0 20px"}).html("自定义标签").prev(".tag").bind("click",{tags:this},this.click).trigger("click"),a=""}else t.parent("div").empty().css({padding:"0 20px"}).html("自定义标签")},n.prototype.text=function(t){var e=this,n=i('<input type="text" />').css({width:"112px",height:"36px",border:"none",outline:"none","text-align":"center"});t.css({padding:"0"}).html(n),n.focus().val(a),n.blur(function(){e.addTag(i(this))}),n.keyup(function(t){if(13==t.which)return e.addTag(i(this)),!1})},n.prototype.click=function(t){_tags=t.data.tags,void 0==i(this).attr("data-id")?_tags.text(i(this)):_tags.select(i(this))},n.prototype.select=function(t){var e=t.attr("data-id")+"|"+i.trim(t.find(".text").text());t.hasClass("tag-selected")?(t.removeClass("tag-selected"),t.find(".tick-box").hide(),this.setval(t,e,"del")):(t.addClass("tag-selected"),t.find(".tick-box").show(),this.setval(t,e,"add"))},n.prototype.setval=function(t,i,a){var n=t.parent("div.layui-input-block").find("input[type=hidden]"),s=n.val();if(t.parent("div.layui-input-block").find(".tag-selected").length>parseInt(n.data("count")))return e.msg("最多只能选择5个标签"),t.removeClass("tag-selected"),void t.find(".tick-box").hide();if(""!=s){var d=s.split(",");"del"==a?d.remove(i):d.push(i),i=d.join(",")}n.val(i)},Array.prototype.indexOf=function(t){for(var i=0;i<this.length;i++)if(this[i]==t)return i;return-1},Array.prototype.remove=function(t){var i=this.indexOf(t);i>-1&&this.splice(i,1)};var s=new n;s.init(),t("jqtags",s)});