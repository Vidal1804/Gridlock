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

            if(user.id == currentUserId){
                return;
            }

            const userCard = document.createElement('div');
            userCard.className='users-card';
            let userrole = "Promote";
            if(user.role === 'admin') userrole = "Demote";
            // Inject user info and an action button
            userCard.innerHTML = `
                <div>
                <h2 style="margin-bottom: 5px;">[${user.id}] ${user.username}</h2>
                <hr>
                <p style="margin: 0; font-size: 20px"><strong>Role:</strong> ${user.role}</p>
                <p style="margin: 0; font-size: 20px"><strong>Email:</strong> ${maskEmail(user.email)}</p>
                <hr>
                </div>

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
                    await handleUserAction(`/api/users/deleteuser`, user.id, userCard, loadUsers);
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
    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId })
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

function maskEmail(email) {
    if (!email || !email.includes('@')) {
        return email;
    }

    const [local, domain] = email.split('@');
    const length = local.length;
    let maskedLocal = '';

    if (length <= 2) {
        maskedLocal = '*'.repeat(length);
    } else if (length <= 4) {
        maskedLocal = local[0] + '*'.repeat(length - 1);
    } else {
        maskedLocal = local[0] + '*'.repeat(length - 2) + local[length - 1];
    }

    return `${maskedLocal}@${domain}`;
}