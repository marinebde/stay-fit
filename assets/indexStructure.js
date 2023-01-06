window.onload = () => {
    // Filtrage de la barre de recherche
    const FilterSearch = document.querySelector("#form_recherche");

    //On récupère l'input
    const Input = document.querySelector("#form_recherche input");

        Input.addEventListener("keyup", () => {

            //On fabrique la "queryString à chaque caractère tapé"
            const ParamsSearch = new URLSearchParams();
            ParamsSearch.append('recherche', Input.value);

            //On récupère l'url active
            const URLSearch = new URL(window.location.href);

             if(ParamsSearch.toString()){
            
            //On lance la requête ajax
            fetch(URLSearch.pathname + "?" + ParamsSearch.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => response.json()
                ).then(data => {
                    history.pushState({}, null, URLSearch.pathname + "?" + ParamsSearch.toString());
                    const content = document.querySelector('#formCheck');
                    
                    content.innerHTML = data.content;
                }).catch(e => alert(e));
             } else {
                //On lance la requête ajax
                fetch(URLSearch.pathname + "?" + ParamsSearch.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then( response => response.json()
            ).then(data => {
                console.log(data);
                history.pushState({}, null, URLSearch.pathname + "?" + ParamsSearch.toString());
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
                    console.log(data);
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

// Activation ou désactivation dynamique d'une structure

//On boucle sur les input
// document.querySelectorAll(".form-switch-statut-partenaire input").forEach(input => {
//     input.addEventListener("change", () => {
// 
//         //On récupère l'url de la route edit-statut
//         const Url = input.dataset.path;
// 
//         const Modal = document.getElementById('exampleModal')
//         const Footer = Modal.getElementsByClassName('modal-footer')[0].children[1]
// 
//         Footer.addEventListener("click", () => {
//             
//             //On lance la requête ajax
//             fetch(Url)
//             .then((response) => {
//                 console.log(response);
//                 return response.json()
//             }).then(data => {
//                 console.log(data)
//                 const input = document.querySelector('.form-check-input')
//                 input.innerHTML = data.input;
//                 
//                 $("[data-dismiss=modal]").trigger({ type: "click" });
//                 
//             }).catch((err) => console.log('Erreur : '+ err));     
//          })
//     });
// });

// Activation ou désactivation dynamique d'une Structure

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
            success: function(response){
               // $('#magasinDatas').html(data);
               console.log(response);
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
