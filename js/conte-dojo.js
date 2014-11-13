require(["dojo/request/xhr", "dojo/dom", "dojo/dom-construct", "dojo/json", "dojo/on", "dojo/domReady!"],
function(xhr, dom, domConst, JSON, on){
  on(dom.byId("subjects"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-subjects.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "4",
        fetch: "subjects"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

  on(dom.byId("dtypes"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-query-fields.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "4",
        fetch: "dtypes"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

  on(dom.byId("regions"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-anatomical-regions.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "4",
        fetch: "anatomical-regions"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

  on(dom.byId("mhr"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-mhr-stats.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "4"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

  on(dom.byId("rat_dti"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-rat-dti-stats.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "1"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

  on(dom.byId("rat_struct"), "click", function(){
    clearData();
    var root = location.protocol + '//' + location.host;
    var script = root + '/fetch-rat-struct-stats.php';

    dom.byId('update').innerHTML = "Fetching data...";
    xhr(script,{
      query: {
        project: "1"
      },
      handleAs: "html"
    }).then(function(data){
      dom.byId('update').innerHTML = '<code>'+data+'</code>';
    });
  });

});

function clearData(){
  document.getElementById('data_table').innerHTML = '';
  document.getElementById('update').innerHTML = '';
  document.getElementById('stats').innerHTML = '';
}
