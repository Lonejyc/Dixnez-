let sliderSections = document.querySelectorAll('.img-slider')

if (sliderSections.length) {
    sliderSections.forEach(slider => {
        let dn_objets = slider.querySelectorAll('img')
        let content = slider.querySelector('.slider--content')
        let pos = content.getAttribute('position')
        let length = dn_objets.length
        let prevBtn = slider.querySelector('.prev-btn')
        let nextBtn = slider.querySelector('.next-btn')
        let dots = slider.querySelectorAll('.dots .dot')

        let autoplayTimeout = null;
        let direction = 1;

        nextBtn.addEventListener('click', () => {
            if (pos < length) {
                let res = content.style.left.replace('%', '') - 100
                content.setAttribute('style', `left:${res}%`)
                pos++
                setDots(dots, pos)
                content.setAttribute('position', pos)

                autoplay();
            }
        })
        prevBtn.addEventListener('click', () => {
            if (pos > 1) {
                let res = parseInt(content.style.left.replace('%', '')) + 100
                content.setAttribute('style', `left:${res}%`)
                pos--
                setDots(dots, pos)
                content.setAttribute('position', pos)

                autoplay();
            }
        })
        dots.forEach( dot => {
            dot.addEventListener('click', () => {
                dot.classList.remove('current')
                let p = dot.getAttribute('pos')
                let res = parseInt(p) * 100
                content.setAttribute('style', `left:-${res}%`)
                p++
                setDots(dots, p)
                content.setAttribute('position', p)
            })
        })


        const autoplay = () => {
            if (autoplayTimeout !== null) {
                clearTimeout(autoplayTimeout);
            }

            autoplayTimeout = setTimeout(() => {

                /* calcul de la direction en fonction de la valeur de pos (position de la slide affichée) */
                if (pos > (length -1) && (direction === 1)) {
                    direction = -1;
                }
    
                if (pos === 1 && (direction === -1)) {
                    direction = 1;
                }
    
                /* control du slider en fonction de la direction 1 = next, -1 = previous */
                if (direction === 1) {
                    nextBtn.click();
                } 
    
                if (direction === -1) {
                    prevBtn.click();
                } 

                autoplay();
    
            }, 1000 * 5);
        }

        
        autoplay();
    })
}

function setDots(dots, pos) {
    console.log(pos)
    dots.forEach(dot => {
        dot.classList.remove('current')
    })
    dots[pos - 1].classList.add('current')
}