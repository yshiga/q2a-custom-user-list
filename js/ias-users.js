$(function(){
    $('.ias-spinner').hide();
    if($('.users-list').length && $(".qa-page-links").length) {
      var ias = $(".mdl-layout__content").ias({
        container: ".users-list"
        ,item: ".user-item"
        ,pagination: ".qa-page-links"
        ,next: ".qa-page-links .qa-page-next"
        ,delay: 600
      });
      ias.extension(new IASTriggerExtension({
          text: "続きを読む",
          textPrev: "前を読む",
          offset: 100,
      }));
      ias.extension(new IASNoneLeftExtension({
        html: '', // optionally
      }));
      ias.on('load', function() {
        $('.ias-spinner').show();
      });
      ias.on('noneLeft', function() {
        $('.ias-spinner').hide();
      });
    }
});
