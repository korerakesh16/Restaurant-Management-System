<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>C12 Restaurant</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Nunito', sans-serif;
      height: 100vh;
      background:
        url('https://www.transparenttextures.com/patterns/food.png'), /* pattern texture */
        url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1470&q=80'); /* main food image */
      background-size: auto, cover;
      background-repeat: repeat, no-repeat;
      background-position: top left, center center;
      background-blend-mode: overlay;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: fadeIn 1.2s ease-in-out;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(15px);
      border-radius: 25px;
      padding: 60px 40px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
      text-align: center;
      max-width: 520px;
      width: 90%;
      color: #fff;
      animation: slideUp 1.3s ease-out;
    }

    .glass-card h1 {
      font-family: 'Pacifico', cursive;
      font-size: 3.2rem;
      color:rgb(20, 20, 18);
      margin-bottom: 30px;
      animation: neonGlow 2s infinite alternate;
    }

    .btn-custom {
      display: block;
      margin: 15px auto;
      width: 85%;
      padding: 14px 0;
      border: none;
      border-radius: 30px;
      font-weight: 600;
      letter-spacing: 1px;
      font-size: 1.1rem;
      color: #fff;
      transition: all 0.3s ease-in-out;
    }

    .btn-admin {
      background:rgb(246, 4, 8);
    }

    .btn-cashier {
      background:rgb(48, 2, 255);
    }

    .btn-customer {
      background:rgb(65, 213, 46);
    }

    .btn-custom:hover {
      transform: scale(1.08);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes neonGlow {
      from {
        text-shadow: 0 0 8px #ffdd57, 0 0 16px #ff6b81, 0 0 24px #ff4757;
      }
      to {
        text-shadow: 0 0 14px #ffeaa7, 0 0 28px #fab1a0, 0 0 42px #ff6b81;
      }
    }
  </style>
</head>

<body>
  <div class="glass-card">
    <h1>C12 Restaurant</h1>
    <a href="Restro/admin/" class="btn btn-custom btn-admin">Admin Log In</a>
    <a href="Restro/cashier/" class="btn btn-custom btn-cashier">Cashier Log In</a>
    <a href="Restro/customer" class="btn btn-custom btn-customer">Customer Log In</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
