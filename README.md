# Database Management | Week: PHP Login / Logout + GitHub

## Based on last week's Resume CRUD Lab

This code extends the previous CRUD project, retaining `skills.php`, `skill_create.php`, `skill_edit.php`, `skill_delete.php` and `index.php`.

### Setup (local XAMPP / Angsila)
1. Backup the existing MySQL database in phpMyAdmin first.
2. Keep previous tables `profile`, `education`, `skill`, `training`. **Do not re-import the previous setup.sql**: it contains DROP TABLE commands.
3. In phpMyAdmin, select your existing database and run `database/this_week_migration.sql` (creates `users` only).
4. Configure `config/db.php` using your assigned MySQL credentials and database name (use environment variables on shared servers).
5. Upload files to a dedicated folder on web server (for Angsila, follow instructor's permitted deployment path).
6. Open `register.php`, sign up with a unique email and password >= 10 characters.
7. Open `login.php` (on Angsila: `https://angsila.informatics.buu.ac.th/~<student_id>/<project_folder>/`; make sure `index.php` is in that folder, not in a nested copy) then test `skills.php`, `skill_create.php`, `skill_edit.php`, `skill_delete.php`, `index.php`, `logout.php`.
8. All new accounts get their own profile; earlier demo skill records remain in the original profile and do not appear for new users.

### Implemented features (Lab tasks TODO 1-6: completed)
- `login.php`: looks up the user by email with a prepared statement (`SELECT id, profile_id, password_hash FROM users WHERE email = ? LIMIT 1`), checks the password with `password_verify()`, and shows one generic error ("Invalid email or password.") for any failure.
- On success: `session_regenerate_id(true)`, store `user_id` / `profile_id` / `email` in `$_SESSION`, redirect to `skills.php`.
- `logout.php`: POST + CSRF token check, clears `$_SESSION`, expires the session cookie, calls `session_destroy()`, redirects to `login.php?logged_out=1`.

### Login / logout flow (Session explanation)
1. The browser submits email + password (with a CSRF token) to `login.php`.
2. The server finds the user and verifies the password hash. If valid, it creates a fresh session ID and stores the user's identity on the server side; the browser only keeps the session cookie (HttpOnly, SameSite=Lax).
3. Every private page calls `require_login()` from `auth.php`; without a session it redirects to `login.php`.
4. All CRUD queries filter by `profile_id` from the session, so each user only sees and changes their own data.
5. Logout destroys the server session and the cookie, so Back/refresh no longer reaches private pages.

### Test cases
1. Unauthenticated access to `skills.php`, `index.php` or create/edit/delete redirects to login.
2. Existing account correct password logs in; incorrect password fails.
3. Logout prevents access to private pages, even with browser Back/refresh.
4. Two different registered users cannot view/update/delete each other's skills.
5. Create → Edit → Delete after login works correctly.
6. SQL injection string in email must not bypass login.
7. Repository does not contain a real DB password or `.env` file.

### Git/GitHub evidence
`git init` → `git add .` → `git commit -m "Add PHP session login"` → `git branch -M main` → `git remote add origin <URL>` → `git push -u origin main`.
For an existing repository, simply commit and push updates. Commit at least twice with meaningful messages. Avoid uploading secrets. Include screenshots (register, successful login, failed login, CRUD, logout) in your report, not database passwords.

### Security note
Teaching lab only. HTTPS is recommended on shared Angsila hosting. Authenticator uses password hashing, prepared statements, session rotation, owner-scoped CRUD, and POST+CSRF logout; production apps also require throttling, session timeouts, centralized permissions, HTTPS enforcement and monitoring.

### Deliverables
A. GitHub repository (source excluding secrets)  B. Running Angsila URL or instructor-approved local demonstration  C. Screenshot evidence  D. Short explanation of Session and login/logout flow.

### Status
**COMPLETED**: login/logout implemented (TODO 1-6). Remaining steps are deployment, testing and evidence (screenshots, GitHub commits).