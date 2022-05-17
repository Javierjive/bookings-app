import {requestPromise, addClickEvent, addChangeEvent, getDaysDifference} from "./utilLibrary";
import {cardFreeRoomTpl} from './cardFreeRoomTpl';
import {bookingNextStep, bookingBackStep, bookingChangeStep} from "./changeSteps";

/** GLOBALS SCOPE **/

var date_check_in = '';
var date_check_out = '';
var n_guests = '';
var error_step_1_element = '';
var free_rooms = [];
var selected_room = [];
var guest_name =  '';
var guest_surname = '';
var guest_dni = '';
var guest_int_call_code_1 = '';
var guest_phone_1 = '';
var guest_int_call_code_2 = '';
var guest_phone_2 = '';
var guest_email = '';
var total_price = '';
var modal_info = '';
var modal_info_title = '';
var modal_info_content = '';
var bookings_list_url = '/list';


window.onload = function() {
    init();
}

let init = function() {
    initDatePickers();
    initBookingProcessButtons();
    initInputTotalPrice();
    initModalInfo();
}

/* Inputs type date can only accept dates after current date */
let initDatePickers = function() {
    let datepickers = document.getElementsByClassName('datepicker');
    Array.from(datepickers).forEach((datepicker) => {
        datepicker.min = new Date().toISOString().split("T")[0];
    });
}

let initBookingProcessButtons = function() {
    let button_next_step_1 = document.getElementById('button-next-step-1');
    let button_next_step_2 = document.getElementById('button-next-step-2');
    let button_back_step_2 = document.getElementById('button-back-step-2');
    let button_back_step_3 = document.getElementById('button-back-step-3');
    let button_next_step_3 = document.getElementById('button-next-step-3');
    let button_back_step_4 = document.getElementById('button-back-step-4');
    let save_button = document.getElementById('save-booking');

    addClickEvent(button_next_step_1, searchFreeRoomsAjax);
    addClickEvent(button_next_step_2, buttonNextStep2);
    addClickEvent(button_back_step_2, bookingChangeStep, 2, 1);
    addClickEvent(button_next_step_3, buttonNextStep3);
    addClickEvent(button_back_step_3, bookingChangeStep, 3, 2);
    addClickEvent(button_back_step_4, bookingChangeStep, 4, 3);
    addClickEvent(save_button, doReserv);
}

let buttonNextStep2 = function() {
    let error_step_2_element = document.getElementById('error-step-2');

    if (selected_room == Object.keys(free_rooms).length === 0 || selected_room == 'undefined' || selected_room == '') {
        error_step_2_element.classList.remove('d-none');
        return;
    }

    error_step_2_element.classList.add('d-none');
    total_price = document.getElementById('total-price').value = parseFloat(selected_room.price) * getDaysDifference(date_check_in, date_check_out);
    document.getElementsByClassName('currency-value').value = selected_room.currency.html;

    bookingChangeStep(2, 3);
}



let buttonNextStep3 = function() {
    guest_name = document.getElementById('guest-name').value;
    guest_surname = document.getElementById('guest-surname').value;
    guest_dni = document.getElementById('guest-dni').value;
    guest_phone_1 = document.getElementById('guest-phone-1').value;
    guest_int_call_code_1 = document.getElementById('guest-int-call-code-1').value;
    guest_phone_2 = document.getElementById('guest-phone-2').value;
    guest_int_call_code_2 = document.getElementById('guest-int-call-code-2').value;
    guest_email = document.getElementById('guest-email').value;

    let error_step_3_element = document.getElementById('error-step-3');


    if (guest_name == '' || guest_surname == '' || guest_dni == '' || guest_phone_1 == '' || guest_int_call_code_1 == '' || guest_email == '' || total_price == '') {
        error_step_3_element.classList.remove('d-none');
        return;
    }
    error_step_3_element.classList.add('d-none');

    document.getElementById('resume-booking-date').innerText = date_check_in + ' - ' + date_check_out;
    document.getElementById('resume-booking-room').innerText = selected_room.number + ' - ' + selected_room.name;
    document.getElementById('resume-guest-name').innerHTML = '<h6>Name:</h6> ' + guest_name + ' ' + guest_surname;
    document.getElementById('resume-guest-phone-1').innerHTML = '<h6>Phone:</h6> ' + guest_int_call_code_1 + '-' + guest_phone_1;
    document.getElementById('resume-guest-email').innerHTML = '<h6>email:</h6> ' + guest_email;
    document.getElementById('resume-booking-price').innerHTML = total_price + ' ' + selected_room.currency.html;
    bookingChangeStep(3, 4);
}

let initInputTotalPrice = function() {
    let input_total_price = document.getElementById('total-price');
    addChangeEvent(input_total_price, refreshTotalPrice);
}

