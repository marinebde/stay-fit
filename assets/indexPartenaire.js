window.onload = () => {
    // Filtrage de la barre de recherche
    const FilterSearch = document.querySelector("#form_recherche");

    //On récupère l'input
     const Input = document.querySelector("#form_recherche input");

        Input.addEventListener("keyup", () => {

            //On fabrique la "queryString à chaque caracère tapé"
            const ParamsSearch = new URLSearchParams();
            ParamsSearch.append('recherche', Input.value);

            //On récupère l'url active
                const UrlSearch = new URL(window.location.href);

            if(ParamsSearch.toString()){
    
                //On lance la requête ajax
                fetch(UrlSearch.pathname + "?" + ParamsSearch.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => response.json()
                ).then(data => {
                    history.pushState({}, null, UrlSearch.pathname + "?" + ParamsSearch.toString());
                    const content = document.querySelector('#formCheck');
                    content.innerHTML = data.content;
                }).catch(e => alert(e));
            } else {
                //On lance la requête ajax
                fetch(UrlSearch.pathname + "?" + ParamsSearch.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then( response => response.json()
            ).then(data => {
                history.pushState({}, null, UrlSearch.pathname + "?" + ParamsSearch.toString());
                const content = document.querySelector('#formCheck');
                content.innerHTML = data.content;

            }).catch(e => alert(e));
            }
   });

   // Filtrage des partenaires Actifs/Inactifs
    const FiltersForm = document.querySelector("#filters");

    //On boucle sur les input
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            
            //On récupère les données du formulaire à chaque click
            const Form = new FormData(FiltersForm);

            //On fabrique la "queryString"
            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            //On récupère l'url active
                const Url = new URL(window.location.href);

            if(Params.toString()){
    
                //On lance la requête ajax
                fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => response.json()
                ).then(data => {
                    history.pushState({}, null, Url.pathname + "?" + Params.toString());
                    const content = document.querySelector('#formCheck');
                    content.innerHTML = data.content;
                }).catch(e => alert(e));
            } else {
                //On lance la requête ajax
                fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then( response => response.json()
            ).then(data => {
                history.pushState({}, null, Url.pathname + "?" + Params.toString());
                const content = document.querySelector('#formCheck');
                content.innerHTML = data.content;

            }).catch(e => alert(e));
            }
        });
    });
}; 

// Activation ou désactivation dynamique d'un partenaire

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