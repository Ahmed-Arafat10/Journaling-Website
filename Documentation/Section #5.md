# Section 5 — Validating and Saving a New User

[Previous: Section 4](Section%20%234.md) · [Documentation index](README.md)

**Based on:** [Section 5 outline](../Sections%20Content/Section%20%235.md).

## Learning outcomes

You will understand the complete registration flow: identify a submission, validate it, display feedback, hash a password, insert a user with a prepared statement, and redirect to a sign-in page.

**Prerequisites:** The Section 2 practice schema, a working `App\DB` connection, Composer autoloading, and the form fields from Section 4. SQL examples below assume columns named `id`, `username`, `email`, and `password`. Check your own schema if it differs.

## 1. Registration as a sequence of decisions

```text
Request arrives
    ↓
Is this a form submission? ── No ──→ Display the form
    ↓ Yes
Read and validate the fields
    ├── Invalid → Display feedback; do not insert
    ↓ Valid
Hash the password
    ↓
Prepare SQL → bind values → execute
    ├── Database error → Display appropriate feedback
    ↓ Success
Redirect to SignIn.php?successSignUp=1 → stop this script
```

Validation should happen before the database insert. A successful database insert should happen before the success redirect. This order prevents invalid accounts and false success messages.

The checked-in `Authenticate::signUp()` already compares passwords, hashes a password, and inserts a user. It currently prints a success alert instead of redirecting. The examples here explain that code and then show an educational extension implementing the redirect described in the outline.

## 2. `isset()` and submission detection

`isset()` returns true when a variable or array entry exists and is not `null`.

```php
<?php
$values = ['name' => 'Mona', 'emptyText' => '', 'missingValue' => null];

var_dump(isset($values['name']));         // true
var_dump(isset($values['emptyText']));    // true
var_dump(isset($values['missingValue'])); // false
var_dump(isset($values['unknown']));      // false
```

It checks existence/non-nullness, not whether a field has useful content. An empty password string can still pass `isset()`.

**Repository snapshot — the condition inside `Authenticate::signUp()`:**

```php
if (isset($_POST['signUpBtn'])) {
    // Registration processing happens here.
}
```

This corresponds to the button's `name="signUpBtn"`. It works when that named button is included in the submitted form data. A submission can omit the button, so a page dedicated to registration can instead check:

```php
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    // Process the registration request.
}
```

If one page accepts several different actions, distinguish the action as well as the request method.

## 3. The `Alert` class and `static`

The project's `Alert` class provides a `printMessage()` method that outputs a Bootstrap alert. The outline spells it `PrintMessage()`, but these guides follow the declared spelling, `printMessage()`.

A **static method** belongs to the class and can be called without constructing an object:

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

\App\Alert::printMessage('Passwords do not match', 'danger');
```

`::` accesses the class's static member. Compare this with `$auth->signUp()`, which calls a method on an object using `->`. A static method does not have `$this` because it is not operating on a particular instance.

**Teaching version — an alternative `class/Alert.php` that escapes message text:**

```php
<?php
namespace App;

