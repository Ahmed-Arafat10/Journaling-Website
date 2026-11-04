# Section 3 — Project Structure, Classes, and Composer

[Previous: Section 2](Section%20%232.md) · [Documentation index](README.md) · [Next: Section 4](Section%20%234.md)

**Based on:** [Section 3 outline](../Sections%20Content/Section%20%233.md).

## Learning outcomes

You will understand the project's folder structure, reuse a navbar, distinguish filesystem paths from URLs, create PHP objects, and explain how Composer loads the `DB` class.

## 1. Project structure

The important folders in this checkout are:

```text
IA_HU_2026/
├── assets/
│   ├── css/                 Stylesheets, including Bootstrap
│   └── js/                  Browser JavaScript
├── class/
│   ├── DB.php               Database connection helper
│   ├── Authenticate.php     Account-related logic
│   └── Alert.php            Feedback messages
├── pages/
│   ├── Layout/
│   │   └── navbar.php       Shared navigation markup
│   ├── index.php            Home page
│   ├── SignUp.php           Registration page
│   └── Practice.php         PHP experiments
├── vendor/                 Composer-generated dependencies and autoloader
├── composer.json           Project configuration
└── composer.lock           Locked dependency information
```

`assets` contains resources the browser loads. `class` groups reusable PHP behavior. `pages` contains request entry points and shared page fragments. These responsibilities make it easier to find the code you need.

The outline calls the navbar location `pages/Layouts/Navbar.php`; the actual checkout uses **`pages/Layout/navbar.php`**. Use the real path. A capitalization difference that works on Windows can fail on a case-sensitive server.

## 2. Bootstrap 5

Bootstrap is a frontend toolkit providing CSS classes and JavaScript components. You apply its existing styles by adding class names to HTML elements.

The bundled CSS identifies itself as Bootstrap **5.0.2**. A simple page fragment can use it like this:

```html
<!-- Teaching example: asset path is relative to a page inside pages/. -->
<link rel="stylesheet" href="../assets/css/bootstrap.css">

<main class="container mt-4">
    <h1>Journaling</h1>
    <p class="text-muted">Keep track of your daily work.</p>
    <a class="btn btn-primary" href="SignUp.php">Create an account</a>
</main>
```

`container` controls layout width and spacing, `mt-4` adds top margin, and `btn btn-primary` gives the link a button appearance. Bootstrap styles the interface; it does not register users or connect to the database.

