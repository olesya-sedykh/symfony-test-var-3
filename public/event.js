fetch('/api/events', {
    method: 'GET',
  })
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        show_cards(data['hydra:member']);
    }
  )


function formatDateTime(dateTimeString) {
    const date = new Date(dateTimeString);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    const formattedDate = date.toLocaleDateString('ru-RU', options);

    if (isToday(date)) {
        const timeOptions = { hour: 'numeric', minute: 'numeric' };
        const formattedTime = date.toLocaleTimeString('ru-RU', timeOptions);
        return `Сегодня в ${formattedTime}`;
    } 
    else {
        return formattedDate;
    }
}
  
function isToday(someDate) {
    const today = new Date();
    return someDate.getDate() === today.getDate() &&
            someDate.getMonth() === today.getMonth() &&
            someDate.getFullYear() === today.getFullYear();
}


function show_cards(data) {
    // console.log(data);
    const number_of_cards = data.length;

    var content = document.querySelector('.content');
    for (let i = 0; i < number_of_cards; i++) {
        var event = document.createElement('div');
        event.className = 'event';
        content.append(event);

        var event_header = document.createElement('div');
        event_header.className = 'event_header';
        event.append(event_header);

        var event_category = document.createElement('div');
        event_category.textContent = data[i]['category'];
        event_category.className = 'event_category';
        event_header.append(event_category);

        var event_date = document.createElement('div');
        event_date.textContent = formatDateTime(data[i]['date']);
        event_date.className = 'event_date';
        event_header.append(event_date);

        var event_image = document.createElement('img');
        event_image.src = data[i]['image'];
        event_image.className = 'event_image';
        event.append(event_image);

        var event_name = document.createElement('div');
        event_name.textContent = data[i]['name'];
        event_name.className = 'event_name';
        event.append(event_name);

        var event_content = document.createElement('div');
        event_content.textContent = data[i]['content'];
        event_content.className = 'event_content';
        event.append(event_content);
    }
}