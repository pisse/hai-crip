define(["handlebars"],function(Handlebars){this["Tpl_home"] = this["Tpl_home"] || {};
this["Tpl_home"]["banner"] = Handlebars.template({"1":function(depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "    <div class=\"s-item\">\r\n        <a href=\""
    + alias3(((helper = (helper = helpers.url || (depth0 != null ? depth0.url : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"url","hash":{},"data":data}) : helper)))
    + "\"><img src=\""
    + alias3(((helper = (helper = helpers.pic_url || (depth0 != null ? depth0.pic_url : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"pic_url","hash":{},"data":data}) : helper)))
    + "\"></a>\r\n    </div>\r\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1;

  return "\r\n<div class=\"swipe-wrap\">\r\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.item : depth0),{"name":"each","hash":{},"fn":this.program(1, data, 0),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "</div>";
},"useData":true}); return this.Tpl_home;})