class App{initComponents(){Waves.init(),feather.replace(),$(window).on("load",function(){$("#status").fadeOut(),$("#preloader").delay(350).fadeOut("slow")});[...document.querySelectorAll('[data-bs-toggle="popover"]')].map(t=>new bootstrap.Popover(t)),[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(t=>new bootstrap.Tooltip(t)),[...document.querySelectorAll(".offcanvas")].map(t=>new bootstrap.Offcanvas(t));var t=document.getElementById("toastPlacement");t&&document.getElementById("selectToastPlacement").addEventListener("change",function(){t.dataset.originalClass||(t.dataset.originalClass=t.className),t.className=t.dataset.originalClass+" "+this.value});[].slice.call(document.querySelectorAll(".toast")).map(function(t){return new bootstrap.Toast(t)});const n=document.getElementById("liveAlertPlaceholder"),e=document.getElementById("liveAlertBtn");e&&e.addEventListener("click",()=>{{var t="Nice, you triggered this alert message!",e="success";const a=document.createElement("div");a.innerHTML=[`<div class="alert alert-${e} alert-dismissible" role="alert">`,`   <div>${t}</div>`,'   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',"</div>"].join(""),n.append(a)}}),document.getElementById("app-style").href.includes("rtl.min.css")&&(document.getElementsByTagName("html")[0].dir="rtl")}initPortletCard(){var a=".card";$(document).on("click",'.card a[data-bs-toggle="remove"]',function(t){t.preventDefault();var t=$(this).closest(a),e=t.parent();t.remove(),0==e.children().length&&e.remove()}),$(document).on("click",'.card a[data-bs-toggle="reload"]',function(t){t.preventDefault();var t=$(this).closest(a),e=(t.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>'),t.find(".card-disabled"));setTimeout(function(){e.fadeOut("fast",function(){e.remove()})},500+5*Math.random()*300)})}initCounterUp(){var a=$(this).attr("data-delay")?$(this).attr("data-delay"):100,n=$(this).attr("data-time")?$(this).attr("data-time"):1200;$('[data-plugin="counterup"]').each(function(t,e){$(this).counterUp({delay:a,time:n})})}initPeityCharts(){$('[data-plugin="peity-pie"]').each(function(t,e){var a=$(this).attr("data-colors")?$(this).attr("data-colors").split(","):[],n=$(this).attr("data-width")?$(this).attr("data-width"):20,i=$(this).attr("data-height")?$(this).attr("data-height"):20;$(this).peity("pie",{fill:a,width:n,height:i})}),$('[data-plugin="peity-donut"]').each(function(t,e){var a=$(this).attr("data-colors")?$(this).attr("data-colors").split(","):[],n=$(this).attr("data-width")?$(this).attr("data-width"):20,i=$(this).attr("data-height")?$(this).attr("data-height"):20;$(this).peity("donut",{fill:a,width:n,height:i})}),$('[data-plugin="peity-donut-alt"]').each(function(t,e){$(this).peity("donut")}),$('[data-plugin="peity-line"]').each(function(t,e){$(this).peity("line",$(this).data())}),$('[data-plugin="peity-bar"]').each(function(t,e){var a=$(this).attr("data-colors")?$(this).attr("data-colors").split(","):[],n=$(this).attr("data-width")?$(this).attr("data-width"):20,i=$(this).attr("data-height")?$(this).attr("data-height"):20;$(this).peity("bar",{fill:a,width:n,height:i})})}initKnob(){$('[data-plugin="knob"]').each(function(t,e){$(this).knob()})}initTippyTooltips(){0<$('[data-plugin="tippy"]').length&&tippy('[data-plugin="tippy"]')}initShowPassword(){$("[data-password]").on("click",function(){"false"==$(this).attr("data-password")?($(this).siblings("input").attr("type","text"),$(this).attr("data-password","true"),$(this).addClass("show-password")):($(this).siblings("input").attr("type","password"),$(this).attr("data-password","false"),$(this).removeClass("show-password"))})}initMultiDropdown(){$(".dropdown-menu a.dropdown-toggle").on("click",function(t){return $(this).next().hasClass("show")||$(this).parents(".dropdown-menu").first().find(".show").removeClass("show"),$(this).next(".dropdown-menu").toggleClass("show"),!1})}initLeftSidebar(){$("#side-menu").length&&($("#side-menu li .collapse").on({"show.bs.collapse":function(t){t=$(t.target).parents(".collapse.show");$("#side-menu .collapse.show").not(t).collapse("hide")}}),$("#side-menu a").each(function(){var t=window.location.href.split(/[?#]/)[0];this.href==t&&($(this).addClass("active"),$(this).parent().addClass("menuitem-active"),$(this).parent().parent().parent().addClass("show"),$(this).parent().parent().parent().parent().addClass("menuitem-active"),"sidebar-menu"!==(t=$(this).parent().parent().parent().parent().parent().parent()).attr("id")&&t.addClass("show"),$(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active"),"wrapper"!==(t=$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent()).attr("id")&&t.addClass("show"),(t=$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent()).is("body")||t.addClass("menuitem-active"))}),setTimeout(function(){var t,n,i,o,r,s,e=document.querySelector("li.active .active");function l(){t=s+=20,e=o,a=r;var t,e,a=(t/=i/2)<1?a/2*t*t+e:-a/2*(--t*(t-2)-1)+e;n.scrollTop=a,s<i&&setTimeout(l,20)}null!=e&&(t=document.querySelector(".leftbar-menu .simplebar-content-wrapper"),e=e.offsetTop-300,t&&100<e&&(i=600,o=(n=t).scrollTop,r=e-o,s=0,l()))},200))}initTopbarMenu(){$(".navbar-nav").length&&($(".navbar-nav li a").each(function(){var t=window.location.href.split(/[?#]/)[0];this.href==t&&($(this).addClass("active"),$(this).parent().parent().addClass("active"),$(this).parent().parent().parent().parent().addClass("active"),$(this).parent().parent().parent().parent().parent().parent().addClass("active"))}),$(".navbar-toggle").on("click",function(){$(this).toggleClass("open"),$("#navigation").slideToggle(400)}))}toggleRightSideBar(){document.body.classList.contains("right-bar-enabled")?document.body.classList.remove("right-bar-enabled"):document.body.classList.add("right-bar-enabled")}initMenu(){$("#top-search").on("click",function(t){$("#search-dropdown").addClass("d-block")}),$(".topbar-dropdown").on("show.bs.dropdown",function(){$("#search-dropdown").removeClass("d-block")}),$(".navbar-nav a").each(function(){var t,e=window.location.href.split(/[?#]/)[0];this.href==e&&($(this).addClass("active"),$(this).parent().addClass("active"),$(this).parent().parent().addClass("active"),$(this).parent().parent().parent().addClass("active"),$(this).parent().parent().parent().parent().addClass("active"),$(this).parent().parent().parent().parent().hasClass("mega-dropdown-menu")?($(this).parent().parent().parent().parent().parent().addClass("active"),$(this).parent().parent().parent().parent().parent().parent().addClass("active")):(t=$(this).parent().parent()[0].querySelector(".dropdown-item"))&&(e=window.location.href.split(/[?#]/)[0],t.href!=e&&!t.classList.contains("dropdown-toggle")||t.classList.add("active")),(e=$(this).parent().parent().parent().parent().addClass("active").prev()).hasClass("nav-link")&&e.addClass("active"))}),$(".navbar-toggle").on("click",function(t){$(this).toggleClass("open"),$("#navigation").slideToggle(400)});var t=document.querySelectorAll("ul.navbar-nav .dropdown .dropdown-toggle"),n=!1;t.forEach(function(a){a.addEventListener("click",function(t){var e;a.parentElement.classList.contains("nav-item")||(n=!0,a.parentElement.parentElement.classList.add("show"),(e=a.parentElement.parentElement.parentElement.querySelector(".nav-link")).ariaExpanded=!0,e.classList.add("show"),bootstrap.Dropdown.getInstance(a).show())}),a.addEventListener("hide.bs.dropdown",function(t){n&&(t.preventDefault(),t.stopPropagation(),n=!1)})})}initfullScreenListener(){var t=document.querySelector('[data-toggle="fullscreen"]');t&&t.addEventListener("click",function(t){t.preventDefault(),document.body.classList.toggle("fullscreen-enable"),document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullscreen?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)})}initFormValidation(){document.querySelectorAll(".needs-validation").forEach(e=>{e.addEventListener("submit",t=>{e.checkValidity()||(t.preventDefault(),t.stopPropagation()),e.classList.add("was-validated")},!1)})}init(){this.initComponents(),this.initPortletCard(),this.initMultiDropdown(),this.initLeftSidebar(),this.initMenu(),this.initTopbarMenu(),this.initfullScreenListener(),this.initCounterUp(),this.initPeityCharts(),this.initKnob(),this.initTippyTooltips(),this.initShowPassword(),this.initFormValidation()}}class ThemeCustomizer{constructor(){this.html=document.getElementsByTagName("html")[0],this.config={},this.defaultConfig=window.config}initConfig(){this.defaultConfig=JSON.parse(JSON.stringify(window.defaultConfig)),this.config=JSON.parse(JSON.stringify(window.config)),this.setSwitchFromConfig()}changeLeftbarColor(t){this.config.leftbar.color=t,this.html.setAttribute("data-leftbar-color",t),this.setSwitchFromConfig()}changeLeftbarSize(t,e=!0){this.html.setAttribute("data-leftbar-size",t),e&&(this.config.leftbar.size=t,this.setSwitchFromConfig())}changeLeftbarUser(t){(this.config.leftbar.user=t)?this.html.setAttribute("data-leftbar-user",t):this.html.removeAttribute("data-leftbar-user"),this.setSwitchFromConfig()}changeLeftbarPosition(t,e=!0){this.html.setAttribute("data-leftbar-position",t),e&&(this.config.leftbar.position=t,this.setSwitchFromConfig())}changeLayoutWidth(t,e=!0){this.html.setAttribute("data-layout-width",t),e&&(this.config.width=t,this.setSwitchFromConfig())}changeLayoutColor(t){this.config.theme=t,this.html.setAttribute("data-bs-theme",t),this.setSwitchFromConfig()}changeTopbarColor(t){this.config.topbar.color=t,this.html.setAttribute("data-topbar-color",t),this.setSwitchFromConfig()}resetTheme(){this.config=JSON.parse(JSON.stringify(window.defaultConfig)),this.changeLeftbarColor(this.config.leftbar.color),this.changeLeftbarSize(this.config.leftbar.size),this.changeLeftbarPosition(this.config.leftbar.position),this.changeLeftbarUser(this.config.leftbar.user),this.changeTopbarColor(this.config.topbar.color),this.changeLayoutColor(this.config.theme),this.changeLayoutWidth(this.config.width),this._adjustLayout()}initSwitchListener(){var a=this,t=(document.querySelectorAll("input[name=data-leftbar-color]").forEach(function(e){e.addEventListener("change",function(t){a.changeLeftbarColor(e.value)})}),document.querySelectorAll("input[name=data-leftbar-size]").forEach(function(e){e.addEventListener("change",function(t){a.changeLeftbarSize(e.value)})}),document.querySelectorAll("input[name=data-leftbar-position]").forEach(function(e){e.addEventListener("change",function(t){a.changeLeftbarPosition(e.value)})}),document.querySelectorAll("input[name=data-leftbar-user]").forEach(function(e){e.addEventListener("change",function(t){a.changeLeftbarUser(e.checked)})}),document.querySelectorAll("input[name=data-bs-theme]").forEach(function(e){e.addEventListener("change",function(t){a.changeLayoutColor(e.value)})}),document.querySelectorAll("input[name=data-layout-width]").forEach(function(e){e.addEventListener("change",function(t){a.changeLayoutWidth(e.value)})}),document.querySelectorAll("input[name=data-topbar-color]").forEach(function(e){e.addEventListener("change",function(t){a.changeTopbarColor(e.value)})}),document.getElementById("light-dark-mode")),t=(t&&t.addEventListener("click",function(t){"light"===a.config.theme?a.changeLayoutColor("dark"):a.changeLayoutColor("light")}),document.querySelector("#reset-layout")),t=(t&&t.addEventListener("click",function(t){a.resetTheme()}),document.querySelector(".button-menu-mobile"));t&&t.addEventListener("click",function(){var t=a.config.leftbar.size,e=a.html.getAttribute("data-leftbar-size",t);"hidden"===e?a.showBackdrop():"condensed"===e?a.changeLeftbarSize("condensed"==t?"default":t,!1):a.changeLeftbarSize("condensed",!1),a.html.classList.toggle("sidebar-enable")})}showBackdrop(){const t=document.createElement("div"),e=(t.id="custom-backdrop",t.classList="offcanvas-backdrop fade show",document.body.appendChild(t),document.body.style.overflow="hidden",767<window.innerWidth&&(document.body.style.paddingRight="15px"),this);t.addEventListener("click",function(t){e.html.classList.remove("sidebar-enable"),e.hideBackdrop()})}hideBackdrop(){var t=document.getElementById("custom-backdrop");t&&(document.body.removeChild(t),document.body.style.overflow=null,document.body.style.paddingRight=null)}initWindowSize(){var e=this;window.addEventListener("resize",function(t){e._adjustLayout()})}_adjustLayout(){var t=this;window.innerWidth<=991.99?t.changeLeftbarSize("hidden",!1):(t.changeLeftbarSize(t.config.leftbar.size),t.changeLayoutWidth(t.config.width))}setSwitchFromConfig(){sessionStorage.setItem("__ADMINTO_CONFIG__",JSON.stringify(this.config)),document.querySelectorAll(".right-bar input[type=checkbox]").forEach(function(t){t.checked=!1});var t,e,a,n,i,o,r,s=this.config;s&&(t=document.querySelector("input[type=checkbox][name=data-bs-theme][value="+s.theme+"]"),e=document.querySelector("input[type=checkbox][name=data-layout-width][value="+s.width+"]"),a=document.querySelector("input[type=checkbox][name=data-topbar-color][value="+s.topbar.color+"]"),n=document.querySelector("input[type=checkbox][name=data-leftbar-color][value="+s.leftbar.color+"]"),i=document.querySelector("input[type=checkbox][name=data-leftbar-size][value="+s.leftbar.size+"]"),o=document.querySelector("input[type=checkbox][name=data-leftbar-user][value="+s.leftbar.user+"]"),r=document.querySelector("input[type=checkbox][name=data-leftbar-position][value="+s.leftbar.position+"]"),t&&(t.checked=!0),e&&(e.checked=!0),a&&(a.checked=!0),n&&(n.checked=!0),i&&(i.checked=!0),r&&(r.checked=!0),o&&"true"===s.leftbar.user.toString()&&(o.checked=!0))}init(){this.initConfig(),this.initSwitchListener(),this.initWindowSize(),this._adjustLayout(),this.setSwitchFromConfig()}}document.addEventListener("DOMContentLoaded",function(t){(new App).init(),(new ThemeCustomizer).init()});