Interactive components require matching Bootstrap JavaScript. In Bootstrap 5, navbar collapse controls use `data-bs-toggle` and `data-bs-target`. The current repository navbar uses older `data-toggle`/`data-target` attributes; if its mobile toggle does not work, check these attributes and the JavaScript version. See the [Bootstrap 5 navbar documentation](https://getbootstrap.com/docs/5.0/components/navbar/).

## 3. Reusing a navbar with `require_once`

If each page contains its own copy of the navbar, changing one link requires editing every copy. A shared fragment lets each page use the same markup.

**Teaching example — contents of a shared navbar fragment:**

```html
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Journaling</a>
        <a class="nav-link text-white" href="SignUp.php">Sign up</a>
    </div>
</nav>
```

**Teaching example — include it from a file directly inside `pages/`:**

```php
<?php
require_once __DIR__ . '/Layout/navbar.php';
```

`require_once` loads and executes the target file at that point in the request. Any HTML from the file becomes part of the output. The `once` suffix avoids loading the same file again during that request. If a required file cannot be loaded, execution fails instead of silently continuing without it.

An include does not send the browser to another page. It combines server-side content into the current response. Relative links inside an included navbar resolve against the requested page's URL, not the fragment's filesystem location.

## 4. Absolute paths, relative paths, and URLs

| Kind | Example | Meaning |
| --- | --- | --- |
| Absolute filesystem path | `D:/laragon/www/IA_HU_2026/pages/Layout/navbar.php` | Full location on the server's disk |
| Relative filesystem path | `../vendor/autoload.php` | Location interpreted relative to the PHP execution/include context |
| Browser URL | `http://localhost/IA_HU_2026/pages/index.php` | Address requested over HTTP |
| Root-relative URL | `/IA_HU_2026/pages/SignUp.php` | URL path from the current website's root |

`..` means “parent directory.” `__DIR__` is PHP's directory of the file containing that expression. Joining it to a relative suffix creates a stable filesystem path:

```php
<?php
// If this code is inside pages/index.php:
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Layout/navbar.php';
```

The repository also uses `$_SERVER['DOCUMENT_ROOT']` to build paths. That value is the web server's configured document root. Hard-coding a project directory after it can break when a virtual host already points directly at the project. `__DIR__` keeps these includes relative to the source file instead.

Use filesystem paths for `require_once`. Use URL paths for links and redirects. A Windows disk path is not a valid navigation destination for users of a website.

## 5. Variables and basic PHP syntax

```php
<?php
$age = 26;
$studentName = 'Mona';
$isRegistered = true;

echo $studentName . ' is ' . $age . ' years old.';
```

Variables store values. PHP variable names are case-sensitive, so `$age` and `$Age` are different variables. This example uses an integer, a string, and a boolean. Ordinary variables do not require a declared type, although properties and function signatures can use type declarations.

## 6. Classes and objects

A **class** describes the data and operations that a kind of object can have. An **object** is an instance created from that class.

- A **property**, sometimes called an attribute, stores data belonging to an object.
- A **method** is a function defined inside a class.
- A **constructor**, named `__construct()`, initializes a newly created object.
- `new` instantiates an object.
- `$this` refers to the current object inside its instance methods.
- `->` accesses an object's property or calls an object's method.

**Teaching example — a small user-defined class:**

```php
<?php
class Student
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function introduce(): string
    {
        return 'Hello, I am ' . $this->name;
    }
}

$firstStudent = new Student('Mona');
$secondStudent = new Student('Omar');

echo $firstStudent->introduce();  // Hello, I am Mona
echo $secondStudent->introduce(); // Hello, I am Omar
```

The objects share the same class definition but hold different `$name` values. Inside the constructor, `$name` is the incoming parameter and `$this->name` is the property's value on that particular object.

### Access modifiers

| Modifier | Where the property or method is accessible |
| --- | --- |
| `public` | From inside and outside the class |
| `private` | Only within the class that declares it |
| `protected` | Within the declaring class and classes that inherit from it |

Making a property private keeps other code from changing it directly. It is an object-design boundary, not encryption for the value.

A **parameterized constructor** receives arguments, as `Student` does above. A **non-parameterized constructor** receives no arguments; it may initialize values from defaults or configuration. The repository's `DB` constructor takes no arguments.

`Student` and `App\DB` are user-defined classes. `mysqli` is a class provided by PHP's MySQLi extension. You create objects from both using `new`, but you write the definition only for your own classes.

## 7. Composer and JSON

Composer manages PHP project dependencies and can generate an autoloader for your classes. This repository uses it for autoloading even though its `composer.json` does not declare third-party package requirements.

On Windows, install Composer using the official **Composer-Setup.exe** installer, select the appropriate PHP executable when prompted, and reopen the terminal afterward so PATH changes take effect. Verify with `composer` or `composer --version`. See [Composer's Windows installation instructions](https://getcomposer.org/doc/00-intro.md#installation-windows).

Run project commands from the directory containing `composer.json`:

```powershell
Set-Location 'D:\laragon\www\IA_HU_2026'
composer --version
composer install
```

`composer install` installs the locked dependency versions when a lock file exists and generates the autoload files. `vendor/` is generated output; edit your source and configuration rather than hand-editing Composer's generated files. After changing the autoload mapping, regenerate it with `composer dump-autoload`. See [Composer basic usage](https://getcomposer.org/doc/01-basic-usage.md).

### Understanding `composer.json`

**Repository snapshot — `composer.json`:**

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "class"
    }
  }
}
```

JSON means **JavaScript Object Notation**. It is a text format for structured data, used by many languages. An object uses braces and key–value pairs; keys and string values use double quotes. Standard JSON does not allow comments or trailing commas.

In a JSON string, `\\` represents one literal backslash. Thus `"App\\"` describes the PHP namespace prefix `App\`.

## 8. Namespaces and autoloading

A namespace groups class names and helps avoid collisions. `App\DB` means the `DB` class inside the `App` namespace. With this project's PSR-4 configuration, Composer maps that class to `class/DB.php`.

```text
App\DB           → class/DB.php
App\Authenticate → class/Authenticate.php
App\Alert        → class/Alert.php
```

Keep namespace, class, and filename capitalization consistent. Composer's [autoload schema reference](https://getcomposer.org/doc/04-schema.md#autoload) describes this mapping.

**Teaching example — load and use `DB` from a page:**

```php
<?php
use App\DB;

