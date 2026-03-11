<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hambúrguer de Sabor Explosivo</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <img src="img/logo.png" alt="Hero Burgers Logo" class="brand-logo">
            <span>HERO BURGERS</span>
        </div>
        <nav class="nav-links">
            <a href="#featured">Destaques</a>
            <a href="#quality">Qualidade</a>
            <a href="#reviews">Avaliações</a>
            <a href="#order" class="nav-cta" id="nav-auth-btn">Entrar</a>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <!-- Canvas as background -->
            <canvas id="burgerCanvas" class="hero-canvas-bg"></canvas>

            <div class="hero-bg-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            
            <div class="hero-content">
                <div class="hero-text">
                    <h2 class="subtitle">Experimente o melhor cheeseburger duplo</h2>
                    <h1 class="title">HAMBÚRGUER DE<br>SABOR <span class="highlight">EXPLOSIVO</span></h1>
                    <p class="description">Feito com ingredientes premium, o dobro de queijo e um toque do nosso molho explosivo exclusivo. Desafiando a gravidade e as expectativas.</p>
                    <a href="#order" class="cta-button">Peça Agora</a>
                </div>
            </div>
        </section>

        <!-- Featured Burgers Section -->
        <section id="featured" class="featured-section">
            <h2 class="section-title">Criações em Destaque</h2>
            <div class="cards-container" id="featured-burgers-container">
                <!-- Burger cards will be loaded here dynamically by the PHP API -->
            </div>
        </section>

        <!-- Ingredients Quality Section -->
        <section id="quality" class="quality-section">
            <div class="quality-content">
                <div class="quality-text">
                    <h2 class="section-title">Qualidade Inabalável</h2>
                    <p>Buscamos apenas os ingredientes mais frescos de fazendas locais. Carne 100% Angus, pães de brioche recém-assados e vegetais frescos e vibrantes.</p>
                    <ul class="features-list">
                        <li><span>✔</span> Carne nunca congelada</li>
                        <li><span>✔</span> Cortado à mão diariamente</li>
                        <li><span>✔</span> Molhos artesanais feitos na casa</li>
                    </ul>
                </div>
                <div class="quality-visual" style="overflow: hidden; border-radius: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    <img src="https://images.unsplash.com/photo-1551782450-a2132b4ba21d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Ingredientes Premium" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </div>
            </div>
        </section>

        <!-- Customer Reviews Section -->
        <section id="reviews" class="reviews-section">
            <h2 class="section-title">O Que Eles Dizem</h2>
            <div class="reviews-container" id="reviews-container">
                <!-- Reviews will be loaded here dynamically by the PHP API -->
            </div>
        </section>

        <!-- Order CTA Section -->
        <section id="order" class="order-section">
            <div class="order-content">
                <h2>Pronto para uma explosão de sabor?</h2>
                <p>Peça online agora e evite filas ou receba direto na sua porta.</p>
                <div class="order-buttons">
                    <button class="cta-button primary">Pedir Delivery</button>
                    <button class="cta-button secondary">Retirar na Loja</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Hero Burgers. Todos os direitos reservados.</p>
    </footer>

    <!-- Modals -->
    <div id="authOverlay" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center;">
        
        <!-- Login Modal -->
        <div id="loginModal" class="modal-content" style="display: none; background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 400px; position: relative;">
            <button class="close-modal" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            <h2 style="margin-bottom: 20px;">Entrar</h2>
            <form id="loginForm">
                <input type="email" id="loginEmail" placeholder="Seu E-mail" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <input type="password" id="loginPassword" placeholder="Sua Senha" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <button type="submit" class="cta-button primary" style="width: 100%; border: none;">Acessar</button>
            </form>
            <p style="text-align: center; margin-top: 10px;"><a href="#" id="showRecover" style="font-size: 0.85rem; color: #666;">Esqueci minha senha</a></p>
            <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">Não tem uma conta? <a href="#" id="showRegister" style="color: var(--primary-color);">Crie uma!</a></p>
        </div>

        <!-- Recovery Modal -->
        <div id="recoverModal" class="modal-content" style="display: none; background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 400px; position: relative;">
            <button class="close-modal" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            <h2 style="margin-bottom: 20px;">Recuperar Senha</h2>
            
            <!-- Step 1: Request PIN -->
            <form id="recoverForm">
                <p style="font-size: 0.9rem; margin-bottom: 15px; color: #555;">Digite seu e-mail e enviaremos um código de recuperação.</p>
                <input type="email" id="recoverEmail" placeholder="Seu E-mail" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <button type="submit" class="cta-button primary" style="width: 100%; border: none;">Enviar Código</button>
            </form>

            <!-- Step 2: Reset Password (hidden initially) -->
            <form id="resetForm" style="display: none;">
                <p style="font-size: 0.9rem; margin-bottom: 15px; color: #555;">Digite o código de 6 dígitos enviado e sua nova senha.</p>
                <input type="text" id="resetPin" placeholder="Código de 6 dígitos" required maxlength="6" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <input type="password" id="resetNewPassword" placeholder="Nova Senha" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <button type="submit" class="cta-button primary" style="width: 100%; border: none;">Redefinir Senha</button>
            </form>
            
            <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;"><a href="#" class="backToLogin" style="color: var(--primary-color);">Voltar ao Login</a></p>
        </div>

        <!-- Register Modal -->
        <div id="registerModal" class="modal-content" style="display: none; background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 400px; position: relative;">
            <button class="close-modal" style="position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            <h2 style="margin-bottom: 20px;">Criar Conta</h2>
            <form id="registerForm">
                <input type="text" id="regName" placeholder="Seu Nome" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <input type="email" id="regEmail" placeholder="Seu E-mail" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <input type="password" id="regPassword" placeholder="Sua Senha" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;">
                <button type="submit" class="cta-button primary" style="width: 100%; border: none;">Cadastrar</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">Já tem uma conta? <a href="#" id="showLogin" style="color: var(--primary-color);">Faça Login!</a></p>
        </div>
    </div>

    <!-- Welcome Screen Overlay -->
    <div id="welcomeOverlay" class="welcome-overlay">
        <div class="welcome-content">
            <div class="welcome-logo">
                <img src="img/logo.png" alt="Logo" class="welcome-brand-logo" style="height: 60px; margin-bottom: 15px;">
                <div>HERO BURGERS</div>
            </div>
            <h2 class="welcome-msg">Seja bem-vindo, <span id="welcomeUserName">Herói</span>!</h2>
            <p class="welcome-subtext">Sua jornada pelo sabor explosivo começa agora.</p>
            <button class="btn-welcome-start" id="closeWelcome">Começar a Pedir</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="script.js"></script>
</body>
</html>
