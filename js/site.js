
/*Noisy : https://github.com/DanielRapp/Noisy */
(function(d){d.fn.noisy=function(b){b=d.extend({},d.fn.noisy.defaults,b);var c,h,a=!1;try{h=!0,a=localStorage.getItem(window.JSON.stringify(b))}catch(m){h=!1}if(a)c=a;else{a=document.createElement("canvas");if(a.getContext){a.width=a.height=b.size;for(var j=a.getContext("2d"),e=j.createImageData(a.width,a.height),k=Math.round(b.intensity*Math.pow(b.size,2)),l=255*b.opacity;k--;){var f=~~(Math.random()*a.width),g=~~(Math.random()*a.height),f=4*(f+g*e.width),g=k%255;e.data[f]=g;e.data[f+1]=b.monochrome?
g:~~(255*Math.random());e.data[f+2]=b.monochrome?g:~~(255*Math.random());e.data[f+3]=~~(Math.random()*l)}j.putImageData(e,0,0);c=a.toDataURL("image/png");0!=c.indexOf("data:image/png")&&(c=b.fallback)}else c=b.fallback;window.JSON&&h&&localStorage.setItem(window.JSON.stringify(b),c)}return this.each(function(){d(this).css("background-image","url('"+c+"'),"+d(this).css("background-image"))})};d.fn.noisy.defaults={intensity:0.9,size:200,opacity:0.08,fallback:"",monochrome:!1}})(jQuery);

/*Non-plugin stuff*/
jQuery('body').noisy({
    'intensity' : 0.5, 
    'size' : 200, 
    'opacity' : 0.06, 
    'fallback' : '', 
    'monochrome' : false
});
jQuery('#bigfoot').noisy({
    'intensity' : 0.5, 
    'size' : 80, 
    'opacity' : 0.06, 
    'fallback' : '', 
    'monochrome' : false
}).find('.inner').noisy({
    'intensity' : 1, 
    'size' : 80, 
    'opacity' : 0.06, 
    'fallback' : '', 
    'monochrome' : false
});
jQuery('#top-wrapper').find('.border').noisy({
    'intensity' : 0.5, 
    'size' : 80, 
    'opacity' : 0.05, 
    'fallback' : '', 
    'monochrome' : true
});

jQuery('#main-nav').find('.navbar-inner').noisy({
    'intensity' : 0.5, 
    'size' : 40, 
    'opacity' : 0.05, 
    'fallback' : '', 
    'monochrome' : true
});

jQuery(document).ready(function(){
  $(".carousel-indicators li:first").addClass("active");
  $(".carousel-inner .item:first").addClass("active");
});
