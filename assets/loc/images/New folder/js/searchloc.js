$(document).ready(function(){
  var globalLocations = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    limit: 4,
    remote: site_url+'api/autocompleteLocationsWeb/%QUERY'
  });
 
  var nearLocations = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    limit: 4,
    remote: site_url+'api/autocompleteLocationsNearWeb/%QUERY'
  });

globalLocations.initialize();
nearLocations.initialize();

$('#remote #searchlocations').typeahead({
  hint: false,
  highlight: true
},
 {
  name: 'nearLocations',
  displayKey: 'title',
  source: nearLocations.ttAdapter(),
  templates: {
    header: '<h4 class="league-name">Near to your location</h3>'
  }
},
{
  name: 'globalLocations',
  displayKey: 'title',
  source: globalLocations.ttAdapter(),
  templates: {
    header: '<h4 class="league-name">Other</h3>'
  }
}).on('typeahead:selected', onSelectLocSugg);

function onSelectLocSugg($e, datum){
  window.location = site_url+datum.title;
}

});