(function(){
  var search = document.getElementById('search');
  set_location(cond_location, search);
  search.addEventListener('change', function(){
    condition = this.options[ this.selectedIndex ].value;
    location.href = "/users?location="+condition;
  });
  function set_location(cond_location, objsearch) {
    if (cond_location.length <= 0) {
      return;
    }
    for(var i = 0; i < objsearch.options.length; i++){
      if(objsearch.options[i].value === cond_location) {
        objsearch.options[i].selected = true;
        break;
      }
    }
  }
})();
