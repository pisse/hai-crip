define(["handlebars"],function(Handlebars){this["Templates"] = this["Templates"] || {};
this["Templates"]["calendar-tabs"] = Handlebars.template({"1":function(depth0,helpers,partials,data,blockParams,depths) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=this.escapeExpression;

  return "            <li class=\"tab\" data-key=\""
    + alias3(((helper = (helper = helpers.key || (data && data.key)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"key","hash":{},"data":data}) : helper)))
    + "\" style=\"width: "
    + alias3(this.lambda((depths[1] != null ? depths[1].width : depths[1]), depth0))
    + "\">\r\n                <div class=\"wrap thin-border\">\r\n                    "
    + alias3(((helper = (helper = helpers.month || (depth0 != null ? depth0.month : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"month","hash":{},"data":data}) : helper)))
    + "月<em><span class=\"small\">¥</span>"
    + alias3(((helper = (helper = helpers.price || (depth0 != null ? depth0.price : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"price","hash":{},"data":data}) : helper)))
    + "</em><span class=\"end small\">起</span>\r\n                </div>\r\n            </li>\r\n";
},"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data,blockParams,depths) {
    var stack1;

  return "<section class=\"calendar-tab\">\r\n    <ul class=\"tabs\">\r\n"
    + ((stack1 = helpers.each.call(depth0,(depth0 != null ? depth0.datas : depth0),{"name":"each","hash":{},"fn":this.program(1, data, 0, blockParams, depths),"inverse":this.noop,"data":data})) != null ? stack1 : "")
    + "    </ul>\r\n</section>\r\n\r\n\r\n";
},"useData":true,"useDepths":true});
this["Templates"]["calendar"] = Handlebars.template({"compiler":[6,">= 2.0.0-beta.1"],"main":function(depth0,helpers,partials,data) {
    var stack1, helper;

  return "<div class=\"tn-item-container\">\r\n    <div class=\"tn-c-body\">\r\n        <table>\r\n            <tbody>\r\n            <tr class=\"tn-c-week\">\r\n                <th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th>\r\n            </tr>\r\n            "
    + ((stack1 = ((helper = (helper = helpers['cal-td'] || (depth0 != null ? depth0['cal-td'] : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"cal-td","hash":{},"data":data}) : helper))) != null ? stack1 : "")
    + "\r\n            </tbody>\r\n        </table>\r\n    </div>\r\n</div>";
},"useData":true}); return this.Templates;})