let initModalInfo = function () {
    modal_info = new bootstrap.Modal(document.getElementById('modal-info'), {
        keyboard: false
    });
    modal_info_title = document.getElementById('modal-info-title');
    modal_info_content = document.getElementById('modal-info-content');
}



let doReserv = function() {
    let parameters = {
        "date_checkin": date_check_in,
        "date_checkout": date_check_out,
        "n_guests": n_guests,
        "room": selected_room,
        "guest_name": guest_name,
        "guest_surname": guest_surname,
        "guest_dni": guest_dni,
        "guest_int_call_code_1": guest_int_call_code_1,
        "guest_phone_1": guest_phone_1,
        "guest_int_call_code_2": guest_int_call_code_2,
        "guest_phone_2": guest_phone_2,
        "guest_email": guest_email,
        "total_price": total_price
    }

    requestPromise('http://localhost:8000/save_reserv', 'POST', parameters).then((response) => {
        if (response.error == 1) {
            modal_info_title.innerText = 'Oh oh...';
            modal_info_content.innerText = response.message != undefined && response.message != '' ? response.message : 'Error to save booking, please check the form again or contact with Admin people';
            modal_info.show();
        } else {
            window.location.pathname = bookings_list_url;
        }
    });
}

let refreshTotalPrice = function () {
    total_price = input_total_price.value;
}

/* Search free rooms by date checkin, date checkout and number of guests */
let searchFreeRoomsAjax = function() {
    date_check_in = document.getElementById('date-checkin').value;
    date_check_out = document.getElementById('date-checkout').value;
    n_guests = document.getElementById('n-guests').value;
    error_step_1_element = document.getElementById('error-step-1');

    if (date_check_in == '' || date_check_out == '' || n_guests == '') {
        error_step_1_element.firstElementChild.innerHTML = 'Must fill request fields';
        error_step_1_element.classList.remove('d-none');
        return;
    } else if (new Date(date_check_in) > new Date(date_check_out)) {
        error_step_1_element.firstElementChild.innerHTML = 'The check-in date must be before the check-out date';
        error_step_1_element.classList.remove('d-none');
        return;
    } else {
        error_step_1_element.classList.add('d-none');
    }
    let parameters = {
        "date_checkin": date_check_in,
        "date_checkout": date_check_out,
        "n_guests": n_guests
    }

    requestPromise('http://localhost:8000/get_free_rooms', 'POST', parameters).then((data) => {
        if (data.error == 1) {
            modal_info_title.innerText = 'Oh oh...';
            modal_info_content.innerText = data.message != 'undefined' && data.message != '' ? data.message : 'Sorry, checkout date is not valid';
            modal_info.show();
        } else {
            free_rooms = data.data;
            if (free_rooms != 'undefined' && Object.keys(free_rooms).length > 0) {
                let n_rooms_found_txt = Object.keys(free_rooms).length == 1 ? ' room have been found' : ' rooms have been found';
                document.getElementById('n-free-rooms').innerText = Object.keys(free_rooms).length + n_rooms_found_txt;
                let free_room_container_html = document.getElementById('free_rooms');
                free_room_container_html.innerHTML = '';
                for (const free_room_id in free_rooms) {
                    let free_room = free_rooms[free_room_id];
                    let card_info_free_room_html = cardFreeRoomTpl({
                        'room_id': free_room.id,
                        'name': free_room.name,
                        'availability': free_room.availability,
                        'price': free_room.price,
                        'details': free_room.details,
                        'observations': free_room.observations,
                        'number': free_room.number,
                        'currency': free_room.currency.html,
                        'type': free_room.type
                    });
                    free_room_container_html.appendChild(card_info_free_room_html);
                }

                bookingChangeStep(1, 2);

                let buttons_reserve = document.getElementsByClassName('reserve-button');
                Array.from(buttons_reserve).forEach((button_reserve) => {
                    button_reserve.addEventListener('click', (event) => {
                        event.preventDefault();
                        let select_room_icon_element = document.querySelectorAll('div.check-selected-room')
                        Array.from(select_room_icon_element).forEach((element) => {
                            element.classList.add('d-none');
                            element.classList.remove('d-flex');
                        })

                        selected_room = free_rooms[event.currentTarget.value];
                        let current_selected_room_icon_element = document.getElementById('check-room-' + event.currentTarget.value)
                        current_selected_room_icon_element.classList.add('d-flex');
                        current_selected_room_icon_element.classList.remove('d-none');
                    })
                });
            } else {
                modal_info_title.innerText = 'Oh oh...';
                modal_info_content.innerText = 'Sorry, we have not free rooms for ' + n_guests + ' in this dates. You can check our cross selling or you can try a new search';
                modal_info.show();
            }
        }

    })
}