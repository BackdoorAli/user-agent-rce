# Defense Strategies: User-Agent RCE

This document outlines how to detect, mitigate, and harden against Remote Command Execution (RCE) vulnerabilities introduced by insecure handling of HTTP headers, specifically the `User-Agent`.

---

## Author

GitHub: [BackdoorAli](https://github.com/BackdoorAli)

## Vulnerability Overview

Unsanitised use of the `User-Agent` header in system commands allows attackers to inject payloads like:

```
User-Agent: zerodium; id
```

This can lead to:
- Unauthorised command execution
- Data exfiltration
- Server compromise

---

## Mitigation Techniques

### 1. **Avoid Shell Execution**
- **Do not use `system()`** or similar shell functions (`exec`, `passthru`, `popen`) with unsanitized input.
- If shell execution is necessary, strictly control all input.

---

### 2. **Input Sanitisation**
If system calls are unavoidable:

```php
$ua = escapeshellarg($_SERVER['HTTP_USER_AGENT']);
system("echo $ua >> /tmp/ua_log.txt");
```

Use `escapeshellarg()` or `escapeshellcmd()` in PHP to neutralize dangerous characters.

---

### 3. **Use Logging Libraries**
Avoid manual shell commands for logging. Use PHP-native logging methods instead:

```php
error_log($_SERVER['HTTP_USER_AGENT']);
```

---

### 4. **Web Application Firewall (WAF)**
Deploy a WAF to detect and block:
- Shell metacharacters (`;`, `&&`, `|`, `` ` ``)
- Unexpected command syntax in headers

---

### 5. **File Integrity Monitoring**
Watch `/tmp`, `/var/log`, and custom directories for unauthorized file changes.

---

### 6. **System Hardening**
- Disable unnecessary PHP functions (`system`, `exec`, `shell_exec`) in `php.ini`
- Use non-root users for web services
- Implement mandatory access controls (e.g., AppArmor, SELinux)

---

### 7. **Logging & Detection**
Monitor logs for suspicious `User-Agent` strings:
- Use regex patterns to flag dangerous headers
- Correlate with outbound traffic or file changes

---

## For Developers

- Treat all HTTP headers as untrusted
- Never interpolate untrusted input directly into system commands
- Validate and encode inputs even if they appear “safe”

---

## Resources

- [OWASP Command Injection Guide](https://owasp.org/www-community/attacks/Command_Injection)
- [PHP Manual – escapeshellarg()](https://www.php.net/manual/en/function.escapeshellarg.php)

---

*This guide is intended to help developers and defenders harden applications against this class of attack.*