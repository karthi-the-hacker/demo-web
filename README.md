
# WebRecon PHP Demo 🔐

A lightweight PHP demo project showcasing basic **Login**, **Logout**, and a protected **Dashboard** page. Built for practice, demos, or educational use — with simplicity and clarity.

> ⚠️ This is a basic demonstration. Not intended for production without proper security hardening.

---

## 🧩 Project Structure

```

.
├── index.html         # Login form (HTML)
├── login.php          # Handles login logic and session creation
├── logout.php         # Handles session destroy/logout
├── dashboard.php      # Protected dashboard for logged-in users
├── style.css          # Styling for login/dashboard
└── README.md          # You're reading it!

````

---

## 🚀 How It Works

- `index.html` shows the login form.
- `login.php` verifies hardcoded credentials and starts a session.
- `dashboard.php` checks for active session, or redirects to login.
- `logout.php` destroys the session and redirects back to login.

---

## 🧪 Demo Credentials


| Username | Password  |
|----------|-----------|
| `cappriciosec`  | `cappriciosec@123` |

> You can change these in `login.php`.

---

## 🖥️ Usage

### 1. Start a local PHP server:

```bash
php -S localhost:8000
````

Then visit:
👉 [http://localhost:8000](http://localhost:8000)

---



### ✅ **Run on different IPs**

#### 1. **Default (localhost only)**

```bash
php -S 127.0.0.1:8000
```

Accessible only on the same device using:

```
http://127.0.0.1:8000
```

---

#### 2. **Loopback (localhost using hostname)**

```bash
php -S localhost:8000
```

This binds to the hostname `localhost`, equivalent to `127.0.0.1`.

---

#### 3. **All network interfaces (0.0.0.0)**

```bash
php -S 0.0.0.0:8000
```

✅ Accessible from other devices in your LAN using your system's IP, e.g.:

```
http://192.168.1.5:8000
```

You can find your IP with:

```bash
ipconfig    # on Windows
ifconfig    # on Linux/macOS
```

---

#### 4. **Bind to a specific LAN IP**

```bash
php -S 192.168.1.5:8000
```

Replace `192.168.1.5` with your actual system IP. This makes it available only on that IP.

---



## 📦 Tech Stack

* **Language:** PHP (vanilla)
* **Frontend:** HTML + CSS
* **Session Handling:** PHP native sessions

---

## 👨‍💻 Author

Built with ❤️ by [@karthithehacker](https://github.com/karthi-the-hacker)

---

## ⚠️ Disclaimer

This project is **for learning/demo purposes only**.
For real applications, implement proper validation, encryption, CSRF protection, and secure database integration.


