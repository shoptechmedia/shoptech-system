function initFilters(){if("undefined"!=typeof filters){for(key in filters){if(filters.hasOwnProperty(key))var e=filters[key];if("undefined"!=typeof e.slider&&0==parseInt(e.filter_type)){var t=parseInt(e.max)-parseInt(e.min),a=t/100;a>1&&(a=parseInt(a)),addSlider(e.type,{range:!0,step:a,min:parseInt(e.min),max:parseInt(e.max),values:[e.values[0],e.values[1]],slide:function(e,t){stopAjaxQuery(),parseInt($(e.target).data("format"))<5?(from=formatCurrency(t.values[0],parseInt($(e.target).data("format")),$(e.target).data("unit")),to=formatCurrency(t.values[1],parseInt($(e.target).data("format")),$(e.target).data("unit"))):(from=t.values[0]+$(e.target).data("unit"),to=t.values[1]+$(e.target).data("unit")),$("#layered_"+$(e.target).data("type")+"_range").html(from+" - "+to)},stop:function(){reloadContent(!0)}},e.unit,parseInt(e.format))}else"undefined"!=typeof e.slider&&1==parseInt(e.filter_type)&&($("#layered_"+e.type+"_range_min").attr("limitValue",e.min),$("#layered_"+e.type+"_range_max").attr("limitValue",e.max));$(".layered_"+e.type).show()}initUniform()}}function initUniform(){$("#layered_form input[type='checkbox'], #layered_form input[type='radio'], select.form-control").uniform()}function hideFilterValueAction(e){"undefined"==typeof layered_hidden_list[$(e).parent().find("ul").attr("id")]||0==layered_hidden_list[$(e).parent().find("ul").attr("id")]?($(e).parent().find(".hiddable").hide(),$(e).parent().find(".hide-action.less").hide(),$(e).parent().find(".hide-action.more").show()):($(e).parent().find(".hiddable").show(),$(e).parent().find(".hide-action.less").show(),$(e).parent().find(".hide-action.more").hide())}function addSlider(e,t,a,r){sliderList.push({type:e,data:t,unit:a,format:r})}function initSliders(){$(sliderList).each(function(e,t){$("#layered_"+t.type+"_slider").slider(t.data);var a="",r="";switch(t.format){case 1:case 2:case 3:case 4:a=formatCurrency($("#layered_"+t.type+"_slider").slider("values",0),t.format,t.unit),r=formatCurrency($("#layered_"+t.type+"_slider").slider("values",1),t.format,t.unit);break;case 5:a=$("#layered_"+t.type+"_slider").slider("values",0)+t.unit,r=$("#layered_"+t.type+"_slider").slider("values",1)+t.unit}$("#layered_"+t.type+"_range").html(a+" - "+r)})}function initLayered(){if(initFilters(),initSliders(),initLocationChange(),updateProductUrl(),2==window.location.href.split("#").length&&""!=window.location.href.split("#")[1]){var e=window.location.href.split("#")[1];reloadContent("&selected_filters="+e)}}function paginationButton(e,t){if("undefined"==typeof current_friendly_url&&(current_friendly_url="#"),$("div.pagination a").not(":hidden").each(function(){if(-1==$(this).attr("href").search(/(\?|&)p=/))var e=1;else var e=parseInt($(this).attr("href").replace(/^.*(\?|&)p=(\d+).*$/,"$2"));var t=window.location.href.replace(/#.*$/,"");$(this).attr("href",t+current_friendly_url.replace(/\/page-(\d+)/,"")+"/page-"+e)}),$("div.pagination li").not(".current, .disabled").each(function(){var e=0;$(this).hasClass("pagination_next")?e=parseInt($("div.pagination li.current").children().children().html())+1:$(this).hasClass("pagination_previous")&&(e=parseInt($("div.pagination li.current").children().children().html())-1),$(this).children().children().on("click",function(t){t.preventDefault(),0==e?p=parseInt($(this).html())+parseInt(e):p=e,p="&p="+p,reloadContent(p),e=0})}),0!=e)if(0==isNaN(e)){var a=$(".product-count").html(),r=parseInt($("div.pagination li.current").children().children().html()),i=e;if(0==$("#nb_item option:selected").length)var n=i;else var n=parseInt($("#nb_item option:selected").val());r=isNaN(r)?1:r,i>n*r?productShowing=n*r:productShowing=-1*(n*r-i-n*r),1==r?productShowingStart=1:productShowingStart=n*r-n+1,a=$.trim(a),a=a.split(" ");var l=new Array;for(row in a)parseInt(a[row])+0==parseInt(a[row])&&l.push(row);"undefined"!=typeof l[0]&&(a[l[0]]=productShowingStart),"undefined"!=typeof l[1]&&(a[l[1]]="undefined"!=t&&t>productShowing?t:productShowing),"undefined"!=typeof l[2]&&(a[l[2]]=i),"undefined"!=typeof l[1]&&"undefined"!=typeof l[2]&&a[l[1]]>a[l[2]]&&(a[l[1]]=a[l[2]]),a=a.join(" "),$(".product-count").html(a),$(".product-count").show()}else $(".product-count").hide()}function cancelFilter(){$(document).on("click","#enabled_filters a",function(e){$(this).data("rel").search(/_slider$/)>0?$("#"+$(this).data("rel")).length?($("#"+$(this).data("rel")).slider("values",0,$("#"+$(this).data("rel")).slider("option","min")),$("#"+$(this).data("rel")).slider("values",1,$("#"+$(this).data("rel")).slider("option","max")),$("#"+$(this).data("rel")).slider("option","slide")(0,{values:[$("#"+$(this).data("rel")).slider("option","min"),$("#"+$(this).data("rel")).slider("option","max")]})):$("#"+$(this).data("rel").replace(/_slider$/,"_range_min")).length&&($("#"+$(this).data("rel").replace(/_slider$/,"_range_min")).val($("#"+$(this).data("rel").replace(/_slider$/,"_range_min")).attr("limitValue")),$("#"+$(this).data("rel").replace(/_slider$/,"_range_max")).val($("#"+$(this).data("rel").replace(/_slider$/,"_range_max")).attr("limitValue"))):$("option#"+$(this).data("rel")).length?$("#"+$(this).data("rel")).parent().val(""):($("#"+$(this).data("rel")).attr("checked",!1),$("."+$(this).data("rel")).attr("checked",!1),$("#layered_form input[type=hidden][name="+$(this).data("rel")+"]").remove()),reloadContent(!0),e.preventDefault()})}function openCloseFilter(){$(document).on("click","#layered_form span.layered_close a",function(e){"&lt;"==$(this).html()?($("#"+$(this).data("rel")).show(),$(this).html("v"),$(this).parent().removeClass("closed")):($("#"+$(this).data("rel")).hide(),$(this).html("&lt;"),$(this).parent().addClass("closed")),e.preventDefault()})}function stopAjaxQuery(){for("undefined"==typeof ajaxQueries&&(ajaxQueries=new Array),i=0;i<ajaxQueries.length;i++)ajaxQueries[i].abort();ajaxQueries=new Array}function reloadContent(e){if(stopAjaxQuery(),ajaxLoaderOn||($(".product_list").prepend($("#layered_ajax_loader").html()),$(".product_list").css("opacity","0.7"),ajaxLoaderOn=1),data=$("#layered_form").serialize(),$(".layered_slider").each(function(){var e=$(this).slider("values",0),t=$(this).slider("values",1);"number"==typeof e&&"number"==typeof t&&(data+="&"+$(this).attr("id")+"="+e+"_"+t)}),$(["price","weight"]).each(function(e,t){$("#layered_"+t+"_range_min").length&&(data+="&layered_"+t+"_slider="+$("#layered_"+t+"_range_min").val()+"_"+$("#layered_"+t+"_range_max").val())}),$("#layered_form .select option").each(function(){$(this).attr("id")&&$(this).parent().val()==$(this).val()&&(data+="&"+$(this).attr("id")+"="+$(this).val())}),$(".selectProductSort").length&&$(".selectProductSort").val()){if($(".selectProductSort").val().search(/orderby=/)>0)var t=[$(".selectProductSort").val().match(/orderby=(\w*)/)[1],$(".selectProductSort").val().match(/orderway=(\w*)/)[1]];else var t=$(".selectProductSort").val().split(":");data+="&orderby="+t[0]+"&orderway="+t[1]}$("select[name=n]:first").length&&(e?data+="&n="+$("select[name=n]:first").val():data+="&n="+$("div.pagination form.showall").find("input[name=n]").val());var a=!0;(void 0==e||"string"!=typeof e)&&(e="",a=!1);var r="";e&&$("div.pagination select[name=n]").children().each(function(e,t){t.selected&&(r="&n="+t.value)}),ajaxQuery=$.ajax({type:"GET",url:baseDir+"modules/blocklayered/blocklayered-ajax.php",data:data+e+r,dataType:"json",cache:!1,success:function(e){if(""!=e.meta_description&&$('meta[name="description"]').attr("content",e.meta_description),""!=e.meta_keywords&&$('meta[name="keywords"]').attr("content",e.meta_keywords),""!=e.meta_title&&$("title").html(e.meta_title),""!=e.heading&&$("h1.page-heading .cat-name").html(e.heading),$("#layered_block_left").replaceWith(utf8_decode(e.filtersBlock)),$(".category-product-count, .heading-counter").html(e.categoryCount),e.nbRenderedProducts==e.nbAskedProducts&&$("div.clearfix.selector1").hide(),e.productList?$(".product_list").replaceWith(utf8_decode(e.productList)):$(".product_list").html(""),$(".product_list").css("opacity","1"),$.browser.msie&&$(".product_list").css("filter",""),e.pagination.search(/[^\s]/)>=0){var t=$("<div/>").html(e.pagination),r=$("<div/>").html(e.pagination_bottom);$("<div/>").html(t).find("#pagination").length?($("#pagination").show(),$("#pagination").replaceWith(t.find("#pagination"))):$("#pagination").hide(),$("<div/>").html(r).find("#pagination_bottom").length?($("#pagination_bottom").show(),$("#pagination_bottom").replaceWith(r.find("#pagination_bottom"))):$("#pagination_bottom").hide()}else $("#pagination").hide(),$("#pagination_bottom").hide();if(paginationButton(e.nbRenderedProducts,e.nbAskedProducts),ajaxLoaderOn=0,$("div.pagination form").on("submit",function(e){e.preventDefault(),val=$("div.pagination select[name=n]").val(),$("div.pagination select[name=n]").children().each(function(e,t){t.value==val?$(t).attr("selected",!0):$(t).removeAttr("selected")}),reloadContent()}),"undefined"!=typeof ajaxCart&&ajaxCart.overrideButtonsInThePage(),"function"==typeof reloadProductComparison&&reloadProductComparison(),filters=e.filters,initFilters(),initSliders(),current_friendly_url=e.current_friendly_url,"undefined"==typeof current_friendly_url&&(current_friendly_url="#"),$(["price","weight"]).each(function(e,t){$("#layered_"+t+"_slider").length?"object"!=typeof $("#layered_"+t+"_slider").slider("values",0)&&($("#layered_"+t+"_slider").slider("values",0)!=$("#layered_"+t+"_slider").slider("option","min")||$("#layered_"+t+"_slider").slider("values",1)!=$("#layered_"+t+"_slider").slider("option","max"))&&(current_friendly_url+="/"+blocklayeredSliderName[t]+"-"+$("#layered_"+t+"_slider").slider("values",0)+"-"+$("#layered_"+t+"_slider").slider("values",1)):$("#layered_"+t+"_range_min").length&&(current_friendly_url+="/"+blocklayeredSliderName[t]+"-"+$("#layered_"+t+"_range_min").val()+"-"+$("#layered_"+t+"_range_max").val())}),window.location.href=current_friendly_url,"#/show-all"!=current_friendly_url&&$("div.clearfix.selector1").show(),lockLocationChecking=!0,a&&$.scrollTo(".product_list",400),updateProductUrl(),$(".hide-action").each(function(){hideFilterValueAction(this)}),display instanceof Function){var i=$.totalStorage("display");i&&"grid"!=i&&display(i)}}}),ajaxQueries.push(ajaxQuery)}function initLocationChange(e,t){t||(t=500);var a=getUrlParams();setInterval(function(){if(getUrlParams()==a||lockLocationChecking)lockLocationChecking=!1,a=getUrlParams();else{if(a.replace(/^#(\/)?/,"")==getUrlParams().replace(/^#(\/)?/,""))return;lockLocationChecking=!0,reloadContent("&selected_filters="+getUrlParams().replace(/^#/,""))}},t)}function getUrlParams(){"undefined"==typeof current_friendly_url&&(current_friendly_url="#");var e=current_friendly_url;return 2==window.location.href.split("#").length&&""!=window.location.href.split("#")[1]&&(e="#"+window.location.href.split("#")[1]),e}function updateProductUrl(){"undefined"!=typeof param_product_url&&""!=param_product_url&&"#"!=param_product_url&&$.each($("ul.product_list li.ajax_block_product .product_img_link,ul.product_list li.ajax_block_product h5 a,ul.product_list li.ajax_block_product .product_desc a,ul.product_list li.ajax_block_product .lnk_view"),function(){$(this).attr("href",$(this).attr("href")+param_product_url)})}function utf8_decode(e){for(var t="",a=0;a<e.length;){var r=e.charCodeAt(a);if(128>r)t+=String.fromCharCode(r),a++;else if(r>191&&224>r){var i=e.charCodeAt(a+1);t+=String.fromCharCode((31&r)<<6|63&i),a+=2}else{var i=e.charCodeAt(a+1),n=e.charCodeAt(a+2);t+=String.fromCharCode((15&r)<<12|(63&i)<<6|63&n),a+=3}}return t}var ajaxQueries=new Array,ajaxLoaderOn=0,sliderList=new Array,slidersInit=!1;$(document).ready(function(){cancelFilter(),openCloseFilter(),$(document).on("click","#layered_form input[type=button], #layered_form label.layered_color",function(e){$("input[name="+$(this).attr("name")+"][type=hidden]").length?$("input[name="+$(this).attr("name")+"][type=hidden]").remove():$("<input />").attr("type","hidden").attr("name",$(this).attr("name")).val($(this).data("rel")).appendTo("#layered_form"),reloadContent(!0)}),$(document).on("click","#layered_form .select, #layered_form input[type=checkbox], #layered_form input[type=radio]",function(e){reloadContent(!0)}),$(document).on("keyup","#layered_form input.layered_input_range",function(e){$(this).attr("timeout_id")&&window.clearTimeout($(this).attr("timeout_id"));var t=this;$(this).attr("timeout_id",window.setTimeout(function(e){$(e).attr("id")||(e=t);var a=$(e).attr("id").replace(/^layered_(.+)_range_.*$/,"$1"),r=parseInt($("#layered_"+a+"_range_min").val());isNaN(r)&&(r=0),$("#layered_"+a+"_range_min").val(r);var i=parseInt($("#layered_"+a+"_range_max").val());isNaN(i)&&(i=0),$("#layered_"+a+"_range_max").val(i),r>i&&($("#layered_"+a+"_range_max").val($(e).val()),$("#layered_"+a+"_range_min").val($(e).val())),reloadContent()},500,this))}),$(document).on("click","#layered_block_left .radio",function(e){var t=$(this).attr("name");return $.each($(this).parent().parent().find("input[type=button]"),function(e,a){$(a).hasClass("on")&&$(a).attr("name")!=t&&$(a).click()}),!0}),$("#layered_block_left label a").on({click:function(e){e.preventDefault();var t=$(this).parent().parent().find("input").attr("disabled");(""==t||"undefined"==typeof t||0==t)&&($(this).parent().parent().find("input").click(),reloadContent())}}),layered_hidden_list={},$(".hide-action").on("click",function(e){"undefined"==typeof layered_hidden_list[$(this).parent().find("ul").attr("id")]||0==layered_hidden_list[$(this).parent().find("ul").attr("id")]?layered_hidden_list[$(this).parent().find("ul").attr("id")]=!0:layered_hidden_list[$(this).parent().find("ul").attr("id")]=!1,hideFilterValueAction(this)}),$(".hide-action").each(function(){hideFilterValueAction(this)}),$(".selectProductSort").unbind("change").bind("change",function(e){$(".selectProductSort").val($(this).val()),$("#layered_form").length>0&&reloadContent(!0)}),$(document).off("change").on("change","select[name=n]",function(e){$("select[name=n]").val($(this).val()),reloadContent(!0)}),paginationButton(!1),initLayered()});