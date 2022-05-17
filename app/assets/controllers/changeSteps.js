let bookingNextStep = function(current_step_element, next_step_element) {
    let animate_current_step = current_step_element.animate([
        { transform: 'translateX(0px)', opacity: 1 },
        { transform: 'translateX(-500px)', opacity: 0},

    ], {
        duration: 500,
        easing: 'linear',
        delay: 10,
        iterations: 1
    });
    animate_current_step.addEventListener('finish', event => {
        current_step_element.classList.add('d-none');
        next_step_element.classList.add('opacity-0');
        next_step_element.classList.remove('d-none');

        let animate_next_step = next_step_element.animate([
            { transform: 'translateX(500px)', opacity: 0 },
            { transform: 'translateX(0px)', opacity: 1},

        ], {
            duration: 500,
            easing: 'linear',
            delay: 10,
            iterations: 1
        });

        animate_next_step.addEventListener('finish', event => {
            next_step_element.classList.remove('opacity-0');
        });

    });
}

let bookingBackStep = function(current_step_element, next_step_element) {
    let animate_current_step = current_step_element.animate([
        { transform: 'translateX(0px)', opacity: 1 },
        { transform: 'translateX(500px)', opacity: 0},

    ], {
        duration: 500,
        easing: 'linear',
        delay: 10,
        iterations: 1
    });
    animate_current_step.addEventListener('finish', event => {
        current_step_element.classList.add('d-none');
        next_step_element.classList.add('opacity-0');
        next_step_element.classList.remove('d-none');

        let animate_next_step = next_step_element.animate([
            { transform: 'translateX(-500px)', opacity: 0 },
            { transform: 'translateX(0px)', opacity: 1},

        ], {
            duration: 500,
            easing: 'linear',
            delay: 10,
            iterations: 1
        });

        animate_next_step.addEventListener('finish', event => {
            next_step_element.classList.remove('opacity-0');
        });
    });
}

let bookingChangeStep = function(current_step, next_step){
    let translate = parseInt(next_step) > parseInt(current_step) ? 'right' : 'left';
    current_step = 'step-' + current_step;
    next_step = 'step-' + next_step;

    let current_step_element = document.getElementById(current_step);
    let next_step_element = document.getElementById(next_step);

    if (translate == 'right') {
        bookingNextStep(current_step_element, next_step_element);
    } else {
        bookingBackStep(current_step_element, next_step_element);
    }
}

export {bookingNextStep, bookingBackStep, bookingChangeStep}