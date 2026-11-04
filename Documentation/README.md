# Internet Applications — Student Documentation

These guides explain **Sections 1–5** of the course. Read them in order: each lesson introduces the ideas needed by the next one. They expand the topic lists in [Sections Content](../Sections%20Content/) into explanations, worked examples, troubleshooting notes, and practice questions with answers.

| Guide | What you will learn |
| --- | --- |
| [Section 1 — How the Web Works](Section%20%231.md) | Clients, servers, HTTP, DNS, frontend, backend, and databases |
| [Section 2 — Local Environment and First PHP Page](Section%20%232.md) | Laragon, PHP execution, phpMyAdmin, and the project database |
| [Section 3 — Structure, Classes, and Autoloading](Section%20%233.md) | Bootstrap, includes, paths, PHP objects, Composer, and `DB` |
| [Section 4 — Arrays, Forms, and Request Data](Section%20%234.md) | Arrays, superglobals, GET/POST, HTTPS, and the sign-up form |
| [Section 5 — Saving a New User](Section%20%235.md) | Validation, static alerts, password hashes, prepared statements, and redirects |

## How to use the examples

- Code snapshots are selectable, syntax-highlighted code blocks. Their captions identify whether they come from the repository or are teaching examples.
- Examples that name a file show where the code belongs **if you choose to try it**. Reading these guides does not require replacing the application files.
- The project directory in this checkout is `IA_HU_2026`, although the Section 2 outline calls it `IA`. Use your actual directory name in browser URLs.
- The real shared navbar is `pages/Layout/navbar.php`. Match that spelling and capitalization, especially on case-sensitive systems.
- The database name in `class/DB.php` is `ia_sections_hu`. There is no database export or full schema in this checkout. Section 2 therefore supplies an explicitly labeled **practice schema**, used consistently by the later teaching examples.
- The repository currently displays an alert after sign-up. Section 5 explains the outlined redirect as a teaching extension. `pages/SignIn.php` is not present in the checkout; a frontend-only example is included in that guide.

Start with the learning outcomes, follow the walkthrough, and then attempt the practice before reading its answers. The guides stop at Section 5; implementing login, sessions, and task CRUD belongs to later sections.
