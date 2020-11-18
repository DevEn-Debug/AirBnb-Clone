$(document).ready(init)
function init() {
    addSearchButtonListener()
    document.cookie = `nofbed=${""}`;
    document.cookie = `nofroom=${""}`;
}
function addSearchButtonListener(){
    $('#search-button').click(sendRequestSearch);
}
function sendRequestSearch() {
  var nofbed = $('#nofbed').val();
  var nofroom = $('#nofroom').val();
  document.cookie = `nofbed=${nofbed}`;
  document.cookie = `nofroom=${nofroom}`;
   var services = [];
    $("input[name='service[]']:checked").each(function (){
        services.push($(this).val());
    });
    service = services.join();
    $.ajax({
        url: '/api/search',
        data: { 'service' : service},
        method: 'GET',
        success: function(data) {
            if(data.length == 0){
              $('#message').show()
              var target = $('.blocco-flat');
              target.hide();
            } else {
              $('#message').hide();
                var target = $('.blocco-flat');
                target.hide();
                $.each(data, function(index, flat){
                  var id = flat.id
                  var target = $('.blocco-flat[data-id="' + id + '"]')
                  target.show();
                });
                  }
            },
            error: function(err) {
                console.log('err', err);
            }
          });
        }
