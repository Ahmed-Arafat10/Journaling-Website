# Section 4 — Arrays, Forms, and Request Data

[Previous: Section 3](Section%20%233.md) · [Documentation index](README.md) · [Next: Section 5](Section%20%235.md)

**Based on:** [Section 4 outline](../Sections%20Content/Section%20%234.md).

## Learning outcomes

You will use numeric and associative arrays, predict string interpolation, inspect request data, build a sign-up form, and explain how submitted values reach PHP through `$_POST`.

## 1. Numeric and associative arrays

PHP arrays map keys to values. The two forms introduced here differ mainly in the keys they use.

**Teaching example — numeric indexes:**

```php
<?php
$scores = [80, 95, 70];

echo $scores[0]; // 80
echo $scores[2]; // 70
```

Automatically assigned indexes in this example start at zero. `$scores[3]` is not defined; three values produce indexes `0`, `1`, and `2`.

**Teaching example — associative and nested arrays:**

```php
<?php
$student = [
    'name' => 'Mona',
    'age' => 20,
    'registered' => true,
    'course' => [
        'name' => 'Internet Applications',
    ],
];

echo $student['name'];           // Mona
echo $student['course']['name']; // Internet Applications
```

`=>` connects a key to a value. Meaningful keys make structured data easier to understand. A form submission works similarly: an input name becomes a key, and the submitted text becomes its value.

The project's [Practice.php](../pages/Practice.php) contains numeric and associative array examples. Nested arrays require another key lookup; echoing an entire array does not produce a useful display of its contents.

## 2. Double-quoted and single-quoted strings

**Core example used in `pages/Practice.php`:**

```php
<?php
$age = 26;

echo "My Age is $age";
echo '<br>';
echo 'My Age is $age';
```

The output is:

```text
My Age is 26
My Age is $age
```

Double-quoted strings interpolate variables and recognize escape sequences such as `\n`. Single-quoted strings normally preserve their contents literally, apart from escaping a single quote or backslash. Concatenation works with either style:

```php
<?php
$age = 26;
echo 'My Age is ' . $age;
```

An HTML page normally collapses text whitespace, so a `\n` in an output string does not necessarily create a visible browser line break. Use appropriate HTML elements, or `<pre>` when displaying preformatted text.

## 3. Superglobal arrays

Superglobals are predefined variables accessible in different PHP scopes without a `global` declaration. Four are central to the course:

| Array | Information it provides | Example |
| --- | --- | --- |
| `$_SERVER` | Request and server information | `$_SERVER['REQUEST_METHOD']` |
| `$_GET` | URL query-string parameters | `$_GET['page']` for `?page=2` |
| `$_POST` | Parsed fields from a standard HTML POST form | `$_POST['email']` |
| `$_SESSION` | Session data available after a session is started | A signed-in user's ID in a later lesson |

`$_GET` is populated by a query string even when the request method is POST. `$_POST` does not automatically contain every possible request body format; JSON bodies, for example, need separate handling. Standard forms in this section use the normal URL-encoded form format.

`$_SESSION` will be covered with login. It is not populated just because an HTML input has a name; PHP session handling must be initialized. These guides do not implement that later lesson.

## 4. Inspecting values with `var_dump()`

`var_dump()` displays types and values. This is useful when a value looks correct but has an unexpected type or structure.

```php
<?php
$age = 26;
var_dump($age);      // int(26)
var_dump('26');      // string(2) "26"
var_dump([1, 2, 3]); // Includes the array's keys and values
```

**Teaching example — a local debugging page:**

```php
<?php
echo '<pre>';
var_dump($_SERVER['REQUEST_METHOD'] ?? 'No HTTP request');
var_dump($_SERVER['DOCUMENT_ROOT'] ?? 'No document root');
echo '</pre>';
```

The `??` operator supplies a fallback when a value is absent or null. This also makes the example understandable if PHP is run from a terminal rather than through the web server.

On a local practice page, you can temporarily inspect the whole `$_SERVER` array with `var_dump($_SERVER)`. It can reveal paths, headers, and other request details. Remove debugging output afterward, and avoid dumping passwords, session cookies, or other private values.

## 5. GET, POST, and HTTPS

| Property | GET | POST |
| --- | --- | --- |
| Typical purpose | Retrieve a page, search, or filter | Submit data for processing or change application state |
| Standard HTML form fields | Added to the URL query string | Sent in the request body |
| PHP form-data array | `$_GET` | `$_POST` |
| Bookmarking form values | URL includes the values | URL alone does not preserve the submitted body |
| Suitable for passwords in a normal form | No | Use POST over HTTPS |

For example, a search form might produce `TaskView.php?search=revision`. A registration form should submit by POST so credentials are not placed in the URL.

