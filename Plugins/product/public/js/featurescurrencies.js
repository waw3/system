!function(e){var t={};function i(a){if(t[a])return t[a].exports;var n=t[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=t,i.d=function(e,t,a){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(a,n,function(t){return e[t]}.bind(null,n));return a},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/",i(i.s=412)}({412:function(e,t,i){e.exports=i(413)},413:function(e,t){function i(e,t){for(var i=0;i<t.length;i++){var a=t[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}var a=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.template=$("#currency_template").html(),this.totalItem=0,this.deletedItems=[],this.initData(),this.handleForm()}var t,a,n;return t=e,(a=[{key:"initData",value:function(){var e=this,t=$.parseJSON($("#currencies").html());$.each(t,(function(t,i){var a=e.template.replace(/__id__/gi,i.id).replace(/__position__/gi,i.order).replace(/__isPrefixSymbolChecked__/gi,1==i.is_prefix_symbol?"selected":"").replace(/__notIsPrefixSymbolChecked__/gi,0==i.is_prefix_symbol?"selected":"").replace(/__isDefaultChecked__/gi,1==i.is_default?"checked":"").replace(/__title__/gi,i.title).replace(/__decimals__/gi,i.decimals).replace(/__exchangeRate__/gi,i.exchange_rate).replace(/__symbol__/gi,i.symbol);$(".swatches-container .swatches-list").append(a),e.totalItem++}))}},{key:"addNewAttribute",value:function(){var e=this.template.replace(/__id__/gi,0).replace(/__position__/gi,this.totalItem).replace(/__isPrefixSymbolChecked__/gi,"").replace(/__notIsPrefixSymbolChecked__/gi,"").replace(/__isDefaultChecked__/gi,0==this.totalItem?"checked":"").replace(/__title__/gi,"").replace(/__decimals__/gi,0).replace(/__exchangeRate__/gi,1).replace(/__symbol__/gi,"");$(".swatches-container .swatches-list").append(e),this.totalItem++}},{key:"exportData",value:function(){var e=[];return $(".swatches-container .swatches-list li").each((function(t,i){var a=$(i);e.push({id:a.data("id"),is_default:a.find("[data-type=is_default] input[type=radio]").is(":checked")?1:0,order:a.index(),title:a.find("[data-type=title] input").val(),symbol:a.find("[data-type=symbol] input").val(),decimals:a.find("[data-type=decimals] input").val(),exchange_rate:a.find("[data-type=exchange_rate] input").val(),is_prefix_symbol:a.find("[data-type=is_prefix_symbol] select").val()})})),e}},{key:"handleForm",value:function(){var e=this;$(".swatches-container .swatches-list").sortable(),$("body").on("submit",".main-setting-form",(function(){var t=e.exportData();$("#currencies").val(JSON.stringify(t)),$("#deleted_currencies").val(JSON.stringify(e.deletedItems))})).on("click",".js-add-new-attribute",(function(t){t.preventDefault(),e.addNewAttribute()})).on("click",".swatches-container .swatches-list li .remove-item a",(function(t){t.preventDefault();var i=$(t.currentTarget).closest("li");e.deletedItems.push(i.data("id")),i.remove()}))}}])&&i(t.prototype,a),n&&i(t,n),e}();$(window).on("load",(function(){new a}))}});