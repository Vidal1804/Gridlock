window.addEventListener('DOMContentLoaded', () =>{
    initialLoad();
})

async function initialLoad(){
    const response = await fetch('/api/accidents?start_date=2016-01-01&end_date=2024-01-01&state=&severity=&weather=');
    const accidents = await response.json();
    const list = document.getElementById('accident_list');
    list.innerHTML = ``;
    let index = 1;
    accidents.forEach(accident => {
        const accidentCard = document.createElement('div');
        accidentCard.className = "accident-card";
        accidentCard.innerHTML = `
            <p>${index} - Accident ID: ${accident.id}</p>
        `;
        list.appendChild(accidentCard);
        index = index + 1;
    });

}



const filterForm = document.getElementById('filter-form');

