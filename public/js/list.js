let currentData = [];

window.addEventListener('DOMContentLoaded', () =>{
    if (window.location.search) {
        const queryString = window.location.search.substring(1);
        customLoad(queryString);
        populateFormFromQuery(queryString);
        history.replaceState(null, '', window.location.pathname);
    }
    else initialLoad();
})

async function initialLoad(){
    const response = await fetch('/api/accidents?start_date=2016-01-01&end_date=2024-01-01&state=&severity=&weather=');
    const accidents = await response.json();
    const list = document.getElementById('accident_list');
    list.innerHTML = ``;
    accidents.forEach(accident => {
        const accidentCard = document.createElement('div');
        accidentCard.className = "accident-card";
        accidentCard.style.display = 'flex';
        accidentCard.style.backgroundColor = '#111111';
        accidentCard.style.border = 'solid 2px #2e2e2e';
        accidentCard.style.borderRadius = '15px';
        accidentCard.style.padding = '10px';
        accidentCard.style.alignItems = 'center';
        accidentCard.style.justifyContent = 'space-between';
        accidentCard.innerHTML = `
           <div style="display: flex; flex-direction: column;">
           <h2 style="margin: 0;">[${accident.id}] ${accident.city}, ${accident.state}</h2>
           <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Accident Time: ${accident.start_time}</p>
           <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Weather Condition: ${accident.weather_condition}</p>
           <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Accident Time: ${accident.severity}</p>
           </div>
           <a href="https://www.openstreetmap.org/search?lat=${accident.start_lat}&lon=${accident.start_lng}&zoom=10" target="_blank" rel="noopener noreferrer"><button class="primary-btn nav-btn" style="margin-right: 20px;">Open in Maps</button></a>
        `;

        list.appendChild(accidentCard);
    });

}

const filterForm = document.getElementById('filter-form');
let globalQueryString = "";

filterForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(filterForm);
    const queryString = new URLSearchParams(formData).toString();
    globalQueryString = queryString;
    const list = document.getElementById('accident_list');
    list.innerHTML = ``;

    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 
            
            data.forEach(accident => {
                const accidentCard = document.createElement('div');
                accidentCard.className = "accident-card";
                accidentCard.style.display = 'flex';
                accidentCard.style.backgroundColor = '#111111';
                accidentCard.style.border = 'solid 2px #2e2e2e';
                accidentCard.style.borderRadius = '15px';
                accidentCard.style.padding = '10px';
                accidentCard.style.alignItems = 'center';
                accidentCard.style.justifyContent = 'space-between';
                accidentCard.innerHTML = `
                <div style="display: flex; flex-direction: column;">
                <h2 style="margin: 0;">[${accident.id}] ${accident.city}, ${accident.state}</h2>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Accident Time: ${accident.start_time}</p>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Weather Condition: ${accident.weather_condition}</p>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Accident Time: ${accident.severity}</p>
                </div>
                <a href="https://www.openstreetmap.org/search?lat=${accident.start_lat}&lon=${accident.start_lng}&zoom=10" target="_blank" rel="noopener noreferrer"><button class="primary-btn nav-btn" style="margin-right: 20px;">Open in Maps</button></a>
                `;

                list.appendChild(accidentCard);
            });
            currentData = data;
        })
        .catch(error => console.error('Eroare la aducerea accidentelor:', error));
});


document.getElementById('save-query-btn').addEventListener('click', async () => {
    const dataToSend = {
        id: currentUserId,
        queryString: globalQueryString
    };

    try {
        const response = await fetch('/api/users/savequery', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        alert('Query saved successfully!');
        
    } catch (error) {
        console.error('Failed to save query:', error);
        alert('Could not save your query. Please try again.');
    }
});

//csv export
document.getElementById('export-csv-btn').addEventListener('click', () => {
    if (!currentData.length) return alert("No data available to export.");

    const headers = ['id', 'severity', 'start_lat', 'start_lng', 'city', 'state', 'weather_condition', 'start_time'];
    
    const csvRows = [
        headers.join(','), 
        ...currentData.map(row => headers.map(fieldName => {
            const value = String(row[fieldName] || '').replace(/[\r\n]+/g, ' ').replace(/"/g, '""');
            return `"${value}"`;
        }).join(','))
    ];

    createDownload(csvRows.join('\n'), 'accidents.csv', 'text/csv');
});

//helper download function
function createDownload(content, filename, contentType) {
    const fileData = new Blob([content], { type: contentType });
    const url = URL.createObjectURL(fileData);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}

//populate form when loading
function populateFormFromQuery(queryString) {
    const params = new URLSearchParams(queryString);
    const filterForm = document.getElementById('filter-form');

    params.forEach((value, key) => {
        const input = filterForm.elements[key];

        if (input) {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = (input.value === value);
            } else {
                input.value = value;
            }
        }
    });
}

//custom load
async function customLoad(queryString){
    const list = document.getElementById('accident_list');
    list.innerHTML = ``;

    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 
            
            data.forEach(accident => {
                const accidentCard = document.createElement('div');
                accidentCard.className = "accident-card";
                accidentCard.style.display = 'flex';
                accidentCard.style.backgroundColor = '#111111';
                accidentCard.style.border = 'solid 2px #2e2e2e';
                accidentCard.style.borderRadius = '15px';
                accidentCard.style.padding = '10px';
                accidentCard.style.alignItems = 'center';
                accidentCard.style.justifyContent = 'space-between';
                accidentCard.innerHTML = `
                <div style="display: flex; flex-direction: column; margin-right: 10px;">
                <h2 style="margin: 0;">[${accident.id}] ${accident.city}, ${accident.state}</h2>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Accident Time: ${accident.start_time}</p>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Weather Condition: ${accident.weather_condition}</p>
                <p style="margin-bottom: 0; font-size: 16px; margin-top: 5px; margin-left: 20px;">Severity: ${accident.severity}</p>
                </div>
                <a style="margin-left: 10px;" href="https://www.openstreetmap.org/search?lat=${accident.start_lat}&lon=${accident.start_lng}&zoom=10" target="_blank" rel="noopener noreferrer"><button class="primary-btn nav-btn" style="margin-right: 20px;">Open in Maps</button></a>
                `;

                list.appendChild(accidentCard);
            });
            currentData = data;
        })
        .catch(error => console.error('Eroare la aducerea accidentelor:', error));
}
