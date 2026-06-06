window.addEventListener('DOMContentLoaded', () => {
    loadUsers();
})

async function loadUsers(){
    console.log("Loading users...");
    try {
        const userlist = document.getElementById("userlist");
        const response = await fetch(`/api/users`);
        const users = await response.json();
        userlist.innerHTML = ``;
        users.forEach(user =>{
            const userCard = document.createElement('div');
            userCard.className = 'user-item';
            userCard.style.display = 'flex';
            userCard.style.width = '100%';
            userCard.style.justifyContent = 'space-between';
            userCard.style.border = 'solid 2px #2d2d2d';
            userCard.style.borderRadius = '10px';
            userCard.style.padding = '10px';
            let userrole = "Promote";
            if(user.role === 'admin') userrole = "Demote";
            // Inject user info and an action button
            userCard.innerHTML = `
                <p><strong>${user.username}</strong></p>
                <div  style="display: flex;" class="admin-buttons">
                    <button class="primary-btn nav-btn promote-btn">${userrole}</button>
                    <button class="primary-btn nav-btn delete-btn">Delete</button>
                </div>
            `;

            const promoteBtn = userCard.querySelector('.promote-btn');
            promoteBtn.addEventListener('click', async () => {
                if(confirm('Are you sure you want to change ' + user.username + 's role?')) {
                    await handleUserAction(`/api/users/changerole`, user.id, userCard, loadUsers);
                }
            });

            const deleteBtn = userCard.querySelector('.delete-btn');
            deleteBtn.addEventListener('click', async () => {
                if(confirm('Are you sure you want to delete ' + user.username)) {
                    await handleUserAction(`/api/users/changerole`, user.id, userCard, loadUsers);
                }
            });

            userlist.appendChild(userCard);
        });
    } catch (error){
        console.error(error);
    } 
}

async function handleUserAction(endpoint, userId, card, callback){
    console.log("Action " + endpoint + " handled for " + userId);
    if(typeof callback === 'function'){
        await callback();
    }
}