class Alert
{
    public static function printMessage(string $message, string $type): void
    {
        $alertClass = $type === 'success' ? 'alert-success' : 'alert-danger';
        $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        echo '<div class="alert ' . $alertClass . '" role="alert">'
            . $safeMessage . '</div>';
    }
}
```

Bootstrap's stylesheet must be loaded by the page for the alert's styling to appear. `htmlspecialchars()` makes characters such as `<` appear as text rather than starting HTML tags. This prevents a message containing user text from being treated as page markup. HTML escaping and SQL parameter binding protect different contexts; one does not replace the other.

The existing repository method directly concatenates `$message`. The teaching version above is explicitly an alternative, not a claim that the original already escapes messages.

## 4. Validating form data

At minimum, the outlined lesson checks that the password matches its confirmation:

```php
if ($password !== $confirmPassword) {
    // Report the error and stop the registration attempt.
}
```

Use the original strings for this comparison. Do not trim a password: leading and trailing spaces may be intentional. Trimming a username or email is usually useful for removing accidental surrounding whitespace.

A practical form also checks that required inputs are strings, that required values are present, that the email has a valid format, and that values fit the database columns. `filter_var($email, FILTER_VALIDATE_EMAIL)` checks email syntax; it does not prove ownership of the mailbox.

Keep the database's unique email constraint even if you add an earlier duplicate lookup. Two requests can arrive at almost the same time; the database constraint is what ultimately prevents duplicate records.

## 5. Password hashing versus encryption

| Operation | Purpose | Can the original value be recovered normally? |
| --- | --- | --- |
| Encryption | Protect data that an authorized party needs to read later | Yes, with the decryption key |
| Password hashing | Store a value used to check a later password attempt | There is no decryption operation; guesses are checked against the hash |

Store a password hash, not a plain password. A password hash still needs protection because someone who obtains it can attempt guesses.

**Teaching example:**

```php
<?php
$password = 'A classroom example passphrase';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Store $hashedPassword in the database's password column.
```

PHP generates the salt automatically. The encoded hash includes information needed for verification. Two calls with the same password can produce different hashes, so do not verify a login by hashing again and comparing strings. The later login lesson uses `password_verify()`. A `VARCHAR(255)` column leaves room for changes in the default algorithm. See the [PHP password_hash reference](https://www.php.net/manual/en/function.password-hash.php).

Hash only after validation succeeds, and do not store the confirmation field. It exists to catch a typing mistake in the form.

## 6. Understanding the SQL insert

**SQL demonstration with fixed classroom values; the last value is only a placeholder, not a real password hash:**

```sql
INSERT INTO `user` (`username`, `email`, `password`)
VALUES ('Mona', 'mona@example.com', 'HASH_GENERATED_BY_PHP');
```

The `id` column is omitted because the practice schema generates it automatically. The table name follows `INSERT INTO`; the column list identifies where values go, in the same order as the `VALUES` list.

The current application uses:

```sql
INSERT INTO `user` VALUES (NULL, ?, ?, ?);
```

That statement assumes the table has exactly four columns in the expected order. An explicit column list communicates the intent and avoids relying on every column's position:

```sql
INSERT INTO `user` (`username`, `email`, `password`) VALUES (?, ?, ?);
```

## 7. SQL injection and prepared statements

SQL injection occurs when untrusted input changes the meaning of a query because the application combines it with SQL syntax. Directly inserting form values into a SQL string can also break ordinary inputs such as a name containing an apostrophe.

**Unsafe pattern — explanation only; do not use this to insert form input:**

```php
$sql = "INSERT INTO `user` (`username`, `email`, `password`) "
     . "VALUES ('$username', '$email', '$hashedPassword')";
```

Use placeholders and bind the values instead:

**Teaching snapshot — run after validation, with an existing `App\DB` object:**

```php
$stmt = $myDB->connection->prepare(
    'INSERT INTO `user` (`username`, `email`, `password`) VALUES (?, ?, ?)'
);
$stmt->bind_param('sss', $username, $email, $hashedPassword);
$stmt->execute();
```

The three steps have different jobs:

1. **`prepare()`** creates a statement with value placeholders.
2. **`bind_param()`** associates variables with those placeholders. `sss` means three strings; other type letters include `i` for integer, `d` for double, and `b` for blob.
3. **`execute()`** runs the prepared statement using the bound values.

Values are passed separately from SQL syntax, so an apostrophe in a username remains part of that value. The number and order of type letters, variables, and placeholders must agree. Placeholders are not surrounded by quotes and cannot stand in for table or column names. Bound variables are passed by reference, so provide variables rather than expressions such as `trim($email)`. See the [PHP prepared statements guide](https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php).

Prepared statements do not validate email syntax or hash passwords; those remain separate application responsibilities.

## 8. A complete teaching implementation of `signUp()`

The following is a **teaching replacement** for `class/Authenticate.php`, not a verbatim copy of the repository. It uses the Section 2 practice schema and the existing `App\DB` class. It returns an error message to the page so the page can render it inside the HTML body. On success it redirects before printing anything.

The signature is `?string`: the method returns either a string or `null`. This intentionally differs from the repository's `void` method. Use the matching page example immediately below if you try this version.

```php
<?php
namespace App;

