window.addEventListener('DOMContentLoaded', () => {
    loadUsers();
})

async function loadUsers(){
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
      
            // Inject user info and an action button
            userCard.innerHTML = `
                <p><strong>${user.username}</strong></p>
                <div  style="display: flex;" class="admin-buttons">
                    <button class="primary-btn nav-btn">Promote</button>
                    <button class="primary-btn nav-btn">Delete</button>
                </div>
            `;
            userlist.appendChild(userCard);
        });
    } catch (error){
        console.error(error);
    } 
}