jQuery(function(n){const e=n(".equal-fields");var a=n(".url_origin").find("input"),n=n(".url_destiny"),l=n.find("input"),o=n.find("label");function i(){a.val()==l.val()?(e.addClass("text-danger"),o.append('<span class="text-danger"> (não pode ser igual a url de origem)<span>')):(e.removeClass("text-danger"),o.find("span").remove())}a.on("input",function(){console.log(a.val()),i()}),l.on("input",function(){console.log(l.val()),i()})});

//# sourceMappingURL=main-admin.js.map
