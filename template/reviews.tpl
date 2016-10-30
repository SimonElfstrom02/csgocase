<style>
  footer {
    /*margin-top: 190px;*/
  }
</style>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<div id="vk_api_transport"></div>
<script type="text/javascript">
  window.vkAsyncInit = function() {
    VK.init({
      apiId: 5194761
    });
  };

  setTimeout(function() {
    var el = document.createElement("script");
    el.type = "text/javascript";
    el.src = "//vk.com/js/api/openapi.js";
    el.async = true;
    document.getElementById("vk_api_transport").appendChild(el);
  }, 0);
</script>
<div class="opencase nobg">
	<div class="opencase nobg">
      <div class="opencase-title">Главная     &gt;     <span>Отзывы о сайте</span></div>
	</div>
</div>
<br>
<center><a href="https://vk.com/csupru" target="_blank"><img src="template/img/banner.png"></a></center>
<br>
<script type="text/javascript">
  VK.init({apiId: 5194761, onlyWidgets: true});
</script>
<center>
<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments" style="margin: auto; height: 3782px; width: 1000px; background: none;"/>
<script type="text/javascript">
	VK.Widgets.Comments("vk_comments", {limit: 10, width: "920", attach: "*", pageUrl: 'http://case-up.ru/?page=reviews'});
</script>
</center>