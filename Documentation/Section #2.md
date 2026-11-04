# Section 2 — Local Environment and Your First PHP Page

[Previous: Section 1](Section%20%231.md) · [Documentation index](README.md) · [Next: Section 3](Section%20%233.md)

**Based on:** [Section 2 outline](../Sections%20Content/Section%20%232.md).

## Learning outcomes

You will set up a local PHP environment, understand the role of Laragon's `www` folder, write a PHP page, explain how it executes, and create a practice database using phpMyAdmin.

## 1. Laragon and XAMPP

PHP applications need a runtime and usually a web server and database server. Laragon and XAMPP make local development easier by packaging or managing these components.

| Tool | General role | Common project location |
| --- | --- | --- |
| Laragon | Windows development environment with tools for managing local services | `<Laragon installation>/www/` |
| XAMPP | Local development distribution that includes Apache, a database server, and PHP | `<XAMPP installation>/htdocs/` |

They are development environments, not programming languages. The PHP concepts are the same in both. This course uses Laragon, so the paths and service controls below follow Laragon. Installed components and versions depend on the package and configuration you use.

### Install and start Laragon

1. Download the Windows installer from the [official Laragon installation page](https://laragon.org/docs/install).
2. Choose an installation directory. This checkout uses `D:\laragon`, while another machine might use `C:\laragon`.
3. Launch Laragon and start the web and database services, normally with **Start All**.
4. Check the service status. If a service cannot start, inspect its log and check whether another application is already using its configured port.
5. Open `http://localhost` in a browser to check the web server.

That last check confirms the web service is reachable; it does not by itself prove the database connection works.

## 2. The `www` folder and the project folder

In a typical Laragon configuration, `www` is the web document root: folders beneath it are available through the local web server.

```text
D:\laragon\www\
└── IA_HU_2026\
    ├── pages\
    │   └── index.php
    ├── class\
    └── assets\
```

The outline names the course folder `IA/`. This repository is named `IA_HU_2026`, so its home page is normally:

```text
http://localhost/IA_HU_2026/pages/index.php
```

If you use `IA` as the directory name, change the URL accordingly. If your web server uses another port or a virtual host, the base URL also changes.

Do not double-click a PHP file and expect `file:///...` to execute it. The browser must request it through a PHP-enabled web server. Also, the repository's current home page opens a database connection; use the standalone example below to test PHP before setting up the database.

## 3. What we are building

**Journaling** is a small application in which users register, sign in, and manage tasks. Sections 1–5 establish the environment, shared page structure, and registration flow. Login and task management are later course topics.

The registration flow is:

```text
Display form → receive submitted values → validate → hash password → save user
```

The database keeps the account after the PHP request finishes. A normal PHP variable exists only during the current script execution.

## 4. Your first PHP file

**Teaching example — save as `pages/hello.php` if you want to try it:**

```php
<?php
$courseName = 'Internet Applications';
echo '<h1>Hello from PHP</h1>';
echo '<p>Welcome to ' . $courseName . '</p>';
?>
<p>This paragraph is ordinary HTML outside the PHP tags.</p>
```

Open `http://localhost/IA_HU_2026/pages/hello.php`. You should see a heading and two paragraphs.

- `<?php` starts PHP code.
- `$courseName` is a variable; PHP variable names begin with `$`.
- `=` assigns a value.
- `echo` outputs text. It is a PHP language construct, not an ordinary function that needs parentheses.
- `.` joins strings together; this is called concatenation.
- `;` ends most PHP statements.
- `?>` leaves PHP mode so subsequent content is treated as output.

The string `'<h1>Hello from PHP</h1>'` includes HTML. PHP outputs those characters; the browser interprets the `<h1>` tags and draws a heading.

For a file containing only PHP, leave out the closing `?>` tag. This helps avoid accidental whitespace output, which becomes important when sending redirects.

### Mixing PHP with HTML

**Teaching example — a complete standalone page:**

```php
<?php
$studentCount = 30;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our class</title>
</head>
<body>
    <h1>Our class</h1>
    <p>Number of students: <?php echo $studentCount; ?></p>
</body>
</html>
```

The browser receives `<p>Number of students: 30</p>`. It does not receive the assignment to `$studentCount` as PHP source. Later, when outputting user-provided text, use HTML escaping as explained in Section 5.

## 5. How PHP executes

1. The browser requests a `.php` page over HTTP.
2. The web server passes the PHP work to the configured PHP runtime.
3. The PHP engine reads and executes the script. It evaluates variables, calls functions, and may communicate with a database.
4. The generated output becomes part of the HTTP response.
5. The browser displays that response.

The **PHP engine** is the software that interprets and executes PHP code. It is distinct from the browser, the web server, and the database engine.

Refreshing a page usually initiates another request and another script execution. The script does not continue running inside the browser after its response is displayed.

## 6. Database engine versus database GUI

| Component | What it does |
| --- | --- |
| MySQL or MariaDB engine | Stores records, executes SQL, and enforces database constraints |
| phpMyAdmin | Browser-based interface for administering a MySQL-compatible database |
| PHP `mysqli` extension | Lets your PHP application connect to and query that database |

Closing phpMyAdmin does not delete the database. Conversely, opening phpMyAdmin does not make a stopped database engine start working automatically.

### Add phpMyAdmin to Laragon

Laragon's documented menu path is **Menu → Tools → Quick add → phpmyadmin**. After installation, use the database/phpMyAdmin menu entry to open it, and sign in with the credentials configured for your local database. Menu labels may vary with the installed version. See [Laragon operations](https://laragon.org/docs/operations).

The checked-in `class/DB.php` expects host `localhost`, user `root`, an empty password, and database `ia_sections_hu`. Those are this project's local settings, not a guarantee about every Laragon installation. Use the credentials you actually configured.

## 7. Understanding the project schema

A **schema** describes the structure of stored data: table names, columns, types, keys, and relationships.

There is no SQL export or full database definition in this repository. Its registration code inserts four values into a table named `user`: an automatically generated ID, a username, an email, and a password hash. The following is a **suggested practice schema**, not a recovered copy of the instructor's database.

| Column | Type | Purpose |
| --- | --- | --- |
| `id` | `INT`, primary key, auto increment | Unique account identifier generated by the database |
| `username` | `VARCHAR(100)` | User's chosen display name |
| `email` | `VARCHAR(255)`, unique | Account email; duplicate values are rejected |
| `password` | `VARCHAR(255)` | Password hash, never the original password |

`NOT NULL` means a column must have a value; it does not reject an empty string. Application validation still checks for empty input. A primary key identifies a row, while a unique constraint prevents duplicate values in another column.

The wider application will need tasks linked to users. That relationship is useful background, but the exact task schema is not supplied here because these guides stop at registration.

### Create the practice schema in phpMyAdmin

Use a fresh course database. If you already have `ia_sections_hu`, inspect it first rather than recreating or replacing existing tables.

1. Start the database service and open phpMyAdmin.
2. Open its **SQL** tab.
3. Run this practice SQL only if the named database does not already exist.
4. Expand the new database and inspect the `user` table's **Structure** tab.

```sql
CREATE DATABASE `ia_sections_hu`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `ia_sections_hu`;

CREATE TABLE `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_email_unique` (`email`)
);
```

`utf8mb4` supports Unicode text. Backticks quote SQL identifiers such as table and column names. The chosen collation also affects comparisons, including the unique email constraint.

Alternatively, use phpMyAdmin's **New** database screen, create the four columns through the table editor, and apply the same primary key, auto-increment, and unique settings. The SQL and GUI approaches produce the same intended structure.

To inspect the structure and contents without changing them:

```sql
DESCRIBE `user`;
SELECT `id`, `username`, `email` FROM `user`;
```

An empty result from the second statement is expected before anyone registers.

## Troubleshooting

| Symptom | What to check |
| --- | --- |
| Browser cannot reach localhost | Web service status, configured port, and possible port conflicts |
| 404 for your PHP file | Project folder, filename, and URL path |
| PHP source appears instead of executing | You used `file://`, or the web server lacks a working PHP handler |
| “Unknown database” | Database name and whether it has been created |
| Database “Access denied” | Host, username, password, and database permissions |
| Syntax error | Missing semicolon, unmatched quote, or unmatched bracket near the reported line |

## Practice and answers

1. Change `hello.php` to print your name inside an `<h2>` element.
2. Explain why a PHP file must be requested through localhost for this exercise.
3. Does `NOT NULL` ensure that a submitted username is meaningful?

**Answers:** (1) For a fixed classroom string, `echo '<h2>Ahmed</h2>';` works. (2) The web server invokes PHP and returns its output; opening a local file directly bypasses that processing. (3) No; an empty string still is not SQL `NULL`, so validate the username in PHP.

**Ready for Section 3:** A standalone PHP page renders through the web server, and you understand how the database engine differs from its management interface.
