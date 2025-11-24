# OWASP Mutillidae II – Security Analysis & Static Code Review

### Prepared by: **Mostafa Hussein**

---

## 📌 Overview

This repository documents a complete **security analysis** performed on the intentionally vulnerable web application **OWASP Mutillidae II (v2.6.62)**.
The analysis includes:

* Full **Docker environment setup**
* **Vulnerability discovery** and exploitation (SQL Injection & XSS)
* **Static code analysis** using custom **Semgrep rules**
* Overview of Mutillidae’s features, structure, and installation
* Git workflow used during the exercise

This README serves as a comprehensive, technical, and standalone documentation page suitable for a GitHub repository.

---

## 📌 1. Environment Setup (Docker)

A reproducible security testing environment was built using **Docker Compose**.

### **Services**

#### **1. Database (`db`)**

* Image: `mysql:5.7`
* Environment:

  * `MYSQL_ROOT_PASSWORD: root`
  * `MYSQL_DATABASE: mutillidae`
  * `MYSQL_USER: user`
  * `MYSQL_PASSWORD: password`
* Port: `3306`

#### **2. Web Application (`web`)**

* Image: `citizenstig/nowasp`
* Port: `8080`
* Depends on: `db`

This setup launches a working instance of Mutillidae II suitable for vulnerability testing.

---

## 📌 2. Vulnerability Identification & Exploitation

During reconnaissance two critical vulnerabilities were identified and successfully exploited.

---

### **A. SQL Injection (Authentication Bypass)**

**File:** `/app/classes/MySQLHandler.php`
**Issue:** User-controlled input is directly concatenated into the SQL query:

```php
$lQueryString = "SELECT username" .
                "FROM accounts" .
                "WHERE username='" . $pUsername . "'" .
                "AND password='" . $pPassword . "';";
```

**Security Problems**

* No input sanitization
* No escaping
* No prepared statements

This enables SQL injection, allowing authentication bypass.

---

### **B. Reflected / Stored Cross-Site Scripting (XSS)**

**File:** `/mutillidae/index.php`
**Vulnerable Code:**

```php
<input type="text" name="initials" <?php echo $lHTMLControlAttributes ?> value="<?php echo $lUserInitials; ?>" />
```

**Cause:**
`$lUserInitials` is printed to the page **without escaping**.

**Payload Used:**

```
"><script>alert('XSS')</script>"
```

**Result:**
Browser executes attacker-supplied JavaScript → Successful XSS.

---

## 📌 3. Static Code Analysis with Semgrep

Two custom Semgrep rules were written to detect SQLi and XSS patterns inside the PHP codebase.

### **Rule 1 – SQL Injection Detection**

Targets:

* Query strings constructed via concatenation
* Unsafe uses of `mysqli_query`
  Ignores:
* Secure code using `mysqli_prepare(...)`

### **Rule 2 – XSS Detection**

Targets:

* Direct `echo` of `$_GET`, `$_POST`, and `$_REQUEST`
  Ignores:
* Sanitized output (e.g., `htmlspecialchars()`)

### **Scan Summary**

* Files scanned: **170**
* Custom rules used: **2**
* Findings: **1 valid vulnerability**

This confirmed the accuracy of the ruleset.

---

## 📌 4. Git Workflow

The following workflow was used:

1. Create new branch

   ```
   semgrep/mostafa
   ```
2. Add Semgrep rules, tests, documentation
3. Commit with meaningful messages
4. Push and submit branch for review

---

## 📌 5. About OWASP Mutillidae II

OWASP Mutillidae II is a deliberately vulnerable web application used for:

* Cybersecurity labs
* University courses
* CTF competitions
* Web security training
* Automated vulnerability testing

### **Key Features**

* 40+ real, exploitable vulnerabilities
* Covers OWASP Top 10 (2007–2017)
* Switch between secure/insecure modes
* One-click “Reset to Default”
* Preinstalled on:

  * OWASP BWA
  * SamuraiWTF
  * Metasploitable 2

---

## 📌 6. Tutorials & Installation Resources

* Official X (Twitter): **@webpwnized**
* YouTube Tutorials: *webpwnized channel*

### Installation Options

* DockerHub Images
* Docker on Linux/Windows
* Google Cloud (GKE)
* LAMP Stack (manual install)

---

## 📌 7. Updated Directory Structure (src)

```
/root
│── README.md
│── README-INSTALLATION.md
│── SECURITY.md
│── CONTRIBUTING.md
│── CHANGELOG.md
│── LICENSE
│── version
│
└── /src
    │── ajax
    │── classes
    │── data
    │── documentation
    │── images
    │── includes
    │── javascript
    │── labs
    │── passwords
    │── styles
    └── webservices
         │── includes
         │── rest
         └── soap
             └── lib
```

---

## 📌 Conclusion

This repository consolidates:

* Full Docker environment setup
* SQL Injection & XSS analysis
* Custom Semgrep rules
* Mutillidae structure & documentation
* Git workflow and methodology

The content provides a complete, professional security analysis reference prepared by **Mostafa Hussein**.

