$('#formCheck').on("change","input[type=checkbox]", function(){
 
    const modal = document.getElementById('exampleModal')
    const footer = modal.getElementsByClassName('modal-footer')[0].children[1]
    
    footer.addEventListener('click', (event)=> {
    event.preventDefault();
    const url = $(this).data('path')
            
        if($(this).is(':checked')){

        var val = true;

        $.ajax({
            type:     'POST',
            url:       url,  
            data:  { statut : val },
            success: function(reponse){
               // $('#magasinDatas').html(data);
               console.log(reponse);
            }
        })
        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        location.reload();                 
        } else {

        val = false;

        $.ajax({
            type:     'POST',
            url:       url,  
            data: { statut : val },
            success: function(reponse){
               // $('#magasinDatas').html(data);
               console.log(reponse);
            }
        })
        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        location.reload();      
    }
    })
});

$('#formCheckModule').on("change","input[type=checkbox]", function(){
 
    const modal = document.getElementById('exampleModal')
    const footer = modal.getElementsByClassName('modal-footer')[0].children[1]
    
    footer.addEventListener('click', (event)=> {
    event.preventDefault();
    const url = $(this).data('path')
    const id = $(this).data('id')
            
        if($(this).is(':checked')){

        var val = true;

        $.ajax({
            type:     'POST',
            url:       url,  
            data:  { etat : val, id : id},
            success: function(reponse){
               console.log(reponse);
            }
        })
        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        location.reload();  
        } else {

        val = false;

        $.ajax({
            type:     'POST',
            url:       url,  
            data: { etat : val, id : id},
            success: function(reponse){
               console.log(reponse);
            }
        })
        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        location.reload();
    }
    })
});