require_once __DIR__ . '/../vendor/autoload.php';

$myDB = new DB();
```

`use App\DB` provides a short name for that class; it does not load the file by itself. Requiring `vendor/autoload.php` registers Composer's loader. When PHP needs the class, the loader finds its file. An equivalent instantiation without the `use` statement is `$myDB = new \App\DB();`.

## 9. The project's `DB` class

**Repository snapshot — `class/DB.php`:**

```php
<?php
namespace App;

use mysqli;

class DB
{
    private string $hostname = 'localhost';
    private string $username = 'root';
    private string $databaseName = 'ia_sections_hu';
    private string $password = '';
    public mysqli $connection;

    public function __construct()
    {
        $this->connection = new mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->databaseName
        );
    }
}
```

Trace `$myDB = new DB();` step by step:

1. Composer locates `class/DB.php` if the class has not already been loaded.
2. PHP creates an instance and invokes `__construct()`.
3. The constructor reads the object's connection settings.
4. `new mysqli(...)` attempts a database connection.
5. The resulting `mysqli` object is stored in the public `$connection` property.

The `use mysqli;` statement refers to the extension class in the global namespace. Without an import or a leading backslash, an unqualified class name inside `namespace App` would be resolved under `App`.

The local credentials shown are copied from the repository. An incorrect database name or stopped database service can cause object construction to fail. Successful class autoloading and successful database connectivity are separate checks.

### The `check()` method mentioned in the outline

The outline mentions calling `check()`, but **the checked-in `DB` class has no such method**. Calling it as-is would cause an undefined-method error.

For a classroom exercise, you could add the following method *inside* `DB`. This is a teaching extension, not existing repository code:

```php
public function check(): bool
{
    $result = $this->connection->query('SELECT 1 AS connection_ok');
    return $result !== false;
}
```

Then, after loading Composer and successfully constructing the object, call:

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$myDB = new \App\DB();
echo $myDB->check() ? 'Database connection works.' : 'Check failed.';
```

This small read-only query checks whether the connection can execute SQL. With MySQLi exception reporting enabled, a connection or query failure throws an exception rather than necessarily returning `false`; the helper is not a complete error handler.

## Common mistakes

| Problem | Explanation |
| --- | --- |
| `Class "App\DB" not found` | Check the autoloader include, namespace, class name, and mapping |
| Missing `vendor/autoload.php` | Run `composer install` from the project root |
| Undefined method `check()` | The outline's example method is absent from the current class |
| Navbar missing on another operating system | Check `Layout` versus `Layouts` and filename capitalization |
| “Could not open input file” or failed include | Check whether you used a filesystem path in the correct context |

## Practice and answers

1. Which part of `new Student('Mona')` runs automatically?
2. Why can code call `$myDB->connection` but not `$myDB->password`?
3. Does `use App\DB;` replace the Composer autoloader include?

**Answers:** (1) The constructor. (2) `$connection` is public, whereas `$password` is private. (3) No; `use` establishes a name alias and the autoloader locates the class file.

**Ready for Section 4:** You can explain how a page includes shared HTML and how an autoloaded `DB` object creates a database connection.
