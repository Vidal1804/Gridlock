window.addEventListener('DOMContentLoaded', () =>{
    initialLoad();
})

async function initialLoad(){
    const response = await fetch('/api/queries');
    const queries = await response.json();
    const list = document.getElementById('querylist');
    list.innerHTML = ``;
    
    queries.forEach(query => {
        const queryCard = document.createElement('div');
        queryCard.className = "query-card";

        const params = new URLSearchParams(query.query_string);
        
        const startDateStr = params.get('start_date') || 'Any';
        const startDateFmt = new Date(startDateStr + 'T00:00:00');
        const startDate = startDateFmt.toLocaleDateString('en-GB', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        const endDateStr = params.get('end_date') || 'Any';
        const endDateFmt = new Date(endDateStr + 'T00:00:00');
        const endDate = endDateFmt.toLocaleDateString('en-GB', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        })
        const state = params.get('state') || 'Any';
        const severity = params.get('severity') || 'Any';
        const weather = params.get('weather') || 'Any';

        queryCard.innerHTML = `
           <div style="display: flex; flex-direction: column; gap: 5px; font-family: sans-serif;">
               <div><strong>Start date:</strong> ${startDate}</div>
               <div><strong>End date:</strong> ${endDate}</div>
               <div><strong>State:</strong> ${getStateName(state)}</div>
               <div><strong>Severity:</strong> ${severity}</div>
               <div><strong>Weather:</strong> ${weather}</div>
           </div>
           <div style="display: flex; flex-direction: column; gap: 10px; margin-left: 20px;">
           <button class="primary-btn nav-btn map-btn">Map</button>
           <button class="primary-btn nav-btn list-btn">List</button>
           <button class="primary-btn nav-btn delete-btn">Delete</button>
           </div>
        `;

        const mapBtn = queryCard.querySelector('.map-btn');
        mapBtn.addEventListener('click', async () =>{
            window.location.href = `/map?${query.query_string}`;
        });

        const listBtn = queryCard.querySelector('.list-btn');
        listBtn.addEventListener('click', async () =>{
            window.location.href = `list?${query.query_string}`;
        });

        const deleteBtn = queryCard.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', async () =>{
            if(confirm('Are you sure you want to delete this query?')) {
                await handleUserAction(`/api/users/deletequery`, query.id, queryCard, initialLoad);
            }
        });

        list.appendChild(queryCard);
    });
}

async function handleUserAction(endpoint, queryId, card, callback){
    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: queryId })
        });
        const result = await response.json();
        if (response.ok && result.success) {
            if(typeof callback === 'function'){
                await callback();
            }
        } else {
            alert(result.message || "Something went wrong.");
        }
    } catch (error) {
        console.error("API Error:", error);
    }
}

const usStates = {
    AL: "Alabama", AK: "Alaska", AZ: "Arizona", AR: "Arkansas", CA: "California",
    CO: "Colorado", CT: "Connecticut", DE: "Delaware", FL: "Florida", GA: "Georgia",
    HI: "Hawaii", ID: "Idaho", IL: "Illinois", IN: "Indiana", IA: "Iowa",
    KS: "Kansas", KY: "Kentucky", LA: "Louisiana", ME: "Maine", MD: "Maryland",
    MA: "Massachusetts", MI: "Michigan", MN: "Minnesota", MS: "Mississippi", MO: "Missouri",
    MT: "Montana", NE: "Nebraska", NV: "Nevada", NH: "New Hampshire", NJ: "New Jersey",
    NM: "New Mexico", NY: "New York", NC: "North Carolina", ND: "North Dakota", OH: "Ohio",
    OK: "Oklahoma", OR: "Oregon", PA: "Pennsylvania", RI: "Rhode Island", SC: "South Carolina",
    SD: "South Dakota", TN: "Tennessee", TX: "Texas", UT: "Utah", VT: "Vermont",
    VA: "Virginia", WA: "Washington", WV: "West Virginia", WI: "Wisconsin", WY: "Wyoming"
};

function getStateName(code) {
    if (!code) return 'Any';
    
    const cleanCode = code.toUpperCase().trim();
    return usStates[cleanCode] || code;
}