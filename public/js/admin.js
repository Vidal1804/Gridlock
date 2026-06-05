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
      
            // Inject user info and an action button
            userCard.innerHTML = `
                <p><strong>Username:</strong> ${user.username}</p>
                <button>delete account</button>
            `;
            userlist.appendChild(userCard);
        });
    } catch (error){
        console.error(error);
    } 
}