document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("burgerCanvas");
    const context = canvas.getContext("2d");
    
    // Setup for 80 frame image sequence
    const frameCount = 80;
    const currentFrame = index => {
        return `img/Ultra_realistic_food_commercial_video_two_gourmet__9dedab079d_${index.toString().padStart(3, '0')}.jpg`;
    };

    const images = [];
    let framesLoaded = 0;
    
    // Responsive canvas dimensions handler
    let baseWidth = 0;
    let baseHeight = 0;

    // Preload image loop
    for (let i = 0; i < frameCount; i++) {
        const img = new Image();
        img.src = currentFrame(i);
        images.push(img);
        
        img.onload = () => {
            framesLoaded++;
            
            // Initialize canvas size with the first loaded image
            if (framesLoaded === 1) {
                baseWidth = img.width;
                baseHeight = img.height;
                canvas.width = baseWidth;
                canvas.height = baseHeight;
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
            }
            
            // When all frames are loaded, start the animation
            if (framesLoaded === frameCount) {
                startSequence();
            }
        };
        
        // Error handling for missing images
        img.onerror = () => {
            console.error(`Failed to load frame ${i}`);
            framesLoaded++; // increment to avoid stalling the animation
            if (framesLoaded === frameCount) {
                startSequence();
            }
        }
    }

    let currentFrameIndex = 0;
    let lastTimestamp = 0;
    const FPS = 30; 
    const frameInterval = 1000 / FPS;

    function startSequence() {
        requestAnimationFrame(updateFrame);
    }

    function updateFrame(timestamp) {
        if (!lastTimestamp) lastTimestamp = timestamp;
        
        const deltaTime = timestamp - lastTimestamp;
        
        if (deltaTime >= frameInterval) {
            // Draw current frame if it exists and is loaded
            if (images[currentFrameIndex].complete && images[currentFrameIndex].naturalWidth > 0) {
                // We keep drawing even if clearing might not be necessary when images cover whole canvas, 
                // but good practice if images have transparency (though JPEGs don't, we still can clear).
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(images[currentFrameIndex], 0, 0, canvas.width, canvas.height);
            }
            
            // Advance frame, loop back to start
            currentFrameIndex = (currentFrameIndex + 1) % frameCount;
            
            // Adjust last timestamp by frameInterval rather than setting exactly to timestamp 
            // for smoother timing
            lastTimestamp = timestamp - (deltaTime % frameInterval);
        }
        
        requestAnimationFrame(updateFrame);
    }

    // Interactive elements for Navbar
    const navLinks = document.querySelectorAll(".nav-links a");
    navLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            const targetId = this.getAttribute("href");
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                // Offset for fixed header
                const headerOffset = 80;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
  
                window.scrollTo({
                     top: offsetPosition,
                     behavior: "smooth"
                });
            }
        });
    });

    // --- API Integration ---

    // Fetch and display featured burgers
    fetch('api/burgers.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(burgers => {
            const container = document.getElementById('featured-burgers-container');
            if (container) {
                container.innerHTML = ''; // Clear loading state or empty comment
                burgers.forEach(burger => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    card.innerHTML = `
                        <div class="card-image">
                            <img src="${burger.image}" alt="${burger.title}" class="card-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: inherit;">
                        </div>
                        <h3>${burger.title}</h3>
                        <p>${burger.description}</p>
                        <p style="font-weight: bold; margin-top: 10px; color: var(--primary-color);">R$ ${burger.price.toFixed(2).replace('.', ',')}</p>
                    `;
                    container.appendChild(card);
                });
            }
        })
        .catch(error => console.error('Error fetching burgers:', error));

    // Fetch and display reviews
    fetch('api/reviews.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(reviews => {
            const container = document.getElementById('reviews-container');
            if (container) {
                container.innerHTML = '';
                reviews.forEach(review => {
                    // Generate stars
                    let stars = '';
                    for(let i=0; i<review.rating; i++) stars += '★';

                    const reviewEl = document.createElement('div');
                    reviewEl.className = 'review';
                    reviewEl.innerHTML = `
                        <div style="color: gold; margin-bottom: 10px; font-size: 1.2rem;">${stars}</div>
                        <p class="review-text">"${review.text}"</p>
                        <p class="reviewer">- ${review.author}</p>
                    `;
                    container.appendChild(reviewEl);
                });
            }
        })
        .catch(error => console.error('Error fetching reviews:', error));

    // --- Authentication Integration ---
    const authOverlay = document.getElementById('authOverlay');
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const recoverModal = document.getElementById('recoverModal');
    const welcomeOverlay = document.getElementById('welcomeOverlay');
    const welcomeUserName = document.getElementById('welcomeUserName');
    const closeWelcome = document.getElementById('closeWelcome');
    const navAuthBtn = document.getElementById('nav-auth-btn');

    const recoverForm = document.getElementById('recoverForm');
    const resetForm = document.getElementById('resetForm');

    let currentUser = null;

    // Check Auth State on Load
    function checkAuthState() {
        fetch('api/user.php')
            .then(res => res.json())
            .then(data => {
                if (data.success && data.user) {
                    currentUser = data.user;
                    navAuthBtn.innerText = `Sair (${currentUser.name})`;
                    navAuthBtn.href = '#logout';
                } else {
                    currentUser = null;
                    navAuthBtn.innerText = 'Entrar';
                    navAuthBtn.href = '#login';
                }
            })
            .catch(() => {
                currentUser = null;
                navAuthBtn.innerText = 'Entrar';
                navAuthBtn.href = '#login';
            });
    }
    
    checkAuthState();

    // Modal Helpers
    function showModal(modal) {
        authOverlay.style.display = 'flex';
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
        recoverModal.style.display = 'none';
        modal.style.display = 'block';
        
        // Reset recovery forms when opening/switching
        if (modal === recoverModal) {
            recoverForm.style.display = 'block';
            resetForm.style.display = 'none';
        }
    }

    function hideModals() {
        authOverlay.style.display = 'none';
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
        recoverModal.style.display = 'none';
    }

    function showWelcome(name, title = "Seja bem-vindo", subtext = "Sua jornada pelo sabor explosivo começa agora.") {
        const titleEl = welcomeOverlay.querySelector('.welcome-msg');
        const subtextEl = welcomeOverlay.querySelector('.welcome-subtext');
        
        titleEl.innerHTML = `${title}, <span id="welcomeUserName">${name}</span>!`;
        subtextEl.innerText = subtext;
        
        welcomeOverlay.classList.add('active');
    }

    closeWelcome.addEventListener('click', () => {
        welcomeOverlay.classList.remove('active');
    });

    // Open Modal from Nav
    navAuthBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentUser) {
            // Logout
            const oldName = currentUser.name;
            fetch('api/logout.php')
                .then(() => {
                    checkAuthState();
                    showWelcome(oldName, "Até breve", "Esperamos ver você novamente em breve!");
                });
        } else {
            showModal(loginModal);
        }
    });

    // Close Modals
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', hideModals);
    });
    authOverlay.addEventListener('click', (e) => {
        if (e.target === authOverlay) hideModals();
    });

    // Toggle between Login and Register
    document.getElementById('showRegister').addEventListener('click', (e) => {
        e.preventDefault();
        showModal(registerModal);
    });
    document.getElementById('showLogin').addEventListener('click', (e) => {
        e.preventDefault();
        showModal(loginModal);
    });

    document.getElementById('showRecover').addEventListener('click', (e) => {
        e.preventDefault();
        showModal(recoverModal);
    });

    document.querySelectorAll('.backToLogin').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showModal(loginModal);
        });
    });

    // Handle Login Submit
    document.getElementById('loginForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;

        fetch('api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        })
        .then(res => {
            if (!res.ok) {
                // Return json if possible, otherwise throw
                return res.json().catch(() => { throw new Error('Servidor retornou erro ' + res.status); });
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Remove alert and show welcome screen
                checkAuthState();
                hideModals();
                showWelcome(data.user.name);
                document.getElementById('loginForm').reset();
            } else {
                alert(data.message || 'Erro ao fazer login.');
            }
        })
        .catch(err => {
            console.error('Login Error:', err);
            alert('Erro ao tentar conectar com o servidor. Verifique o console.');
        });
    });

    // Handle Register Submit
    document.getElementById('registerForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const name = document.getElementById('regName').value;
        const email = document.getElementById('regEmail').value;
        const password = document.getElementById('regPassword').value;

        fetch('api/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                checkAuthState(); // Registers and logs in
                hideModals();
                showWelcome(data.user.name);
                document.getElementById('registerForm').reset();
            } else {
                alert(data.message || 'Erro ao cadastrar.');
            }
        });
    });

    // Handle Password Recovery Request (PIN)
    recoverForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('recoverEmail').value;

        fetch('api/recover.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // In simulation, we show the PIN. In real life, it would be in an email.
                alert(`${data.message}\n\nSEU CÓDIGO (Simulação): ${data.pin}`);
                recoverForm.style.display = 'none';
                resetForm.style.display = 'block';
            } else {
                alert(data.message || 'Erro ao solicitar recuperação.');
            }
        });
    });

    // Handle Password Reset (New Password)
    resetForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('recoverEmail').value;
        const pin = document.getElementById('resetPin').value;
        const new_password = document.getElementById('resetNewPassword').value;

        fetch('api/reset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, pin, new_password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message + ' Agora você pode fazer login.');
                showModal(loginModal);
            } else {
                alert(data.message || 'Erro ao redefinir senha.');
            }
        });
    });

    // Handle Order Buttons (Maintenance)
    const orderButtons = document.querySelectorAll('.order-buttons .cta-button');
    orderButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            showWelcome("Herói", "Sistema em Manutenção", "Estamos aprimorando nossa cozinha espacial. Voltamos em breve com novidades!");
        });
    });

});
