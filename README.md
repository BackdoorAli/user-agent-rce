# User-Agent Remote Command Injection (RCE)

This project demonstrates how an insecure use of the `User-Agent` HTTP header can lead to Remote Command Execution (RCE) if not properly sanitised. It includes:

- A vulnerable PHP server that logs headers unsafely using `system()`
- A secure version with input sanitization
- A Python-based exploit tool that simulates an attack
- Defensive guidelines and mitigation recommendations

## Author

GitHub: [BackdoorAli](https://github.com/BackdoorAli)

## Exploit Summary

When a web server logs the `User-Agent` header directly into a system shell command, it becomes vulnerable to injection if the attacker includes malicious shell syntax in the header.

Example malicious header:
```
User-Agent: zerodium; id
```

In an insecure environment, this results in execution of the `id` command on the server.

## Project Files

- `vulnerable_index.php` — Insecure PHP script (for demo only)
- `secure_index.php` — Hardened PHP script using `escapeshellarg()`
- `exploit.py` — CLI tool to send injection payloads via User-Agent header

## Usage

### Start the Vulnerable Server

```bash
cd vulnerable_server
php -S 127.0.0.1:8000
```

### Run the Exploit

```bash
python3 exploit.py http://127.0.0.1:8000/ "id"
```

### Output (vulnerable server):

```text
[+] Response Body:
uid=501(alita) gid=20(staff) groups=...
```

### Try the Secure Server

```bash
cd secure_server
php -S 127.0.0.1:8000
```

Re-running the same exploit will now produce no harmful effects.

---

## Disclaimer

This project is for educational and awareness purposes only. Do NOT deploy the vulnerable server in a production environment or expose it to the internet. Always sanitize user input and never directly inject user data into system commands.