class Authenticate
{
    public function signUp(): ?string
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            return null;
        }

        foreach (['username', 'email', 'password', 'confirm_password'] as $field) {
            if (!isset($_POST[$field]) || !is_string($_POST[$field])) {
                return 'Please provide all required fields.';
            }
        }

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($username === '' || $email === '' || $password === '') {
            return 'Username, email, and password are required.';
        }

        // Byte-based limits here are conservative for the practice columns.
        if (strlen($username) > 100 || strlen($email) > 255) {
            return 'Username or email is too long.';
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return 'Enter a valid email address.';
        }

        if ($password !== $confirmPassword) {
            return 'Passwords do not match.';
        }

        // Bcrypt, the current PASSWORD_DEFAULT, has a 72-byte input limit.
        if (strlen($password) > 72 || str_contains($password, "\0")) {
            return 'Password must be at most 72 bytes and contain no null byte.';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Make database errors throw exceptions consistently.
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $myDB = new DB();
            $myDB->connection->set_charset('utf8mb4');

            $stmt = $myDB->connection->prepare(
                'INSERT INTO `user` (`username`, `email`, `password`) '
                . 'VALUES (?, ?, ?)'
            );
            $stmt->bind_param('sss', $username, $email, $hashedPassword);
            $stmt->execute();
            $stmt->close();
        } catch (\mysqli_sql_exception $exception) {
            // In the practice schema, this insert's duplicate value is email.
            if ((int) $exception->getCode() === 1062) {
                return 'That email is already registered.';
            }

            return 'Registration could not be completed. Please try again later.';
        }

        header('Location: SignIn.php?successSignUp=1', true, 303);
        exit;
    }
}
```

This example requires PHP 8 or newer because it uses `str_contains()`. `strlen()` counts bytes, so the example's username limit can be stricter than the database's character limit for Unicode text. The password byte limit avoids silent truncation with bcrypt; review that validation if you change the hashing algorithm. The [password hashing reference](https://www.php.net/manual/en/function.password-hash.php) documents bcrypt's input limit.

The `try` block covers connection creation and insertion. A duplicate email gets specific feedback; other database errors get a general message rather than exposing database details to the page. These checks make the lesson reproducible, but this remains a classroom registration example, not a complete deployed account system.

### Matching sign-up page

**Teaching example — complete minimal `pages/SignUp.php` for the class above:**

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

$auth = new \App\Authenticate();
$error = $auth->signUp();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body>
<main class="container mt-4">
    <h1>Create an account</h1>

    <?php
    if ($error !== null) {
        \App\Alert::printMessage($error, 'danger');
    }
    ?>

    <form method="post">
        <label for="username">Username</label>
        <input class="form-control" id="username" name="username"
               type="text" autocomplete="username" required>

        <label for="email">Email</label>
        <input class="form-control" id="email" name="email"
               type="email" autocomplete="email" required>

        <label for="password">Password</label>
        <input class="form-control" id="password" name="password"
               type="password" autocomplete="new-password" required>

        <label for="confirm_password">Confirm password</label>
        <input class="form-control" id="confirm_password" name="confirm_password"
               type="password" autocomplete="new-password" required>

        <button class="btn btn-primary mt-3" type="submit"
                name="signUpBtn" value="1">Sign up</button>
    </form>
</main>
</body>
</html>
```

Processing occurs before `<!doctype html>`. An invalid submission returns a message, which is printed inside `<main>`. A valid submission redirects and exits before rendering this page.

## 9. Redirecting after registration

```php
header('Location: SignIn.php?successSignUp=1', true, 303);
exit;
```

`header()` sends an HTTP response header. Here, `Location` identifies the destination and `303` instructs the browser to retrieve it after the POST. This is the **Post/Redirect/Get** pattern: refreshing the destination page does not ordinarily resubmit the registration form.

