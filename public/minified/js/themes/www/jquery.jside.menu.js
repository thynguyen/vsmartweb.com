/*!  Plugin: jSide Menu (Responsive Side Menu) 
 *   Dependency: jQuery 3.4.1 & Material Design Iconic Font 2.0
 *   Author: Asif Mughal
 *   GitHub: https://github.com/CodeHimBlog
 *   URL: https://www.codehim.com
 *   License: MIT License
 *   Copyright (c) 2018 - 2019 - Asif Mughal
 */
(function($){$.fn.jSideMenu=function(options){var setting=$.extend({jSidePosition:"position-left",jSideSticky:!0,jSideSkin:"default-skin",jSideTransition:400,},options);return this.each(function(){var jSide,target,headHeight,devHeight,arrow,dimBackground;target=$(this);jSide=$(".menu-container, .menu-head");devHeight=$(window).height();headHeight=$(".menu-head").height();dHeading=$(".dropdown-heading");menuTrigger=$(".menu-trigger");arrow=$("<i></i>");dimBackground=$("<div>");$(target).css({'height':devHeight-headHeight,});if(setting.jSideSticky==!0){$(".menubar").addClass("sticky")}else{$(".menubar").removeClass("sticky")}
$(".menubar").addClass(setting.jSideSkin);$(jSide).addClass(setting.jSideSkin).addClass(setting.jSidePosition);if($(jSide).hasClass("position-left")){$(".menu-trigger").addClass("left").removeClass("right")}else{$(".menu-trigger").removeClass("left").addClass("right")}
$(arrow).addClass("material-icons d-arrow").html("keyboard_arrow_down").appendTo(dHeading);$(dimBackground).addClass("dim-overlay").appendTo("body");$(dHeading).click(function(){$(this).parent().find("ul").slideToggle(setting.jSideTransition);$(this).find(".d-arrow").toggleClass("d-down")});$(menuTrigger).click(function(){$(jSide).toggleClass("open");$(dimBackground).show(setting.jSideTransition);$(".menu-body").removeClass("visibility")});$(window).click(function(e){if($(e.target).closest('.menu-trigger').length){return}
if($(e.target).closest(jSide).length){return}
$(jSide).removeClass("open");if(!$(jSide).hasClass("open")){$(dimBackground).hide(setting.jSideTransition)}
$(".menu-body").addClass("visibility")})})}})(jQuery)