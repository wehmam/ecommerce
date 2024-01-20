let url = window.location.pathname;
let id = url.substring(url.lastIndexOf('/') + 1);

function getSnapToken(callback) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open("POST", `${window.location.origin + "/do-token"}` );
    xmlHttp.setRequestHeader("X-CSRF-Token"  ,$('meta[name="_token"]').attr('content'));
    xmlHttp.setRequestHeader('Content-type', 'application/json')
    xmlHttp.send(JSON.stringify({
        "invoice"       : id
    }));
}



$('.btn-pay').on('click', function(){
    $(this).prop('disabled', true);
    getSnapToken(function(response){
        var result = JSON.parse(response)
        $(this).prop('disabled', false);
        snap.pay(result.data, {
            onSuccess: function(result){
                location.reload()
            },
            onPending: function(result){
                $.post('/api/payment-save-info/'+ id, {data:result}, function(status){
                    location.reload()
                })
            },
            onError: function(result){
                console.log(result)
            },
            onClose: function(){
                console.log(result)
            },
            selectedPaymentType:"EVENTS",
            uiMode: 'auto'
        })
    })
})
