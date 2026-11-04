# Section 1 — How the Web Works

[Documentation index](README.md) · [Next: Section 2](Section%20%232.md)

**Based on:** [Section 1 outline](../Sections%20Content/Section%20%231.md).

## Learning outcomes

By the end of this section, you should be able to describe what happens when you open a website, distinguish frontend work from backend work, explain the role of a database, and identify the background knowledge needed for the course.

## 1. Client–server architecture

A **client** requests a service. A **server** provides that service. When you open a website, your browser acts as the client and the computer running the website responds as the server.

These names describe roles. The same computer can run both a browser and a local web server, which is what you will do with Laragon. A server can also become a client when it requests information from another server.

```text
Browser                 Web server / PHP               Database server
   | GET sign-up page          |                              |
   |-------------------------->|                              |
   | HTML response             |                              |
   |<--------------------------|                              |
   | POST completed form       |                              |
   |-------------------------->| INSERT validated user        |
   |                           |----------------------------->|
   |                           | Success or failure           |
   |                           |<-----------------------------|
   | Response / redirect       |                              |
   |<--------------------------|                              |
```

Notice that the browser does not normally connect directly to the application's database. Backend code decides what data the client may read or change.

### Server properties

A server needs a reachable address, software listening for requests, and enough CPU, memory, storage, and network capacity to handle its workload. A **port** identifies a service at an address: HTTP commonly uses port 80 and HTTPS port 443.

For a public application, availability, concurrent requests, access control, logging, and backups matter. A server is not necessarily a special physical machine: it may run on a laptop, a dedicated machine, or a virtual machine in the cloud. In development, `localhost` refers to your own computer.

## 2. What the browser does

A browser has two important responsibilities in this course:

1. **Communicate using HTTP or HTTPS.** It sends requests and receives responses. It may request an HTML document first, then request the CSS, JavaScript, images, and fonts referenced by that document.
2. **Render the interface.** It interprets HTML as page structure, applies CSS for appearance and layout, and executes JavaScript for behavior.

For example, HTML defines a sign-up button, CSS gives it a color and size, and JavaScript could show or hide the password field. PHP runs on the server; the browser receives the output PHP produces, not normally its source code.

## 3. HTTP requests and responses

**HTTP** means Hypertext Transfer Protocol. It defines how clients and servers exchange messages. A request contains a method, a target path, headers, and sometimes a body. A response contains a status, headers, and sometimes a body.

The following is a simplified HTTP/1.1 exchange for illustration. The browser handles the actual protocol details.

```http
GET /IA_HU_2026/pages/index.php HTTP/1.1
Host: localhost
Accept: text/html
```

- `GET` asks to retrieve a resource.
- `/IA_HU_2026/pages/index.php` identifies the requested path.
- `Host` identifies the target host.
- `Accept` describes a response format the client understands.

An illustrative response is:

```http
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8

<h1>Welcome to Journaling</h1>
```

The blank line separates headers from the body. The body here is HTML, but responses can also contain JSON, images, files, or no body at all.

### The three status codes to recognize first

| Status | Meaning | Example in this project |
| --- | --- | --- |
| `200 OK` | The HTTP request succeeded | The server returns the sign-up page |
| `404 Not Found` | The requested resource could not be found | You request a PHP filename that does not exist |
| `500 Internal Server Error` | The server encountered an unexpected failure | A server-side error prevents normal processing |

A `200` response does not necessarily mean the user's action succeeded. A form page can return HTTP 200 while displaying “Passwords do not match.” Conversely, not every PHP warning becomes HTTP 500; the response depends on application and server behavior.

## 4. DNS and the journey to a website

**DNS**, the Domain Name System, resolves names such as `example.com` to records including IP addresses. People remember names more easily than numeric network addresses.

A simplified visit to a public HTTPS site looks like this:

1. You enter a URL in the browser.
2. The browser and operating system obtain the host's IP address, possibly using a cached DNS result.
3. The browser establishes a connection and negotiates TLS for HTTPS.
4. It sends an HTTP request.
5. The server processes the request and sends a response.
6. The browser renders the response and requests any additional assets it needs.

DNS resolves the hostname; it does not execute PHP or find a particular page inside your project. The path after the hostname is handled by the web server and application. Local names such as `localhost` can be resolved locally without a public DNS lookup.

## 5. Different server roles

