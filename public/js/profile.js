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
        
        const startDate = params.get('start_date') || 'Any';
        const endDate = params.get('end_date') || 'Any';
        const state = params.get('state') || 'Any';
        const severity = params.get('severity') || 'Any';
        const weather = params.get('weather') || 'Any';

        queryCard.innerHTML = `
           <div style="display: flex; flex-direction: column; gap: 5px; font-family: sans-serif;">
               <div><strong>Start Date:</strong> ${startDate}</div>
               <div><strong>End Date:</strong> ${endDate}</div>
               <div><strong>State:</strong> ${state}</div>
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