**POST is not encryption.** It changes where the data is sent, not whether it is protected in transit. **HTTPS** is HTTP protected using TLS, which encrypts network traffic and helps authenticate the server. Password fields mask text on screen but do not encrypt the submitted value either.

A local classroom URL may use HTTP. A deployed registration/login flow should use HTTPS. Even with HTTPS, request data must still be validated because encryption does not make a user's input trustworthy.

## 6. Building the sign-up form

**Teaching example — simplified form for `pages/SignUp.php`, using the repository's field names:**

```html
<form method="post">
    <div>
        <label for="username">Username</label>
        <input id="username" name="username" type="text"
               placeholder="Your name" autocomplete="username" required>
    </div>

    <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email"
               placeholder="student@example.com" autocomplete="email" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="password"
               autocomplete="new-password" required>
    </div>

    <div>
        <label for="confirm_password">Confirm password</label>
        <input id="confirm_password" name="confirm_password" type="password"
               autocomplete="new-password" required>
    </div>

    <button type="submit" name="signUpBtn" value="1">Sign up</button>
</form>
```

With no `action` attribute, the form submits to the current page. PHP can process the submission at the beginning of that same file, then render the page again if there is an error.

### What each tag and attribute means

| HTML item | Role |
| --- | --- |
| `<form>` | Groups fields into a submission |
| `method="post"` | Selects POST as the request method |
| `action="..."` | Optional URL that receives the submission |
| `<label for="email">` | Associates visible label text with the input whose `id` is `email` |
| `<input>` | Collects a value |
| `type` | Chooses behavior such as text, email, or masked password entry |
| `placeholder` | Shows an example or hint while the input is empty; it is not a submitted default value |
| `name` | Defines the key sent to the server |
| `id` | Identifies an element for labels, CSS, or JavaScript; it does not define the PHP key |
| `required` | Requests browser-side validation that the field is filled |

An input can display correctly without a `name`, but its value will not appear as a normal named form field in `$_POST`. Always connect labels with matching `for` and `id` values.

Browser validation is helpful feedback. The server must repeat the relevant checks because clients can skip HTML validation.

## 7. Following a submission into PHP

Suppose the student enters `Mona`, `mona@example.com`, and matching passwords, then clicks Sign up. The request body contains keys equivalent to:

```text
username=Mona
email=mona@example.com
password=[entered password]
confirm_password=[entered password]
signUpBtn=1
```

This is a readable illustration, not the exact encoded body. PHP parses the form and makes those names available as array keys.

**Teaching example — handling a request at the top of a page:**

```php
<?php
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    // Validate the values before using or saving them.
}
```

The initial page visit normally uses GET. Clicking the form's submit button normally causes POST. The condition separates “show the form” from “process the submitted form.” Form values normally arrive as strings, but deliberately crafted field names can produce arrays; robust validation checks the shape as well as the value.

## 8. Introducing `Authenticate.php`

The class groups account operations so that the page can focus on displaying the form. The repository uses `App\Authenticate` and calls its `signUp()` method before the HTML.

**Teaching skeleton — class structure before database logic is added:**

```php
<?php
namespace App;

class Authenticate
{
    public function signUp(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            return;
        }

        // Next section: read fields, validate, hash, and insert.
    }
}
```

**Page-side setup — place before the document's HTML:**

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$auth = new \App\Authenticate();
$auth->signUp();
?>
```

`return` ends the current method. The initial GET does no registration work, and the page can continue to display its form. Section 5 explains the repository's alternative button check, `isset($_POST['signUpBtn'])`, and completes the save flow.

## Common mistakes

- Reading `$_POST['email']` on the initial GET without checking whether it exists can cause an undefined-array-key warning.
- Using `id="email"` without `name="email"` does not submit an `email` field.
- Reading a POST form through `$_GET` looks in the wrong place for its body fields.
- Echoing submitted text directly into HTML can allow it to be interpreted as markup. Section 5 introduces `htmlspecialchars()` for HTML output.
- Printing debugging data before a redirect can cause “headers already sent.” Remove temporary dumps before implementing redirects.

## Practice and answers

1. An input has `id="student-email"` and `name="email"`. Which key should PHP read?
2. What does `echo 'Age: $age';` print when `$age = 26`?
3. Does changing a password form from GET to POST encrypt it?
4. Why might `$_POST` be empty when the form is first opened?

**Answers:** (1) `$_POST['email']`. (2) The literal text `Age: $age`. (3) No; use HTTPS for protection in transit. (4) Opening the page is normally a GET request before any form submission.

**Ready for Section 5:** You can trace a named input from HTML to a PHP array value and explain why the backend must validate it.