Headers must be sent before response output. `echo`, `var_dump()`, HTML, or accidental whitespace before the opening PHP tag can cause “headers already sent.” `exit` stops the script because `header()` alone does not stop subsequent PHP instructions. See the [PHP header reference](https://www.php.net/manual/en/function.header.php).

The query string `?successSignUp=1` is a signal that the next page can use to show feedback. Anyone can type it into the URL, so it is not proof of registration or authentication. Reading it to display a success alert is a Section 6 topic.

The relative destination works here because the request page and destination both live in `pages/`. Redirect resolution follows the request URL, not the directory containing the class file.

## 10. Setting up the sign-in frontend

The repository does not currently contain `pages/SignIn.php`. To try the redirect locally, create a destination page first. At this stage, it only needs the frontend; verifying credentials belongs to the next section.

**Teaching example — frontend-only `pages/SignIn.php`:**

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body>
<main class="container mt-4">
    <h1>Sign in</h1>
    <p>Layout preview: login processing will be added in the next section.</p>

    <form method="post">
        <label for="email">Email</label>
        <input class="form-control" id="email" name="email"
               type="email" autocomplete="username" required>

        <label for="password">Password</label>
        <input class="form-control" id="password" name="password"
               type="password" autocomplete="current-password" required>

        <button class="btn btn-primary mt-3" type="submit"
                name="signInBtn" value="1" disabled>Sign in</button>
    </form>
    <a href="SignUp.php">Create an account</a>
</main>
</body>
</html>
```

The button is deliberately disabled in this preview because no login handler is provided. Reaching this page after registration demonstrates the redirect; it does not mean the user is signed in.

## 11. Walkthrough checks

If you choose to try the teaching implementation, use a local practice database and the matching class/page examples together. These are checks for students to perform, not claims that the repository already passes them.

| Action | Expected result |
| --- | --- |
| Open `SignUp.php` normally | Form appears; no user is inserted |
| Submit different passwords | “Passwords do not match”; no insert |
| Submit an invalid email directly, bypassing browser validation | Backend rejects the format |
| Submit valid new account details | One user is inserted and the browser redirects |
| Inspect the stored password locally | Encoded hash, not the submitted password |
| Register the same email again | Duplicate-email feedback; no second account |
| Use an apostrophe in a valid username | Stored as data without breaking the SQL statement |
| Refresh the destination page | No repeated registration POST |

To inspect account identifiers without displaying password hashes:

```sql
SELECT `id`, `username`, `email` FROM `user` ORDER BY `id` DESC;
```

## Common mistakes

- **Hashing before comparing passwords:** compare original password strings first; separate salted hashes need not match.
- **Using `isset()` as full validation:** empty strings can still be set.
- **Binding the wrong number of values:** each `?` needs one corresponding variable and type letter.
- **Using a short password column:** a truncated hash may fail verification later.
- **Printing success before redirecting:** send the redirect before output; display feedback on the destination instead.
- **Expecting `execute()` always to return false on failure:** with strict MySQLi reporting, failures throw exceptions.
- **Redirecting to an absent page:** create the frontend destination before testing the outlined redirect.

## Practice and answers

1. Why is `Alert::printMessage()` called with `::`, while `$auth->signUp()` uses `->`?
2. What does `'sss'` describe in `bind_param()`?
3. Why should the insert specify column names?
4. Why does `header('Location: ...')` need `exit` afterward?
5. Can `?successSignUp=1` be used to decide that a visitor is signed in?

**Answers:** (1) The alert method is static; `signUp()` is an instance method. (2) Three parameters, all bound as strings. (3) It makes the mapping explicit and avoids depending on the entire table's column order. (4) Sending a header does not stop execution. (5) No; visitors can supply query parameters themselves, and authentication must be established by backend logic.

**End-of-section checkpoint:** You can explain every stage from the submitted HTML form to a stored account and the subsequent redirect, including why validation, hashing, SQL binding, and HTML escaping are separate operations.
