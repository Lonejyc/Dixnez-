document.querySelectorAll('.object').forEach((objectEl) => {
    const btnElements = objectEl.querySelectorAll('.display_btn')

    const empruntEl = objectEl.querySelector(".emprunt")
    const renduEl = objectEl.querySelector(".rendu")
    const userFormEl = objectEl.querySelector('.user_form');
    const formulaireEl = objectEl.querySelector('.formulaire');
    const formEl = objectEl.querySelector('form');
    
    btnElements.forEach((btnEl) => {
        btnEl.addEventListener('click', () => {
            
            if(btnEl.classList.contains('emprunter_btn')) {
                empruntEl.style.display = "flex";
                formulaireEl.style.display = "flex";
            }

            if(btnEl.classList.contains('emprunterClose')) {
                empruntEl.style.display = "none";
                userFormEl.style.display = 'none';
                formulaireEl.style.display = "none";
                formEl.reset();
            }


            if(btnEl.classList.contains('rendre_btn')) {
                renduEl.style.display = "flex";
                formulaireEl.style.display = "flex";
            }

           
            if(btnEl.classList.contains('rendreClose')) {
                renduEl.style.display = "none";
                userFormEl.style.display = 'none';
                formulaireEl.style.display = "none";
                formEl.reset();
            }
        })

    })


    objectEl.querySelectorAll('input[name="product_id"]').forEach((inputEl) => {
        inputEl.addEventListener('change', () => {
            console.log('input', inputEl.value)

            userFormEl.style.display = 'flex';
        })
    })
    
})
