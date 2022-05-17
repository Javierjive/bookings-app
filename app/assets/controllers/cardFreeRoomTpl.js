export const cardFreeRoomTpl = function (params) {
    let element = document.createElement('div');
    let card_info_html_tpl = `
        <div class='card mb-3' style='min-width: 400px;'>
            <div class='row g-0'>
                <div class='col-md-8'>
                    <div class='card-body'>
                        <div class='d-flex justify-content-between'>
                            <h5 class='card-title'>{{name}} </h5>
                            <div><span class='{{availability_class}}'></span> {{availavility}}</div>
                        </div>
                        <p class='card-text'><h6>Room number: <span class='txt-info'>{{number}}</span></h6></p>
                        <p class='card-text'><h6>Room type: <span class='txt-info'>{{type}}</span></h6></p>
                        <p class='card-text'><h6>Price per night: <span class='txt-info'>{{price}}</span></h6></p>
                        <p class='card-text'><h6>Details:</h6> <span class='txt-info'>{{details}}</span>
                        </p>
                        <p class='card-text'><h6>Observations:</h6> <span class='txt-info'>{{observations}}</span>
                        </p>
                    </div>
                </div>
                <div class='col-md-4 card-right'>
                    <div class="d-block">
                    <div class='justify-content-center'>
                        <button class='std-button reserve-button' value='{{room_id}}'>Reserve</button>
                    </div>
                    <div class='pt-3 d-none justify-content-center check-selected-room' id='check-room-{{room_id}}'>
                        <i class='fa-solid fa-circle-check check-selected-room-booking'></i>
                    </div>
                </div>
                </div>
            </div>
        </div>
    `;

    let card_info_html = card_info_html_tpl.replace('{{name}}', params.name);
    card_info_html = card_info_html.replace('{{details}}', params.details);
    card_info_html = card_info_html.replace('{{observations}}', params.observations);
    card_info_html = card_info_html.replace('{{number}}', params.number);
    card_info_html = card_info_html.replaceAll('{{room_id}}', params.room_id);
    card_info_html = card_info_html.replace('{{price}}', params.price + ' ' + params.currency);
    card_info_html = card_info_html.replace('{{type}}', params.type);
    if (params.availability == 1) {
        card_info_html = card_info_html.replace('{{availavility}}', 'Available');
        card_info_html = card_info_html.replace('{{availability_class}}', 'available-status');
    } else {
        card_info_html = card_info_html.replace('{{availavility}}', 'Unavailable');
        card_info_html = card_info_html.replace('{{availability_class}}', 'unavailable-status');
    }

    element.innerHTML = card_info_html;
    return element;
}