| Server role | Purpose | Typical interaction |
| --- | --- | --- |
| Web server | Serves web content using HTTP/HTTPS | A browser requests a page |
| DNS server | Answers queries about domain names | A resolver asks for a host's address |
| FTP server | Transfers files using the File Transfer Protocol | A client uploads or downloads a file |
| SMTP server | Sends or relays email using the Simple Mail Transfer Protocol | An application submits an outgoing email |

SMTP handles sending and relaying email; reading a mailbox commonly uses other protocols such as IMAP. Ordinary FTP does not encrypt traffic; SFTP is a different protocol using SSH.

### Apache and Nginx

Apache HTTP Server and Nginx are **web server software**. They accept web requests and can serve static assets. With suitable configuration, they pass PHP processing to a PHP runtime and return its output.

Distinguish the layers: Laragon manages your local environment, Apache or Nginx handles web requests, the PHP engine executes PHP, and a database engine stores and queries persistent data.

## 6. Why organizations use information systems

An information system combines people, processes, data, and technology to support work. Organizations introduce these systems to reduce repeated manual work, make records easier to find, coordinate departments, and produce useful reports.

For example, a paper task notebook is difficult to share and search. A journaling application can associate tasks with users, show unfinished work, and preserve records after the browser closes. Its value comes from supporting the organization's workflow and maintaining reliable data, not merely from having a website.

## 7. Frontend and backend

| Aspect | Frontend | Backend |
| --- | --- | --- |
| Main responsibility | Present the interface and handle user interaction | Enforce rules, process requests, and access data |
| Typical execution location | Browser | Server |
| Course technologies | HTML, CSS, JavaScript, Bootstrap | PHP and MySQL-compatible database access |
| Sign-up example | Show the form and a helpful email input | Validate submitted values and store a password hash |

Other backend technologies include Python, Java, C#, and JavaScript running with Node.js. SQL is a language used to interact with relational databases; MySQL and MariaDB are database systems.

Frontend checks improve usability, but backend checks remain necessary. A user can bypass the normal form and send a request directly, so the backend must not trust input just because it came from a browser.

## 8. Relational and non-relational databases

A **relational database** organizes data into tables with rows and columns. A primary key identifies a row. Foreign keys can connect related rows in different tables.

For Journaling, a user table could contain account records, and a task table could contain tasks linked to users. One user may own many tasks. SQL lets you insert, select, update, and delete these records.

**Non-relational databases** use other data models, such as documents, key–value pairs, graphs, or wide-column records. They are not simply “databases with no structure.” Their models and validation rules depend on the database and application.

| Model | Example organization of data | Useful way to think about it |
| --- | --- | --- |
| Relational | User and task tables connected by IDs | Rows with explicit relationships |
| Document | A JSON-like document with fields and nested values | Related information grouped as a document |
| Key–value | A key maps to a value | Look up a value by its identifier |

This course uses a relational approach because users, tasks, and their relationships fit naturally into tables.

## 9. Knowledge to bring into the course

- **Programming 1:** variables, operators, conditions, loops, arrays, and functions. You will use them to read inputs, make decisions, and process data.
- **Programming 2:** the difference between a class and an object. You will create objects such as a database helper.
- **Basic SQL:** understand `SELECT`, `INSERT`, `UPDATE`, `DELETE`, and `WHERE`.
- **Basic HTML:** understand elements, attributes, links, and forms.

You do not need to memorize every PHP function before beginning. You should be able to trace a small program and explain which instruction runs next.

## Common misconceptions

- **“The browser runs PHP.”** It normally runs the HTML/CSS/JavaScript returned after the server executes PHP.
- **“DNS is where the website files are stored.”** DNS provides naming information; the web server serves the website.
- **“A database GUI is the database.”** A GUI is a tool that communicates with a separate database engine.
- **“A working form means the backend is complete.”** A form only collects values; backend code must validate and process them.

## Practice and answers

1. You request `missing.php` and receive 404. Which layer should you investigate first?
2. A sign-up page looks correct, but no account is saved. Is the frontend alone enough to explain the problem?
3. Why should tasks store a user's ID instead of copying all user details into every task?

**Answers:** (1) Check the requested path and how the web server maps it to files or routes. (2) No; inspect the form submission, backend processing, and database result. (3) An ID establishes the relationship and avoids duplicating user details across many records.

**Ready for Section 2:** You can trace a browser request through the server and database and explain what each layer contributes.
